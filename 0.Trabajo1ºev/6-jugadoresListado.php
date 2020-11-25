<?php
    require_once "1-conexion.php";
    $conexion = obtenerPDOconexionBD();



    session_start();
    if (isset($_REQUEST["conEstrella"])) {
        $_SESSION["conEstrella"] = true;
    }

    if(isset($_REQUEST["todos"])) {
        unset($_SESSION["conEstrella"]);
    }

    $opcionClausulaWhere = isset($_SESSION["conEstrella"]) ? "AND j.estrella = 1" : "";

    $sql = "
               SELECT
                    j.id        AS jId,
                    j.nombre    AS jNombre,
                    j.equipo AS jEquipo,
                    p.id        AS pId,
                    p.pais    AS pPais,
                    j.edad  AS jEdad,
                    j.posicion AS jPosicion,
                    j.estrella AS jEstrella,
                    j.paisId AS jPaisId  

                FROM
                   jugadores j, paises p
                   WHERE j.paisId = p.id
                   $opcionClausulaWhere
                ORDER BY j.paisId
        ";

    $select = $conexion->prepare($sql);

    $select ->execute([]);

    $rs = $select->fetchAll();
?>

<html>
<head>
    <title></title>
</head>
<body>

<h1>Listado de Jugadores</h1>
<table border="1">
    <tr>
        <td>Nombre</td>
        <td>Equipo</td>
        <td>Edad</td>
        <td>Posicion</td>
        <td hidden>Estrella</td>
        <td>Pais</td>
    </tr>

    <?php foreach ($rs AS $fila){ ?>
        <tr>
            <td>
                <?php
                $urlImagen = $fila["jEstrella"] ? "img/EstrellaRellena.png" : "img/EstrellaVacia.png";
                echo " <a href='10-establecerEstadoEstrella.php?id=$fila[jId]'><img src='$urlImagen' width='16' height='16'></a> ";

                echo "<a href='7-jugadoresFicha.php?id=$fila[jId]'>";
                echo "$fila[jNombre]";
                echo "</a>";
                ?>
            </td>

            <td><a href='7-jugadoresFicha.php?id=<?=$fila["jId"]?>'><?=$fila["jEquipo"]?></a> </td>
            <td><a href='7-jugadoresFicha.php?id=<?=$fila["jId"]?>'><?=$fila["jEdad"]?></a> </td>
            <td><a href='7-jugadoresFicha.php?id=<?=$fila["jId"]?>'><?=$fila["jPosicion"]?></a> </td>
            <td hidden><a href='7-jugadoresFicha.php?id=<?=$fila["jId"]?>'><?=$fila["jEstrella"]?></a> </td>
            <td><a href='2-paisesListado.php?id=<?=$fila["pId"]?>'><?=$fila["pPais"]?></a> </td>
            <td><a href='8-jugadoresEliminar.php?id=<?=$fila["jId"]?>'>  (X)           </a> </td>
        </tr>
    <?php } ?>

</table>

<br>

<?php if(!isset($_SESSION["conEstrella"])) { ?>
    <a href='6-jugadoresListado.php?conEstrella'>Mostrar solo los jugadores favoritos</a>
<?php } else { ?>
    <a href='6-jugadoresListado.php?todos'>Mostrar todos los jugadores</a>
<?php } ?>

<br>
<br>

<a href="7-jugadoresFicha.php?id=-1">Crear entrada</a>

<br>
<br>

<a href="2-paisesListado.php">Gestionar listado de Paises</a>

</body>
</html>
