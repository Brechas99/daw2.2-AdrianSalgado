<?php

    require_once "1-obtenerConexion.php";

    $conexion = obtenerPdoConexionBD();

    session_start();
    if (isset($_REQUEST["soloEstrellas"])) {
        $_SESSION["soloEstrellas"] = true;
    }
    if (isset($_REQUEST["todos"])) {
        unset($_SESSION["soloEstrellas"]);
    }

$posibleClausulaWhere = isset($_SESSION["soloEstrellas"]) ? "AND p.estrella=1" : "";

    $sql = "
               SELECT
                    p.id        AS pId,
                    p.nombre    AS pNombre,
                    p.apellidos AS pApellidos,
                    p.estrella AS pEstrella,
                    c.id        AS cId,
                    c.nombre    AS cNombre,
                    p.telefono  AS pTelefono,
                    p.categoriaId AS pCategoriaId  

                FROM
                   persona p, categoria c
                   WHERE p.categoriaId = c.id
                   $posibleClausulaWhere
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
            <td>
                <?php
                $urlImagen = $fila["pEstrella"] ? "img/EstrellaRellena.png" : "img/EstrellaVacia.png";
                echo " <a href='10-PersonaEstablecerEstadoEstrella.php?id=$fila[pId]'><img src='$urlImagen' width='16' height='16'></a> ";

                echo "<a href='6-personaFicha.php?id=$fila[pId]'>";
                echo "$fila[pNombre]";
                if ($fila["pApellidos"] != "") {
                    echo " $fila[pApellidos]";
                }
                echo "</a>";
                ?>
            </td>
            <td><a href= '6-personaFicha.php?id=<?=$fila["cId"]?>'> <?= $fila["pApellidos"] ?> </a></td>
            <td><a href= '6-personaFicha.php?id=<?=$fila["cId"]?>'> <?= $fila["pTelefono"] ?> </a></td>
            <td><a href= '2-categoriaFicha.php?id=<?=$fila["cId"]?>'> <?= $fila["cNombre"] ?> </a></td>
            <td><a href='7-personaEliminar.php?id=<?=$fila["pId"]?>'> (X)                      </a></td>
        </tr>
   <?php } ?>
</table>

<br/>

<?php if(!isset($_SESSION["soloEstrellas"])) { ?>
    <a href='8-personaListado.php?soloEstrellas'>Mostrar solo los jugadores favoritos</a>
<?php } else { ?>
    <a href='8-personaListado.php?todos'>Mostrar todos los jugadores</a>
<?php } ?>

<br>
<br>

<a href="6-personaFicha.php?id=-1">Crear entrada</a>

<br/>
<br/>

<a href="4-categoriaListado.php">Gestionar listado de Categorias</a>
</body>
</html>


