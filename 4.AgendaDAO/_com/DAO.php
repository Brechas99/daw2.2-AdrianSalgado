<?php

require_once "Clases.php";
require_once "Varios.php";

class
DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "Agenda"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - 0, 1 u otro número positivo: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return $actualizacion->rowCount();
    }



    /* CATEGORÍA */

    private static function crearCategoriaDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }

    public static function categoriaObtenerPorId(int $id): ?Categoria
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria WHERE id=?",
            [$id]
        );
        if ($rs) return self::crearCategoriaDesdeRs($rs[0]);
        else return null;
    }

    public static function categoriaActualizar($id, $nombre)
    {
        self::ejecutarActualizacion(
            "UPDATE Categoria SET nombre=? WHERE id=?",
            [$nombre, $id]
        );
    }

    public static function categoriaCrear(string $nombre)
    {
        self::ejecutarActualizacion(
            "INSERT INTO Categoria (nombre) VALUES (?)",
            [$nombre]
        );
    }

    public static function categoriaObtenerTodas(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $categoria = self::crearCategoriaDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }

    public static function categoriaEliminar(int $id): ?int
    {
        $resultado = self::ejecutarActualizacion(
            "DELETE FROM Categoria WHERE id=?",
            [$id]
        );

        return $resultado;
    }



    /* PERSONA */

    public static function crearPersonaDesdeRs(array $fila): Persona
    {
        return new Persona($fila["id"], $fila["nombre"], $fila["apellidos"], $fila["telefono"], $fila["estrella"], $fila["categoriaId"]);
    }

    public static function personaObtenerTodas():array
    {
        $datos=[];
        $consulta= self::ejecutarConsulta("SELECT
                    p.Id     AS id,
                    p.categoriaId   AS categoriaId,
                    p.nombre AS nombre,
                    p.apellidos AS apellidos,
                    p.telefono AS telefono,
                    p.estrella AS estrella,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   persona p, categoria c
                   WHERE p.categoriaId = c.id
                   
                ORDER BY p.nombre" , [] );

        foreach ($consulta as $fila){
            $persona= self:: crearPersonaDesdeRs($fila);
            array_push($datos, $persona);
        }
        return $datos;
    }

    public static function personaObtenerPorId(int $id): ?Persona
    {
        $rs= self::ejecutarConsulta("SELECT * FROM Persona WHERE id=?",[$id]);
        if($rs) return self:: crearPersonaDesdeRs($rs[0]);
        else return null;
    }

    public static function personaCrear(string $nombre, string $apellidos, string $telefono, bool $estrella, int $personaCategoriaId): bool
    {
        $consulta=self::ejecutarActualizacion("INSERT INTO Persona (nombre,apellidos,telefono, estrella, categoriaId) VALUES (?,?,?,?,?)",[$nombre, $apellidos, $telefono,$estrella, $personaCategoriaId]);
        return $consulta;
    }

    public static function personaModificar($id, $nombre, $apellidos, $telefono, $estrella, $personaCategoriaId): bool
    {
        $consulta= self::ejecutarActualizacion("UPDATE Persona SET nombre=?, apellidos=?, telefono=?, estrella=?, categoriaId=? WHERE id=?",[$nombre, $apellidos,$telefono, $estrella, $personaCategoriaId, $id]);
        return $consulta;
    }

    public static function personaEliminar(int $id): ?int
    {
        $resultado= self::ejecutarActualizacion("DELETE FROM Persona WHERE id=?",[$id]);
        return $resultado;
    }
}
