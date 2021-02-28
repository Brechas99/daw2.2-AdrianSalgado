<?php

require_once "_com/DAO.php";
require_once "_com/Varios.php";

$id = (int)$_REQUEST["id"];
$nombre= $_REQUEST["nombre"];

$nuevaEntrada= ($id == -1);

$resultado= false;
$datosNoModificados= false;

if($nuevaEntrada){
    $resultado= DAO::categoriaCrear($nombre);
    redireccionar("CategoriaListadoDAO.php");

}else{
    $datosNoModificados= DAO::categoriaActualizar($id, $nombre);
    redireccionar("CategoriaListadoDAO.php");
}


?>
