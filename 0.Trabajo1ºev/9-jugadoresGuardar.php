<?php
    require_once "1-conexion.php";
    $conexion = obtenerPDOconexionBD();

    $id = (int)$_REQUEST["id"];
    $nombre = $_REQUEST["nombre"];
    $equipo = $_REQUEST["jEquipo"];
    $edad = (int) $_REQUEST["jEdad"];
    $posicion = $_REQUEST["jPosicion"];
    $jugadorPaisId = $_REQUEST["pPais"];
    $estrella = isset($_REQUEST["estrella"]);


    $nuevaEntrada = ($id == -1);

    if ($nuevaEntrada) {
        $sql = "INSERT INTO jugadores (nombre, equipo, edad, posicion, estrella, paisId) VALUES (?, ?, ?, ?, ?,?)";
        $parametros = [$nombre, $equipo, $edad, $posicion, $estrella?1:0, $jugadorPaisId];

    } else {
        $sql = "UPDATE jugadores SET nombre=?, equipo=?, edad=?, posicion=?, estrella=?, paisId=? WHERE id=?";
        $parametros = [$nombre, $equipo, $edad, $posicion, $estrella?1:0, $jugadorPaisId, $id];
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
        <p>Se ha insertado correctamente la nueva entrada de <?=$nombre?> </p>

    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?=$nombre?> </p>

        <?php if($datosNoModificados) { ?>
            <p>No se ha modificado nada</p>
        <?php } ?>
    <?php } ?>

<?php } else { ?>

    <?php if ($nuevaEntrada) { ?>
        <h1>Error en la creación.</h1>
        <p>No se ha podido crear el nuevo jugador</p>

    <?php } else { ?>
        <h1>Error en la modificación.</h1>
        <p>No se han podido guardar los datos del jugador</p>
    <?php } ?>

<?php } ?>



<a href='6-jugadoresListado.php'>Volver al listado de jugadores</a>

</body>
</html>
