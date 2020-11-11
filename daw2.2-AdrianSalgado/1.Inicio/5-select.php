<?php
    $ciudades=[
        17 => "Donosti",
        8 => "Getafe",
        4 => "Toledo",
        74 => "Granada"
    ];
?>
<html>
<head>
    <title></title>
</head>
<body>

<select>
    <option>Elija Ciudad</option>
    <?php
    foreach ($ciudades as $id => $denominacion){
        echo "<option value='$id'>$denominacion</option>\n";
    }
    ?>


</select>
</body>
</html>