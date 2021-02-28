<?php
if(isset($_REQUEST["incorrecto"])) {
    echo "<p>Datos erróneos. Asegúrese que todo está bien escrito.</p>";
}
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<h1>Iniciar Sesión</h1>

<form action="SesionInicioComprobar.php" method="get">
    <label>Usuario:</label>
    <input type="text" name="identificador">
    <br>
    <label>Contraseña:</label>
    <input type="password" name="contrasenna">
    <br>
    <input type="submit" name="boton" value="Aceptar">
</form>

<form action="UsuarioNuevoFormulario.php" METHOD="get">
    <input type="submit" name="boton" value="Registrarse">
</form>


</body>

</html>