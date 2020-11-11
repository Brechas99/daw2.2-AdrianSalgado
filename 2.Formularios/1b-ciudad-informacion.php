<?php
    $ciudad=$_REQUEST["ciudad"]
?>

<html>
<head>
    <title></title>
</head>
<body>

<?='<p>Tu ciudad favorita es ' . $ciudad . '</p>'; ?>
<a href="https://www.google.com/search?q=<?=$ciudad?>">Buscar informacion sobre <?=$ciudad?></a>
</body>
</html>
