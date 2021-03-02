<?php

require_once "Clases.php";
require_once "Varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "Agenda";
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            echo "\n\nError al conectar:\n" . $e->getMessage();
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
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


    private static function ejecutarInsert(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $insert = self::$pdo->prepare($sql);
        $sqlConExito = $insert->execute($parametros);

        if (!$sqlConExito) return null;
        else return self::$pdo->lastInsertId();
    }


    private static function ejecutarUpdel(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $updel = self::$pdo->prepare($sql);
        $sqlConExito = $updel->execute($parametros);

        if (!$sqlConExito) return null;
        else return $updel->rowCount();
    }



    /* CATEGORÍA */

    private static function categoriaCrearDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }

    public static function categoriaObtenerPorId(int $id): ?Categoria
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria WHERE id=?",
            [$id]
        );

        if ($rs) return self::categoriaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function categoriaObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $categoria = self::categoriaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }

    public static function categoriaCrear(string $nombre): ?Categoria
    {
        $idAutogenerado = self::ejecutarInsert(
            "INSERT INTO Categoria (nombre) VALUES (?)",
            [$nombre]
        );

        if ($idAutogenerado == null) return null;
        else return self::categoriaObtenerPorId($idAutogenerado);
    }

    public static function categoriaActualizar(Categoria $categoria): ?Categoria
    {
        $filasAfectadas = self::ejecutarUpdel(
            "UPDATE Categoria SET nombre=? WHERE id=?",
            [$categoria->getNombre(), $categoria->getId()]
        );

        if ($filasAfectadas = null) return null;
        else return $categoria;
    }

    public static function categoriaEliminarPorId(int $id): bool
    {
        $filasAfectadas = self::ejecutarUpdel(
            "DELETE FROM Categoria WHERE id=?",
            [$id]
        );

        return ($filasAfectadas == 1);
    }

    public static function categoriaEliminar(Categoria $categoria): bool
    {
        return self::categoriaEliminarPorId($categoria->id);
    }


    /* PERSONA */

    private static function personaCrearDesdeRs(array $fila): Persona
    {
        return new Persona($fila["id"], $fila["nombre"], $fila["apellidos"], $fila["telefono"], $fila["estrella"], $fila["categoriaId"]);
    }

    public static function personaObtenerPorId(int $id): ?Persona
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Persona WHERE id=?",
            [$id]
        );

        if ($rs) return self::personaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function personaObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM Persona ORDER BY nombre, apellidos",
            []
        );

        foreach ($rs as $fila) {
            $persona = self::personaCrearDesdeRs($fila);
            array_push($datos, $persona);
        }

        return $datos;
    }

    public static function personaCrear(string $nombre, string $apellidos, string $telefono, bool $estrella, int $categoriaId): ?Persona
    {
        $idAutogenerado = self::ejecutarInsert(
            "INSERT INTO Persona (nombre, apellidos, telefono, estrella, categoriaId) VALUES (?, ?, ?, ?, ?)",
            [$nombre, $apellidos, $telefono, $estrella ? 1 : 0, $categoriaId]
        );

        if ($idAutogenerado == null) return null;
        else return self::personaObtenerPorId($idAutogenerado);
    }

    public static function personaActualizar(Persona $persona): ?Persona
    {
        $filasAfectadas = self::ejecutarUpdel(
            "UPDATE Persona SET nombre=?, apellidos=?, telefono=?, estrella=?, categoriaId=? WHERE id=?",
            [$persona->getNombre(), $persona->getApellidos(), $persona->getTelefono(), $persona->isEstrella() ? 1 : 0, $persona->getCategoriaId(), $persona->getId()]
        );

        if ($filasAfectadas = null) return null;
        else return $persona;
    }

    public static function personaEliminarPorId(int $id): bool
    {
        $filasAfectadas = self::ejecutarUpdel(
            "DELETE FROM Persona WHERE id=?",
            [$id]
        );

        return ($filasAfectadas == 1);
    }

    public static function personaEliminar(Persona $persona): bool
    {
        return self::personaEliminarPorId($persona->id);
    }
}