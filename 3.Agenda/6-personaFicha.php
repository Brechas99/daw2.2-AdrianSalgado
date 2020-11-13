<?php
	require_once "1-obtenerConexion.php";
	$conexion = obtenerPdoConexionBD();

	$id = (int)$_REQUEST["id"];

	$nuevaEntrada = ($id == -1);

	if($nuevaEntrada){
		$personaNombre = "<Introduzca nombre>";
		$personaApellidos = "<Introduzca apellidos>";
		$telefono = "<Introduzca el telefono>";
		$personaCategoriaId = "<Introduzca el id de su categoria>";
	} else {
		$sqlPersona = "SELECT nombre, apellidos, telefono, categoriaId FROM persona WHERE id=?";

		$select= $conexion->prepare($sqlPersona);
		$select->execute([$id]);
		$rs= $select->fetchAll();

		$personaNombre = $rs[0]["nombre"];
		$personaApellidos = $rs[0]["apellidos"];
		$telefono = $rs[0]["telefono"];
		$personaCategoriaId = $rs[0]["categoriaId"];
	}
?>

<html>
<head>
	<title></title>
</head>
<body>
<?php if($nuevaEntrada) { ?>
	<h1>Nueva ficha de persona</h1>
<?php } else { ?>
	<h1>Ficha de persona</h1>
<?php } ?>

<form method="post" action="9-personaGuardar.php">
	<input type="hidden" name="id" value='<?=$id?>'/>
	<ul>
		<li>
			<strong>Nombre: </strong>
			<input type="text" name="pNombre" value="<?=$personaNombre?>"/>
		</li>

        <li>
            <strong>Apellidos: </strong>
            <input type="text" name="pApellidos" value="<?=$personaApellidos?>"/>
        </li>

		<li>
			<strong>Telefono: </strong>
			<input type="text" name="pTelefono" value="<?=$telefono?>"/>
		</li>

		<li>
			<strong>Categoria id: </strong>
			<input type="number" name="pCategoriaId" value="<?=$personaCategoriaId?>"/>
		</li>

	</ul>

	<?php if($nuevaEntrada) { ?>
		<input type="submit" name="crear" value="Crear persona"/>
	<?php } else { ?>
		<input type="submit" name="guardar" value="Guardar cambios"/>
	<?php } ?>
</form>

<a href="8-personaListado.php">Volver al listado de Personas</a>

</body>
</html>


