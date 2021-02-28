<?php

declare(strict_types=1);
session_start();
function obtenerPdoConexionBD(): PDO
{
    $servidor = "localhost";
    $bd = "MiniFb";
    $identificador = "root";
    $contrasenna = "";
    $opciones = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
    } catch (Exception $e) {
        error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
        exit('Error al conectar'); //something a user can understand
    }

    return $conexion;
}

function crearUsuario($usuario, $contrasenna, $nombre, $apellidos)
{
    $pdo = obtenerPdoConexionBD();
    $sql = "SELECT * FROM Usuario WHERE identificador=?";
    $sentencia= $pdo->prepare($sql);
    //$sqlExito = $sentencia->execute([$identificador]);

    $rs = $sentencia->fetchAll();

    if(!$rs[0]) {
        $sql= "INSERT INTO usuario(identificador, contrasenna, nombre, apellidos) VALUES(?, ?, ?, ?)";
        $sentencia = $pdo->prepare($sql);
        $sqlExito = $sentencia->execute([$usuario, $contrasenna, $nombre, $apellidos]);
    }else {
        redireccionar("UsuarioNuevoFormulario.php?error");
    }
}

function obtenerUsuario(string $identificador, string $contrasenna): ?array
{
    $pdo = obtenerPdoconexionBD();

    $sql= "SELECT * FROM Usuario WHERE identificador=? AND contrasenna=?";
    $sentencia=$pdo->prepare($sql);
    $sqlConExito = $sentencia->execute([$identificador,$contrasenna]);

    $correcto = ($sqlConExito && $sentencia->rowCount()==1);

    $rs = $sentencia->fetchAll();

    if($correcto) {
        return ["id" => $rs[0]["id"], "identificador" => $rs[0]["identificador"],"contrasenna" => $rs[0]["contrasenna"],
            "codigoCookie" => $rs[0]["codigoCookie"], "tipoUsuario" => $rs[0]["tipoUsuario"], "nombre" => $rs[0]["nombre"],
            "apellidos" => $rs[0]["apellidos"]];
    }else
        return null;
}

function marcarSesionComoIniciada($arrayUsuario)
{
    // TODO Anotar en el post-it todos estos datos:
    // $_SESSION["id"] = ...
    // $_SESSION["identificador"] = ...
    // ...

    $_SESSION["id"] = $arrayUsuario["id"];
    $_SESSION["identificador"] = $arrayUsuario["identificador"];
    $_SESSION["contrasenna"] = $arrayUsuario["contrasenna"];
    $_SESSION["tipoUsuario"] = $arrayUsuario["tipoUsuario"];
    $_SESSION["nombre"] = $arrayUsuario["nombre"];
    $_SESSION["apellidos"] = $arrayUsuario["apellidos"];


}

function haySesionIniciada(): ?bool
{
    // TODO Pendiente hacer la comprobación.
    if(isset($_SESSION["id"])) {
        $conectado = true;
    }else {
        $conectado = false;
    }

    return $conectado;

    // Está iniciada si isset($_SESSION["id"])

}

function cerrarSesion()
{
    session_destroy();
    unset($_SESSION["id"]);
    // TODO session_destroy() y unset de $_SESSION (por si acaso).
}

// (Esta función no se utiliza en este proyecto pero se deja por si se optimizase el flujo de navegación.)
// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}