<?php
    require_once "1-obtenerConexion.php";

    $conexionBD = obtenerPdoConexionBD();

    $id = (int)$_REQUEST["id"];
    $nombre = $_REQUEST["nombre"];

    $nuevaEntrada = ($id == -1);

    if($nuevaEntrada){
        $sql = "INSERT INTO categoria(nombre) VALUES(?)";
        $parametros = [$nombre];
    } else {
        $sql = "UPDATE categoria SET nombre=? WHERE id=?";
        $parametros = [$nombre, $id];
    }

    $sentencia = $conexionBD->prepare($sql);

    $sqlConExito = $sentencia->execute($parametros);

    $correcto = ($sqlConExito && $sentencia->rowCount()==1);

    $datosNoModificados = ($sqlConExito && $sentencia->rowCount()==0);
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php
// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
if ($correcto || $datosNoModificados) { ?>
    <?php if ($nuevaEntrada) { ?>
        <h1>Inserción completada</h1>
        <p>Se ha insertado correctamente la nueva entrada de <?=$nombre?>.</p>
    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?=$nombre?>.</p>

        <?php if ($datosNoModificados) { ?>
            <p>En realidad, no había modificado nada, pero no está de más que se haya asegurado pulsando el botón de guardar :)</p>
        <?php } ?>
    <?php }
    ?>

    <?php
} else {
    ?>

    <?php if ($nuevaEntrada) { ?>
        <h1>Error en la creación.</h1>
        <p>No se ha podido crear la nueva categoría.</p>
    <?php } else { ?>
        <h1>Error en la modificación.</h1>
        <p>No se han podido guardar los datos de la categoría.</p>
    <?php } ?>

    <?php
}
?>

<a href='4-categoriaListado.php'>Volver al listado de categorías.</a>

</body>

</html>
