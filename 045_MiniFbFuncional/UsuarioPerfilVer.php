<?php
/*Falta*/

require_once "_com/_Varios.php";
require_once "_com/dao.php";

if(isset($_SESSION["id"])) {
    $id = (int)$_SESSION["id"];
    $datos= DAO::usuarioFicha($id);
}else {
    $datos= [true];
}

?>

<html>
<head>
    <title></title>
</head>
<body>

<?php dao::pintarInfoSesion(); ?>

<?php if ($datos[0] == true) { ?>
    <h1>Nueva ficha de usuario</h1>
<?php } else { ?>
    <h1>Ficha de usuario</h1>
<?php } ?>

<div>
    <form action='UsuarioPerfilGuardar.php' method='get'>

        <input type='hidden' name='id' value='<?= $id ?>' />

        <?php if(dao::haySesionRamIniciada()){ ?>
            <p>Identificador:</p><input type='text' name='identificador' value='<?=$datos[1]?>' /><br>
            <p>Contraseña:</p><input type='text' name='contrasenna' value='<?=$datos[2]?>' /><br>
            <p>Nombre:</p><input type='text' name='nombre' value='<?=$datos[3]?>' /><br>
            <p>Apellidos</p><input type='text' name='apellidos' value='<?=$datos[4]?>' /><br><br>
            <input type='submit' name='guardar' value='Guardar cambios' /><br>

        <?php } else{ ?>
            <p>Identificador: <input type='text' name='identificador' /></p>
            <p>Contraseña: <input type='password' name='contrasenna' /></p>
            <p>Nombre: <input type='text' name='nombre' /></p>
            <p>Apellidos: <input type='text' name='apellidos' /></p>
            <input type='submit' name='boton' value="Crear" />
        <?php } ?>
    </form>
</div>
<br>

<?php if(dao::haySesionRamIniciada()){ ?>
    <a href="Index.php">Ir a la pagina principal</a>
<?php }?>

</body>
</html>

