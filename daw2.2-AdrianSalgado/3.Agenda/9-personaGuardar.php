<?php
	require_once "1-obtenerConexion.php";

	$conexion = obtenerPdoConexionBD();

	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];
	$telefono= $_REQUEST["telefono"];
	$personaCategoriaId= (int)$_REQUEST["categoriaId"];

	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) {
 		$sql = "INSERT INTO persona (nombre, telefono, categoriaId) VALUES (?, ?, ?)";
 		$parametros = [$nombre, $telefono, $personaCategoriaId];
	} else {
 		$sql = "UPDATE persona SET nombre=?, telefono=?, categoriaId=? WHERE id=?";
        $parametros = [$nombre, $telefono, $personaCategoriaId, $id];
 	}
 	
    $sentencia = $conexion->prepare($sql);
    $sqlConExito = $sentencia->execute($parametros);

 	$filaAfectada = ($sentencia->rowCount() == 1);
 	$ningunaFilaAfectada = ($sentencia->rowCount() == 0);

 	$correcto = ($sqlConExito && $filaAfectada);

 	$datosNoModificados = ($sqlConExito && $ningunaFilaAfectada);
?>



<html>

<head>
	<meta charset="UTF-8">
</head>



<body>

<?php
	if ($correcto || $datosNoModificados) { ?>

		<?php if ($id == -1) { ?>
			<h1>Insercion completada</h1>
			<p>Se ha insertado correctamente la nueva entrada de <?= $nombre; ?></p>
		<?php } else { ?>
			<h1>Guardado completado</h1>
			<p>Se han guardado correctamente los datos de <?= $nombre; ?></p>

			<?php if ($datosNoModificados) { ?>
				<p>No ha habido ninguna modificacion.</p>
			<?php } ?>
		<?php }
?>

<?php
	} else {
?>

	<h1>Error en la modificacion</h1>
	<p>No se han podido guardar los datos de la persona</p>

<?php
	}
?>

<a href="8-personaListado.php">Volver al listado de personas</a>

</body>

</html>