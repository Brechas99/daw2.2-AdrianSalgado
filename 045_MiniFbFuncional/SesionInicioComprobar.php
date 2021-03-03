<?php

require_once "_com/dao.php";

$identificador=$_REQUEST["identificador"];
$contrasenna=$_REQUEST["contrasenna"];

$arrayUsuario = dao::obtenerUsuarioPorContrasenna($identificador, $contrasenna);

if ($arrayUsuario) { // Identificador existía y contraseña era correcta.
    dao:: establecerSesionRam($arrayUsuario);

    if (isset($_REQUEST["recordar"])) {
        dao::establecerSesionCookie($arrayUsuario);
    }
    redireccionar("MuroVerGlobal.php");

} else {
    redireccionar("SesionInicioFormulario.php?datosErroneos");
}