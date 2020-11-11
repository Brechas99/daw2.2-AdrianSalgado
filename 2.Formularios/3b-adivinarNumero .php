<?php
$oculto= (int) $_REQUEST["oculto"];

if (isset($_REQUEST["numeroIntro"])){
    $numeroIntro= (int) $_REQUEST["numeroIntro"];
}else{
    $numeroIntro =null;
}
?>

<html>
<head>
    <title></title>
</head>
<body>
<?php
if( $numeroIntro != null){
        if($numeroIntro==$oculto) {
            echo "Lo has adivinado";
        }else if($numeroIntro>$oculto) {
            echo "El numero oculto es menor";
        }else if ($numeroIntro<$oculto) {
            echo "El numero oculto es mayor";
        }
    }

if($numeroIntro!= $oculto){
?>

<form method="post">
    <p>Jugador 2: Adivina el numero oculto</p>
    <input type="hidden" name="oculto" value="<?= $oculto?>">
    <input type="number" name="numeroIntro">
    <input type="submit" value="Comparar">
</form>
<?php
}
?>
</body>
</html>
