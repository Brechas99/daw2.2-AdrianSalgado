<?php
$operando1= (int) $_REQUEST["operando1"];
$operacion= $_REQUEST["operacion"];
$operando2= (int) $_REQUEST["operando2"];
$resultado=0;
$resto=0;
?>

<html>
<head>
    <title></title>
</head>
<body>
<?php
if($operando1!=null && $operando2!=null){
    if ($operacion=="sum"){
        $resultado= $operando1 + $operando2;
        echo '<p>'. $operando1 . ' + ' . $operando2 . ' = ' . $resultado . '</p>';
    }else if ($operacion=="res"){
        $resultado= $operando1 - $operando2;
        echo '<p>'. $operando1 . ' - ' . $operando2 . ' = ' . $resultado . '</p>';
    }else if ($operacion=="mul"){
        $resultado= $operando1 * $operando2;
        echo '<p>'. $operando1 . ' * ' . $operando2 . ' = ' . $resultado . '</p>';
    }else if ($operacion=="div"){
        $resultado= $operando1 / $operando2;
        $resto = $operando1 % $operando2;
        echo '<p>'. $operando1 . ' / ' . $operando2 . ' = ' . $resultado . '</p>';
        echo '<p> Resto: '. $resto . '</p>';


    }
}
?>

</body>
</html>
