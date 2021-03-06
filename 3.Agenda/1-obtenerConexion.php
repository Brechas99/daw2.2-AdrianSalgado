<?php
    declare(strict_types=1); //*

    function obtenerPdoConexionBD(): PDO //*
    {
        $servidor = "localhost";
        $bd= "agenda";
        $identificador= "root";
        $contraseña= "";
        $opciones =  [
            PDO::ATTR_EMULATE_PREPARES => false, //*
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //*
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //*
        ];

        try{
            $conexionBD=new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8",$identificador,$contraseña,$opciones);
        }catch(Exception $e){
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar");
        }
        return $conexionBD;
    }

// (Esta función no se utiliza en este proyecto pero se deja por si se optimizase el flujo de navegación.)
// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}
?>
