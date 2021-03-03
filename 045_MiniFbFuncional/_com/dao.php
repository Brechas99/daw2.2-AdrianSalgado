<?php
require_once "_Varios.php";
require_once "clases.php";

session_start();

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "minifb";
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
        if (!isset(Self::$pdo)) Self::$pdo = Self::obtenerPdoConexionBd();

        $select = Self::$pdo->prepare($sql);
        $select->execute($parametros);
        return $select->fetchAll();
    }

    private static function ejecutarActualizacion(string $sql, array $parametros): bool
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        return $sqlConExito;
    }


    /* SESIONES */

    public static function establecerSesionRam(array $arrayUsuario)
    {
        // Anotar en el post-it como mínimo el id.
        $_SESSION["id"] = $arrayUsuario["id"];

        // Además, podemos anotar todos los datos que podamos querer tener a mano, sabiendo que pueden quedar obsoletos...
        $_SESSION["identificador"] = $arrayUsuario["identificador"];
        $_SESSION["tipoUsuario"] = $arrayUsuario["tipoUsuario"];
        $_SESSION["nombre"] = $arrayUsuario["nombre"];
        $_SESSION["apellidos"] = $arrayUsuario["apellidos"];
    }

    public static function haySesionRamIniciada(): bool
    {
        return isset($_SESSION["id"]);
    }

    public static function destruirSesionRamYCookie()
    {
        session_destroy();
       // actualizarCodigoCookieEnBD(Null);
        borrarCookies();
        unset($_SESSION); // Por si acaso
    }

    public static function  pintarInfoSesion() {
        if (dao::haySesionRamIniciada()) {
            echo "<span>Sesión iniciada por <a href='UsuarioPerfilVer.php'>$_SESSION[identificador]</a> ($_SESSION[nombre] $_SESSION[apellidos]) <a href='SesionCerrar.php'>Cerrar sesión</a></span>";
        } else {
            echo "<a href='SesionInicioFormulario.php'>Iniciar sesión</a>";
        }
    }




    // ***USUARIO** //

    public static function usuarioFicha($id): array
    {
        $nuevaEntrada = ($id == -1);
        if ($nuevaEntrada) {
            $usuarioIdentificador= "<introduzca identificador>";
            $usuarioContrasenna= "<introduzca contrasenna>";
            $usaurioNombre = "<introduzca nombre>";
            $usuarioApellidos= "<introduzca apellidos>";

            return [$nuevaEntrada, $usuarioIdentificador, $usuarioContrasenna, $usaurioNombre, $usuarioApellidos];
        } else {
            $rs= self::ejecutarConsulta(
                "SELECT * FROM Usuario WHERE id=?",
                [$id]
            );
            return [$nuevaEntrada, $rs[0]["identificador"], $rs[0]["contrasenna"], $rs[0]["nombre"], $rs[0]["apellidos"]];
        }
    }

    public static function usuarioModificar(int $id,string $identificador, string $contrasenna, string $codigoCookie, string $caducidadCodigoCookie, int $tipoUsuario, string $nombre, string $apellidos): bool
    {
        return self::ejecutarActualizacion(
            "UPDATE Usuario SET identificador=?, contrasenna=?, codigoCookie=?, caducidadCodigoCookie=?, tipoUsuario=?, nombre=?, apellidos=? WHERE id=?",
            [$identificador, $contrasenna, $codigoCookie, $caducidadCodigoCookie, $tipoUsuario, $nombre, $apellidos, $id]
        );
    }

    public static function crearUsuario(string $identificador, string $contrasenna, string $codigoCookie, string $caducidadCodigoCookie, int $tipoUsuario, string $nombre, string $apellidos): bool
    {
        $rs = self::ejecutarConsulta(
            "INSERT INTO usuario (identificador, contrasenna, codigoCookie, caducidadCodigoCookie, tipoUsuario, nombre, apellidos) VALUES (?,?,?,?,?,?,?)",
            [$identificador, $contrasenna, $codigoCookie, $caducidadCodigoCookie, $tipoUsuario, $nombre, $apellidos]
        );
    }


    private static function usuarioCrearDesdeRS(array $usuario): usuario
    {
        return new usuario($usuario["id"], $usuario["identificador"],$usuario["contrasenna"], $usuario["nombre"], $usuario["apellidos"], $usuario["codigoCookie"]);
    }

    public static function obtenerUsuarioPorContrasenna(string $identificador, string $contrasenna): ?array
    {
        $conexion = obtenerPdoConexionBD();

        $sql = "SELECT * FROM Usuario WHERE identificador=? AND BINARY contrasenna=?";
        $select = $conexion->prepare($sql);
        $select->execute([$identificador, $contrasenna]);
        $rs = $select->fetchAll();

        // $rs[0] es la primera (y esperemos que única) fila que ha podido venir. Es un array asociativo.
        return $select->rowCount()==1 ? $rs[0] : null;
    }

    public static function usuarioObtenerPorId(int $id): ?Usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Usuario WHERE id=?",
            [$id]
        );
        if ($rs) return self::usuarioCrearDesdeRs($rs[0]);
        else return null;
    }


    /* PUBLICACION */

    private static function publicacionCrearDesdeRs(array $fila): Publicacion
    {
        if(isset($fila["destacadoHasta"]) && $fila["destacadoHasta"] == null)
            $fila["destacadoHasta"] = "";
        return new Publicacion($fila["id"], $fila["fecha"], $fila["emisorId"], $fila["destinatarioId"], $fila["destacadoHasta"], $fila["asunto"], $fila["contenido"]);
    }

    public static function publicacionObtenerPorId(int $id): ?Publicacion
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Publicacion WHERE id=?",
            [$id]
        );
        if ($rs) return self::publicacionCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function publicacionActualizar(int $id, string $fecha, int $emisorId, int $destinatarioId, string $destacadoHasta, string $asunto, string $contenido)
    {
        self::ejecutarActualizacion(
            "UPDATE Publicacion SET fecha=?, emisorId=?, destinatarioId=?, destacadoHasta=?, asunto=?, contenido=? WHERE id=?",
            [$fecha, $emisorId, $destinatarioId, $destacadoHasta, $asunto, $contenido, $id]
        );
    }

    public static function publicacionCrear(string $fecha, int $emisorId, int $destinatarioId, string $destacadoHasta, string $asunto, string $contenido): bool
    {
        if($destacadoHasta == null)
            $destacadoHasta= "";
        return self::ejecutarActualizacion(
            "INSERT INTO Publicacion (fecha, emisorId, destinatarioId, destacadoHasta, asunto, contenido) VALUES (?, ?, ?, ?, ?, ?)",
            [$fecha, $emisorId, $destinatarioId, $destacadoHasta, $asunto, $contenido]
        );
    }

    public static function publicacionObtenerTodas($posibleClausulaWhere): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Publicacion $posibleClausulaWhere ORDER BY fecha DESC",
            []
        );

        foreach ($rs as $fila) {
            $publicacion = self::publicacionCrearDesdeRs($fila);
            array_push($datos, $publicacion);
        }

        return $datos;
    }
    public static function eliminarPublicacionPorId(int $id): bool
    {

        $sql = "DELETE FROM Publicacion WHERE id=?";

        return self::ejecutarActualizacion($sql, [$id]);
    }

    public static function publicacionGuardarPorId(int $id, string $fecha, int $emisorId, int $destinatarioId, string $destacadoHasta, string $asunto, string $contenido): bool
    {
        return self::ejecutarActualizacion(
            "UPDATE Publicacion SET fecha=?, emisorId=?, destinatarioId=?, destacadaHasta=?, asunto=?, contenido=? WHERE id=?",
            [$fecha, $emisorId, $destinatarioId, $destacadoHasta, $asunto, $contenido, $id]
        );
    }

    public static function publicacionFicha($id): array
    {
        $nuevaEntrada = ($id == -1);
        if ($nuevaEntrada) {
            $fecha= "<introduzca fecha>";
            $emisorId= "<introduzca emisorId>";
            $destinatarioId = "<introduzca destinatarioId>";
            $destacadoHasta= "<introduzca destacadoHasta>";
            $asunto= "<introduzca asunto>";
            $contenido= "<introduzca contenido>";

            return [$nuevaEntrada, $fecha, $emisorId, $destinatarioId, $destacadoHasta, $asunto, $contenido];
        } else {
            $rs= self::ejecutarConsulta(
                "SELECT * FROM Publicacion WHERE id=?",
                [$id]
            );
            return [$nuevaEntrada, $rs[0]["fecha"], $rs[0]["emisorId"], $rs[0]["destinatarioId"], $rs[0]["destacadaHasta"], $rs[0]["asunto"], $rs[0]["contenido"]];
        }
    }


    /*COOKIES*/

    public static function establecerSesionCookie(array $arrayUsuario)
    {
        // Creamos un código cookie muy complejo (no necesariamente único).
        $codigoCookie = generarCadenaAleatoria(32); // Random...

        // actualizarCodigoCookieEnBD($codigoCookie);

        // Enviamos al cliente, en forma de cookies, el identificador y el codigoCookie:
        setcookie("identificador", $arrayUsuario["identificador"], time() + 600);
        setcookie("codigoCookie", $codigoCookie, time() + 600);
    }

    function borrarCookies()
    {
        setcookie("identificador", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
        setcookie("codigoCookie", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.}
    }




}
