<?php

    require_once "1-obtenerConexion.php";

    $conexion = obtenerPdoConexionBD();

    $sql = "
               SELECT
                    p.id        AS pId,
                    p.nombre    AS pNombre,
                    c.id        AS cId,
                    c.nombre    AS cNombre,
                    p.telefono  AS pTelefono,
                    p.categoriaId AS pCategoriaId  

                FROM
                   persona p, categoria c
                   WHERE p.categoriaId = c.id
                ORDER BY p.nombre
        ";

    $select = $conexion->prepare($sql);
    $select->execute([]);
    $rs = $select->fetchAll();

?>

<html>
<head>
    <title></title>
</head>
<body>

<h1>Listado de personas</h1>
<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Telefono</th>
        <th>CategoriaId</th>
    </tr>

    <?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href='6-personaFicha.php?id=<?=$fila["id"]?>'><?=$fila["pNombre"]?></a> </td>
            <td><a href='6-personaFicha.php?id=<?=$fila["id"]?>'><?=$fila["pTelefono"]?></a> </td>
            <td><a href='6-personaFicha.php?id=<?=$fila["id"]?>'><?=$fila["pCategoriaId"]?></a> </td>
            <td><a href='7-personaEliminar.php?id=<?=$fila["id"]?>'> (X)         </a> </td>
        </tr>
   <?php } ?>
</table>

<br/>

<a href="6-personaFicha.php">Crear entrada</a>

<br/>
<br/>

<a href="8-personaListado.php">Gestionar listado de personas</a>
</body>
</html>


