<?php
/*Falta*/

require_once "_com/_Varios.php";
require_once "_com/dao.php";

?>

<html>
<head>
    <title></title>
</head>
<body>

<h1>Crear Usuario</h1>
<div>
    <form action='UsuarioNuevoCrear.php' method='get'>
        <p>Usuario: <input type='text' name='identificador' /></p>
        <p>Contraseña: <input type='password' name='contrasenna' /></p>
        <input type='submit' name='boton' value="Enviar" />
    </form>
</div>
<br>
<a href='SesionInicioFormulario.php'>Ya estoy registrado</a>


</body>
</html>

