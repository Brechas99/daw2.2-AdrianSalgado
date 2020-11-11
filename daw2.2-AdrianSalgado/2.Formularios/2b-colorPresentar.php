<?php
$color= $_REQUEST["color"];
?>
<html>
<head>
    <style>
        #coloreado{
            color: <?= $color ?>;
        }
    </style>
    <title></title>
</head>
<body>
<p id="coloreado">Párrafo con el color elegido</p>
</body>
</html>
