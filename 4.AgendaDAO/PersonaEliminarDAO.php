<?php

require_once "_com/DAO.php";
require_once "_com/Varios.php";

$id= (int)$_REQUEST["id"];

$resultado = DAO:: personaEliminar($id);

if($resultado){
    redireccionar("PersonaListadoDAO.php?eliminacionCorrecta");
}else{
    redireccionar("PersonaListado.php?eliminacionIncorrecta");
}

?>
