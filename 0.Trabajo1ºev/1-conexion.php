<?php

    function obtenerPDOconexionBD(): PDO
    {
        $servidor= "localhost";
        $bd = "wikifutbol";
        $identificador = "root";
        $contraseña = "";

        try {
            $conexionBD = new PDO("mysql:host=$servidor; dbname=$bd;charset=utf8",$identificador,$contraseña);
        }catch (Exception $e){
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar");
        }
        return $conexionBD;
    }

?>
