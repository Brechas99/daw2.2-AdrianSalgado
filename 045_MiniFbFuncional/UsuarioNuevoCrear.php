<?php

require_once "_com/dao.php";
require_once "_com/_Varios.php";

// TODO ...$_REQUEST["..."]...
$identificador=$_REQUEST["identificador"];
$contrasenna=$_REQUEST["contrasenna"];

// TODO Intentar crear (añadir funciones en Varios.php para crear y tal).
//
// TODO Y redirigir a donde sea.

$arrayUsuario = dao::crearUsuario($identificador, $contrasenna);

// TODO ¿Excepciones?

if ($arrayUsuario) {
    dao::marcarSesionComoIniciada($arrayUsuario);

    if (isset($_REQUEST["recordar"]))
        dao::establecerSesionCookie($arrayUsuario);
        redireccionar("Index.php");
} else {
    redireccionar("SesionInicioFormulario.php?datosErroneos");
}