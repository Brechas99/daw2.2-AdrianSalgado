<?php

require_once "_Varios.php";

$usuario = $_REQUEST["identificador"];
$contrasenna = $_REQUEST["contrasenna"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];

crearUsuario($usuario, $contrasenna, $nombre, $apellidos);
$arrayUsuario = obtenerUsuario($usuario, $contrasenna);

if($arrayUsuario){
    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");
}

?>
