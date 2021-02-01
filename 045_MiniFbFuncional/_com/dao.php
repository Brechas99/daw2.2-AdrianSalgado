<?php
require_once "_Varios.php";
require_once "clases.php";

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


    // ****SESIONES**** //

    public static function haySesionRamIniciada(): bool
    {
        // Está iniciada si isset($_SESSION["id"])
        return isset($_SESSION["id"]);
    }

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

    public static function  pintarInfoSesion() {
        if (dao::haySesionRamIniciada()) {
            echo "<span>Sesión iniciada por <a href='UsuarioPerfilVer.php'>$_SESSION[identificador]</a> ($_SESSION[nombre] $_SESSION[apellidos]) <a href='SesionCerrar.php'>Cerrar sesión</a></span>";
        } else {
            echo "<a href='SesionInicioFormulario.php'>Iniciar sesión</a>";
        }
    }


    public static function destruirSesionRamYCookie()
    {
        session_destroy();
        actualizarCodigoCookieEnBD(Null);
        borrarCookies();
        unset($_SESSION); // Por si acaso
    }





    // ***COOKIES*** //

    public static function establecerSesionCookie(array $arrayUsuario)
    {
        // Creamos un código cookie muy complejo (no necesariamente único).
        $codigoCookie = generarCadenaAleatoria(32); // Random...

        actualizarCodigoCookieEnBD($codigoCookie);

        // Enviamos al cliente, en forma de cookies, el identificador y el codigoCookie:
        setcookie("identificador", $arrayUsuario["identificador"], time() + 600);
        setcookie("codigoCookie", $codigoCookie, time() + 600);
    }

    public static function actualizarCodigoCookieEnBD(?string $codigoCookie)
    {
        $conexion = obtenerPdoConexionBD();
        $sql = "UPDATE Usuario SET codigoCookie=? WHERE id=?";
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute([$codigoCookie, $_SESSION["id"]]); // TODO Comprobar si va bien con null.

        // TODO Para una seguridad óptima convendría anotar en la BD la fecha de caducidad de la cookie y no aceptar ninguna cookie pasada dicha fecha.
    }



    // ***USUARIO** //

    public static function crearUsuario(string $usuarioCliente, string $contrasenna): ?usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE identificador=? AND contrasenna =?",
            [$usuarioCliente, $contrasenna]
        );
        if ($rs) return self::usuarioCrearDesdeRS($rs[0]);
        else return null;

    }


    private static function usuarioCrearDesdeRS(array $usuario): usuario
    {
        return new usuario($usuario["id"], $usuario["usuarioCliente"],$usuario["contrasenna"], $usuario["codigoCookie"]);
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


    public static function marcarSesionComoIniciada($usuario)
    {

        $_SESSION["id"] = $usuario->getId();
        $_SESSION["usuarioCliente"] = $usuario->getUsuarioCliente();
        $_SESSION["usuarioContrasenna"] = $usuario->getUsuarioContrasenna();
    }

}
