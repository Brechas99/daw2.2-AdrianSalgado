<?php
    require_once "1-obtenerConexion.php";
    $conexion = obtenerPdoConexionBD();

    $id=(int)$_REQUEST["id"];

// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
// (y $nueva_entrada tomará false).
    $nuevaEntrada = ($id==-1);

    if($nuevaEntrada){
        $categoriaNombre = "<Introduzca nombre>";
    } else {
        $sql = "SELECT nombre FROM categoria WHERE id=?";

        $select = $conexion->prepare($sql);
        $select-> execute([$id]);
        $rs = $select->fetchAll(); //*

        $categoriaNombre = $rs[0]["nombre"]; //*

    }
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
    <h1>Nueva ficha de categoría</h1>
<?php } else { ?>
    <h1>Ficha de categoría existente</h1>
<?php } ?>

<form method='post' action='5-categoriaGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$categoriaNombre?>' />
        </li>
    </ul>

    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear categoría' />
    <?php }  else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>

<br />

<a href='3-categoriaEliminar.php?id=<?=$id?>'>Eliminar categoría</a>

<br />
<br />

<a href='4-categoriaListado.php'>Volver al listado de categorías.</a>

</body>

</html>
