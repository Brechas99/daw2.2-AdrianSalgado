<?php

require_once "_com/dao.php";
require_once "_com/_Varios.php";

// TODO ...$_REQUEST["..."]...
$id= $_SESSION["id"];
$identificador=$_REQUEST["identificador"];
$contrasenna=$_REQUEST["contrasenna"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];

$_SESSION["identificador"] = $identificador;
$_SESSION["nombre"] = $nombre;
$_SESSION["apellidos"] = $apellidos;


if (dao::haySesionRamIniciada()) {
    $correcto= dao::usuarioModificar($id, $identificador, $contrasenna, "", "", 0, $nombre, $apellidos);
    redireccionar("Index.php");


} else {
    $correcto = dao::crearUsuario($identificador, $contrasenna, "", "", 0, $nombre, $apellidos);
    redireccionar("SesionInicioComprobar.php");
}