<?php
//duda: como poner el nombre de la categoria y no el id

    require_once "1-obtenerConexion.php";

    $conexion = obtenerPdoConexionBD();

    $sql = "
               SELECT
                    p.id        AS pId,
                    p.nombre    AS pNombre,
                    p.apellidos AS pApellidos,
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
        <th>Apellidos</th>
        <th>Telefono</th>
        <th>Categoria</th>
    </tr>

    <?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href='6-personaFicha.php?id=<?=$fila["pId"]?>'><?=$fila["pNombre"]?></a> </td>
            <td><a href='6-personaFicha.php?id=<?=$fila["pId"]?>'><?=$fila["pApellidos"]?></a> </td>
            <td><a href='6-personaFicha.php?id=<?=$fila["pId"]?>'><?=$fila["pTelefono"]?></a> </td>
            <td><a href='4-categoriaListado.php?id=<?=$fila["cId"]?>'><?=$fila["cNombre"]?></a> </td>
            <td><a href='7-personaEliminar.php?id=<?=$fila["pId"]?>'> (X)         </a> </td>
        </tr>
   <?php } ?>
</table>

<br/>

<a href="6-personaFicha.php?id=-1">Crear entrada</a>

<br/>
<br/>

<a href="4-categoriaListado.php">Gestionar listado de Categorias</a>
</body>
</html>


