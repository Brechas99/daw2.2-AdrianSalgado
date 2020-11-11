<?php
    require_once "1-obtenerConexion.php";
    $conexion = obtenerPdoConexionBD();

    $id = (int)$_REQUEST["id"];

    $sql = "DELETE FROM persona WHERE id=?";

    $sentencia= $conexion->prepare($sql);
    $sqlConExito = $sentencia->execute([$id]);

    $correcto = ($sqlConExito && $sentencia->rowCount()==1);
    $noExiste = ($sqlConExito && $sentencia->rowCount()==0);
?>

<html>
<head>
    <title></title>
</head>
<body>

<?php if ($correcto) { ?>
    <h1>Eliminacion completada</h1>
    <p>Se ha eliminado correctamente la persona</p>
<?php }else if($noExiste) { ?>
    <h1>Eliminacion no realizada</h1>
    <p>No existe la persona que se pretende eliminar</p>
<?php } else { ?>
    <h1>Error en la eliminacion</h1>
    <p>No se ha podido eliminar la persona</p>
<?php } ?>

<a href="8-personaListado.php">Volver al listado de personas</a>

</body>
</html>
