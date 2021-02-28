<?php

require_once "_com/DAO.php";
require_once "_com/Varios.php";

$id = (int)$_REQUEST["id"];

$nuevaEntrada = ($id == -1);

if($nuevaEntrada){
    $nombre = "";
    $apellidos = "";
    $telefono = "";
    $estrella = false;
    $categoriaId = 0;

}else{
    $persona = DAO:: personaObtenerPorId($id);
    $nombre = $persona->getPersonaNombre();
    $apellidos = $persona->getPersonaApellidos();
    $estrella = $persona->getEstrella();
    $telefono = $persona->getTelefono();
    $categoriaId = $persona->getPersonaCategoriaId();
}

?>

<html>
<head>
    <title></title>
</head>
<body>

<?php if($nuevaEntrada){ ?>
    <h1>Nueva Entrada</h1>
<?php }else { ?>
    <h1>Ficha Persona</h1>
    <?php } ?>

<form method="post" action="PersonaGuardarDAO.php">
    <input type="hidden" name="id" value="<?=$id?>">

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" value="<?=$nombre?>"><br>

    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" value="<?=$apellidos?>"><br>

    <label for="telefono">Telefono</label>
    <input type="text" name="telefono" value="<?=$telefono?>"><br>

    <label for="categoriaId">Categoria</label>
    <input type="number" name="categoriaId" value="<?=$categoriaId?>"><br>

    <label for='estrella'>Lesionado</label>
    <input type='checkbox' name='estrella' <?= $estrella ? "checked" : "" ?> />

    <?php if($nuevaEntrada){ ?>
        <input type="submit" name="crear" value="Añadir">
    <?php }else{ ?>
        <input type="submit" name="guardar" value="Modificar">
    <?php } ?>
</form>

<br>

<?php if (!$nuevaEntrada) { ?>
    <a href='PersonaEliminarDAO.php?id=<?=$id?>'>Eliminar persona</a>
<?php } ?>

<br />
<br />

<a href='PersonaListadoDAO.php'>Volver al listado de personas.</a>

</body>
</html>
