<?php
	require_once "1-obtenerConexion.php";
	$conexion = obtenerPdoConexionBD();

	$id = (int)$_REQUEST["id"];

	$nuevaEntrada = ($id == -1);

	if($nuevaEntrada){
		$personaNombre = "<Introduzca nombre>";
		$personaApellidos = "<Introduzca apellidos>";
		$telefono = "<Introduzca el telefono>";
        $personaEstrella = false;
		$personaCategoriaId = "<Introduzca el id de su categoria>";
	} else {
		$sqlPersona = "SELECT nombre, apellidos, telefono, categoriaId, estrella FROM persona WHERE id=?";

		$select= $conexion->prepare($sqlPersona);
		$select->execute([$id]);
		$rs= $select->fetchAll();

		$personaNombre = $rs[0]["nombre"];
		$personaApellidos = $rs[0]["apellidos"];
		$telefono = $rs[0]["telefono"];
        $personaEstrella = ($rs[0]["estrella"] == 1);
		$personaCategoriaId = $rs[0]["categoriaId"];
	}

    $sqlCategorias = "SELECT id, nombre FROM categoria ORDER BY nombre";

    $select = $conexion->prepare($sqlCategorias);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rsCategorias = $select->fetchAll();
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

    <label for='pNombre'>Nombre</label>
    <input type='text' name='pNombre' value='<?=$personaNombre ?>' />
    <br/>

    <label for='pApellidos'> Apellidos</label>
    <input type='text' name='pApellidos' value='<?=$personaApellidos ?>' />
    <br/>

    <label for='pTelefono'> Teléfono</label>
    <input type='text' name='pTelefono' value='<?=$telefono ?>' />
    <br/>

    <label for='pCategoriaId'>Categoría</label>
    <select name='pCategoriaId'>
        <?php
            foreach ($rsCategorias as $filaCategoria) {
                $categoriaId = (int) $filaCategoria["id"];
                $categoriaNombre = $filaCategoria["nombre"];

                if ($categoriaId == $personaCategoriaId) $seleccion = "selected='true'";
                else                                     $seleccion = "";

                echo "<option value='$categoriaId' $seleccion>$categoriaNombre</option>";
            }
        ?>
    </select>
    <br/>

    <label for='pEstrella'>Estrellado</label>
    <input type='checkbox' name='pEstrella' <?= $personaEstrella ? "checked" : "" ?> />
    <br/>

    <br/>

	<?php if($nuevaEntrada) { ?>
		<input type="submit" name="crear" value="Crear persona"/>
	<?php } else { ?>
		<input type="submit" name="guardar" value="Guardar cambios"/>
	<?php } ?>
</form>

<a href="8-personaListado.php">Volver al listado de Personas</a>

</body>
</html>


