<?php
    require_once "_com/DAO.php";

    $id= (int) $_REQUEST["id"];

    $nuevaEntrada = ($id == -1);

    if($nuevaEntrada){
        $categoriaNombre = "<Introduzca Nombre>";
    }else{
        $categoria = DAO::categoriaObtenerPorId($id);
        $categoriaNombre = $categoria->getNombre();
    }
?>

<html>
<head>
    <title></title>
</head>
<body>

<?php if ($nuevaEntrada) { ?>
    <h1>Nueva ficha de categoría</h1>
<?php } else { ?>
    <h1>Ficha de categoría</h1>
<?php } ?>

<form method='post' action='CategoriaGuardarDAO.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <label for='nombre'>Nombre</label>
    <input type='text' name='nombre' value='<?=$categoriaNombre?>' />
    <br/>

    <br/>

    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear categoría' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>

<br />

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='CategoriaEliminarDAO.php?id=<?=$id?>'>Eliminar categoría</a>
<?php } ?>

<br />
<br />

<a href='CategoriaListadoDAO.php'>Volver al listado de categorías.</a>


</body>
</html>
