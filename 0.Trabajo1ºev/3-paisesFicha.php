<?php
    require_once "1-conexion.php";
    $conexion = obtenerPDOconexionBD();

    $id = (int) $_REQUEST["id"];

    $nuevaEntrada = ($id == -1);

    if($nuevaEntrada){
        $paisNombre = "<Introduce un nuevo País>";
    } else{
        $sql = "SELECT pais FROM paises WHERE id=?";

        $select = $conexion->prepare($sql);
        $select -> execute([$id]);
        $rs = $select->fetchAll();

        $paisNombre = $rs[0]["pais"];
    }

    $sql = "SELECT * FROM jugadores WHERE paisId=? ORDER BY nombre";

    $select = $conexion->prepare($sql);
    $select->execute([$id]);
    $rsJugadoresDeCadaPais = $select->fetchAll();
?>

<html>
<head>
    <title></title>
</head>
<body>

<?php if ($nuevaEntrada) { ?>
    <h1>Nueva ficha de paises</h1>
<?php } else { ?>
    <h1>Ficha de paises existente</h1>
<?php } ?>

<form method="post" action="5-paisesGuardar.php">
    <input type="hidden" name="id" value="<?=$id?>" />

    <label for='pais'>Pais</label>
    <input type='text' name='pais' value='<?=$paisNombre?>' />
    <br>

    <br>

    <?php if($nuevaEntrada) { ?>
        <input type="submit" name="crear" value="Añadir pais" />
    <?php } else { ?>
        <input type="submit" name="guardar" value="Guardar cambios" />
    <?php } ?>

</form>

<br>

<p>Personas que pertenecen actualmente a la categoría:</p>

<ul>
    <?php
    foreach ($rsJugadoresDeCadaPais as $fila) {
        echo "<li>$fila[nombre] - $fila[equipo]</li>";
    }
    ?>
</ul>

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='4-paisesEliminar.php?id=<?=$id?>'>Eliminar pais</a>
<?php } ?>

<br />
<br />

<a href="2-paisesListado.php">Volver al listado de paises</a>

</body>
</html>
