<?php

require_once "_com/DAO.php";
require_once "_com/Varios.php";

$personas= DAO:: personaObtenerTodas();

?>

<html>
<head>
    <title></title>
</head>
<body>

<h1>Listado de Personas</h1>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Telefono</th>
        <th>Categoria</th>
    </tr>

    <?php foreach ($personas as $fila) { ?>
        <tr>
            <td><a href="PersonaFichaDAO.php?id=<?=$fila->getId()?>"> <?=$fila->getPersonaNombre()?> </a> </td>
            <td><a href="PersonaFichaDAO.php?id=<?=$fila->getId()?>"> <?=$fila->getPersonaApellidos()?> </a> </td>
            <td><a href="PersonaFichaDAO.php?id=<?=$fila->getId()?>"> <?=$fila->getTelefono()?> </a> </td>
            <td><a href="PersonaFichaDAO.php?id=<?=$fila->getId()?>"> <?=$fila->getPersonaCategoriaId()?> </a> </td>
            <td><a href="PersonaEliminarDAO.php?id=<?=$fila->getId()?>">     (X)     </a> </td>
        </tr>
    <?php } ?>

</table>

<br>

<a href="PersonaFichaDAO.php?id=-1">Crear Entrada</a>

<br>

<a href="CategoriaListadoDAO.php">Gestionar Categorias</a>

</body>
</html>