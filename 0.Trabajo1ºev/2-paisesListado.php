<?php
    require_once "1-conexion.php";
    $conexionBD = obtenerPDOconexionBD();

    $sql= "SELECT id, pais FROM paises ORDER BY pais";

    $select=$conexionBD->prepare($sql);
    $select->execute([]);
    $rs = $select->fetchAll();
?>

<html>
<head>
    <title></title>
</head>
<body>
<h1>Países</h1>

<table border="1">
    <tr>
        <th>País</th>
    </tr>
    <?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href='3-paisesFicha.php?id=<?=$fila["id"]?>'><?=$fila["pais"]?></a> </td>
            <td><a href='4-paisesEliminar.php?id=<?=$fila["id"]?>'>    (X)      </a> </td>
        </tr>
   <?php } ?>

</table>

<br>

<a href="3-paisesFicha.php?id=-1">Añadir país</a>

<br>
<br>

<a href="6-jugadoresListado.php">Ir al listado de Jugadores</a>
</body>
</html>
