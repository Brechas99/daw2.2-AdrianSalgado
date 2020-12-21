<?php

    declare(strict_types=1);

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

    function cambiarEstrella($url)
    {
        header("Location: $url");
        exit;
    }

    function syso($contenido)
    {
        file_put_contents('php://stderr', $contenido . "\n");
    }

?>
