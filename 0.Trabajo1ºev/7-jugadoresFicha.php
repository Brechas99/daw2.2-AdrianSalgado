<?php
    require_once "1-conexion.php";
    $conexion = obtenerPDOconexionBD();

    $id = (int) $_REQUEST["id"];

    $nuevaEntrada = ($id == -1);

    if($nuevaEntrada){
        $jugadorNombre = "<Introduzca nombre>";
        $jugadorEquipo = "<Introduzca el equipo>";
        $jugadorEdad = "<Introduzca la edad>";
        $jugadorPosicion = "<Introduzca la posicion>";
        $jugadorEstrella = false;
        $jugadorPaisId = "";

    } else {
        $sqlPersona = "SELECT * FROM jugadores WHERE id=?";

        $select = $conexion->prepare($sqlPersona);
        $select->execute([$id]);
        $rsJugador = $select->fetchAll();

        print_r($rsJugador);
        echo $id;
        echo $sqlPersona;

        $jugadorNombre = $rsJugador[0]["nombre"];
        $jugadorEquipo = $rsJugador[0]["equipo"];
        $jugadorEdad = $rsJugador[0]["edad"];
        $jugadorPosicion = $rsJugador[0]["posicion"];
        $jugadorEstrella = ($rsJugador[0]["estrella"] == 1);
        $jugadorPaisId = $rsJugador[0]["paisId"];
    }

    $sqlPaises = "SELECT id, pais FROM paises ORDER BY pais";

    $select = $conexion->prepare($sqlPaises);
    $select->execute([$id]);
    $rsPaises = $select->fetchAll();

?>

<html>
<head>
    <title></title>
</head>
<body>

<?php if($nuevaEntrada) { ?>
    <h1>Nueva entrada de jugador</h1>
<?php } else { ?>
    <h1>Ficha de Jugador existente</h1>
<?php } ?>

<form method="post" action="9-jugadoresGuardar.php">
    <input type="hidden" name="id" value="<?=$id?>" />

    <label for='jNombre'>Jugador</label>
    <input type='text' name='nombre' value='<?=$jugadorNombre ?>' />
    <br/>

    <label for='jEquipo'>Equipo</label>
    <input type='text' name='jEquipo' value='<?=$jugadorEquipo ?>' />
    <br/>

    <label for='jEdad'>Edad</label>
    <input type='text' name='jEdad' value='<?=$jugadorEdad ?>' />
    <br/>

    <label for='jPosicion'>Posicion</label>
    <input type='text' name='jPosicion' value='<?=$jugadorPosicion ?>' />
    <br/>

    <label for='pPais'>Pais</label>
    <select name='pPais'>
        <?php
        foreach ($rsPaises as $filaPaises) {
            $paisId = (int) $filaPaises["id"];
            $paisNombre = $filaPaises["pais"];

            if ($paisId == $jugadorPaisId) $seleccion = "selected='true'";
            else                                     $seleccion = "";

            echo "<option value='$paisId' $seleccion>$paisNombre</option>";
        }
        ?>
    </select>

    <label for='estrella'>Estrellado</label>
    <input type='checkbox' name='estrella' <?= $jugadorEstrella ? "checked" : "" ?> />
    <br>

    <br>

    <?php if($nuevaEntrada){ ?>
        <input type="submit" name="crear" value="Crear jugador" />
    <?php } else { ?>
        <input type="submit" name="guardar" value="Guardar cambios" />
    <?php } ?>

</form>


<a href='6-jugadoresListado.php'>Volver al listado de jugadores</a>

</body>
</html>
