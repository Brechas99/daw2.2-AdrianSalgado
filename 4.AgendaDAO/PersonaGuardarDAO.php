<?php

require_once "_com/DAO.php";
require_once "_com/Varios.php";

$id = (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];
$telefono = $_REQUEST["telefono"];
$estrella= $_REQUEST["estrella"];
$personaCategoriaId = $_REQUEST["categoriaId"];

$nuevaEntrada = ($id == -1);

$resultado = false;
$datosNoModificados = false;

if($nuevaEntrada){
    $resultado = DAO:: personaCrear($nombre, $apellidos, $telefono, $estrella, $personaCategoriaId);
    redireccionar("PersonaListadoDAO.php");
}else{
    $datosNoModificados = DAO:: personaModificar($id, $nombre, $apellidos, $telefono,$estrella, $personaCategoriaId);
    redireccionar("PersonaListadoDAO.php");
}

?>
