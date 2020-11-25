<?php
    require_once "1-obtenerConexion.php";

    $conexion = obtenerPdoConexionBD();

    $id = $_REQUEST["id"];

    $sql = "UPDATE persona SET estrella = (NOT (SELECT estrella FROM persona WHERE id=?)) WHERE id=?";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$id, $id]);

    redireccionar("8-personaListado.php");
?>
