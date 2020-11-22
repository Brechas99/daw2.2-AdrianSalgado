<?php
    require_once "1-conexion.php";

    $conexion = obtenerPDOconexionBD();

    $id = (int)$_REQUEST["id"];
    $pais =  $_REQUEST["pais"];

    $nuevaEntrada = ($id == -1);

    if($nuevaEntrada){
        $sql = "INSERT INTO paises(pais) VALUES(?)";
        $parametros = [$pais];
    } else {
        $sql = "UPDATE paises SET pais=? WHERE id=?";
        $parametros = [$pais, $id];
    }

    $sentencia = $conexion->prepare($sql);

    $sqlConExito = $sentencia->execute($parametros);

    $correcto = ($sqlConExito && $sentencia->rowCount() == 1);
    $datosNoModificados = ($sqlConExito && $sentencia->rowCount() == 0);
?>

<html>
<head>
    <title></title>
</head>
<body>

<?php if($correcto || $datosNoModificados) { ?>

    <?php if($nuevaEntrada) { ?>
        <h1>Insercion completada</h1>
        <p>Se ha insertado correctamente la nueva entrada de <?=$pais?> </p>

    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?=$pais?> </p>

        <?php if($datosNoModificados) { ?>
            <p>No se ha modificado nada</p>
        <?php } ?>
    <?php } ?>

<?php } else { ?>

    <?php if ($nuevaEntrada) { ?>
        <h1>Error en la creación.</h1>
        <p>No se ha podido crear el nuevo pais</p>

    <?php } else { ?>
        <h1>Error en la modificación.</h1>
        <p>No se han podido guardar los datos del pais</p>
    <?php } ?>

<?php } ?>

<a href="2-paisesListado.php">Volver al listado de paises</a>

</body>
</html>
