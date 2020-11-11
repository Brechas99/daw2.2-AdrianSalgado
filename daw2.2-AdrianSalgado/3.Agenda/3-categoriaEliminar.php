<?php
    require_once "1-obtenerConexion.php";

    $conexion = obtenerPdoConexionBD();

    $id = (int)$_REQUEST["id"];

    $sql = "DELETE FROM categoria WHERE id=?";

    $sentencia = $conexion->prepare($sql);
    $sqlConExito = $sentencia->execute([$id]);

    $correctoNormal = ($sqlConExito && $sentencia-> rowCount() == 1);

    $noExistia = ($sqlConExito && $sentencia-> rowCount() == 0);
?>


<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($correctoNormal) { ?>

    <h1>Eliminación completada</h1>
    <p>Se ha eliminado correctamente la categoría.</p>

<?php } else if ($noExistia) { ?>

    <h1>Eliminación no realizada</h1>
    <p>No existe la categoría que se pretende eliminar (quizá la eliminaron en paraleo o, ¿ha manipulado Vd. el parámetro id?).</p>

<?php } else { ?>

    <h1>Error en la eliminación</h1>
    <p>No se ha podido eliminar la categoría.</p>

<?php } ?>

<a href='4-categoriaListado.php'>Volver al listado de categorías.</a>

</body>

</html>
