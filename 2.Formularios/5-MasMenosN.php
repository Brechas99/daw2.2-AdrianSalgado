<?php

    if (!isset($_REQUEST["acumulador"]) || isset($_REQUEST["reset"])) {
        $acumulador = 0;
        $diferencia = 1;
    } else {
        $acumulador = (int) $_REQUEST["acumulador"];
        $diferencia = (int) $_REQUEST["diferencia"];

    if (isset($_REQUEST["resta"])) {
        $acumulador = $acumulador - $diferencia;
    } else if (isset($_REQUEST["suma"])) {
        $acumulador = $acumulador + $diferencia;
    } else {
        //Nada
            }
}

?>

<html>

<h1><?=$acumulador?></h1>

<form method='get'>

    <input type='hidden' name='acumulador' value='<?=$acumulador?>'>

    <input type='submit' value=' + ' name='suma'>
    <input type='number' name='diferencia' value='<?=$diferencia?>'>
    <input type='submit' value=' - ' name='resta'>

    <br /><br />

    <input type='submit' value='Resetear' name='reset'>

</form>

</html>
