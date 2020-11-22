<?php
    require_once "1-conexion.php";
    $conexion = obtenerPDOconexionBD();

    $id = (int) $_REQUEST["id"];

    $sql = "DELETE FROM paises WHERE id=?";

    $sentencia = $conexion ->prepare($sql);

    $sqlConExito = $sentencia->execute([$id]);

    $correcto = ($sqlConExito && $sentencia ->rowCount() == 1);

    $incorrecto = ($sqlConExito && $sentencia ->rowCount() == 0);
?>

<html>
<head>
    <title></title>
</head>
<body>

<?php if ($correcto) { ?>

    <h1>Eliminacion completada</h1>
    <p>Se ha eliminado correctamente el pais</p>

<?php } else { ?>

    <h1>Error en la eliminacion</h1>
    <p>No se ha podido eliminar el pais</p>

<?php } ?>

<br>

<a href="2-paisesListado.php">Volver al listado de paises</a>

</body>
</html>
