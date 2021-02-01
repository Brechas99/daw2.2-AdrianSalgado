<?php

require_once "_com/dao.php";

$nombreUsuario=$_REQUEST["identificador"];
$contrasenna=$_REQUEST["contrasenna"];

$arrayUsuario = dao::obtenerUsuarioPorContrasenna($nombreUsuario, $contrasenna);

if ($arrayUsuario) { // Identificador existía y contraseña era correcta.
    dao:: establecerSesionRam($arrayUsuario);

    if (isset($_REQUEST["recordar"])) {
        dao::establecerSesionCookie($arrayUsuario);
    }

    redireccionar("MuroVerGlobal.php");
} else {
    redireccionar("SesionInicioFormulario.php?datosErroneos");
}