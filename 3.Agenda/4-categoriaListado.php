<?php
    require_once "1-obtenerConexion.php";

    $conexionBD = obtenerPdoConexionBD();

    $sql= "SELECT id, nombre FROM categoria ORDER BY nombre";

    $select= $conexionBD->prepare($sql);
    $select->execute([]);
    $rs = $select->fetchAll();
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
    <?php foreach ($rs as $fila) { ?>
    <tr>

            <td><a href='2-categoriaFicha.php?id=<?=$fila["id"]?>'> <?=$fila["nombre"] ?> </a></td>
            <td><a href='3-categoriaEliminar.php?id=<?=$fila["id"]?>'> (X)                   </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href='2-categoriaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='8-personaListado.php'>Gestionar listado de Personas</a>

</body>

</html>
