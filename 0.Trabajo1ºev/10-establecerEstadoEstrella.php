<?php
    require_once "1-conexion.php";
    $conexion = obtenerPDOconexionBD();

    $id = $_REQUEST["id"];

    $sql = "UPDATE jugadores SET estrella = (NOT (SELECT estrella FROM jugadores WHERE id=?)) WHERE id=?";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$id, $id]);

    redireccionar("6-jugadoresListado.php");
?>
