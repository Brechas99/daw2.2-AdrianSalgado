<?php
if(isset($_REQUEST["error"])) {
    echo "<p>El usuario ya existe</p>";
}
?>

<html>
<head>
    <title></title>
</head>
<body>

<h1>Registrate</h1>

<form action="UsuarioNuevoComprobar.php" method="get">
    <label>Nombre</label>
    <input type="text" name="nombre"><br>
    <label>Apellidos</label>
    <input type="text" name="apellidos"><br>
    <label>Usuario</label>
    <input type="text" name="identificador"><br>
    <label>Contraseña</label>
    <input type="password" name="contrasenna"><br>
    <input type="submit" name="boton" value="Registrarse">
</form>

</body>
</html>
