<?php

require_once "_com/DAO.php";
require_once "_com/Varios.php";

$categorias= DAO::categoriaObtenerTodas();

?>

<html>
<head>
    <title></title>
</head>
<body>

<h1>Listado de Categorias</h1>

<table border="1">
    <tr>
        <th>Nombre</th>
    </tr>
    <?php foreach ($categorias as $filas){ ?>
        <tr>
            <td><a href="CategoriaFichaDAO.php?id=<?=$filas->getId()?>"><?=$filas->getNombre()?></a> </td>
            <td><a href="CategoriaEliminarDAO.php?id=<?=$filas->getId()?>">     (X)       </a> </td>
        </tr>
    <?php } ?>

</table>

<br>
<a href="CategoriaFichaDAO.php?id=-1">Crear Entrada</a>

<br>

<a href="PersonaListadoDAO.php">Listado de Personas</a>
</body>
</html>
