<?php
require_once "_com/dao.php";

$id= (int)$_REQUEST["id"];
$publicacion= dao::publicacionFicha($id);
$correcto= dao::eliminarPublicacionPorId($id);
if($correcto) {
    $ficha= $_REQUEST["ficha"]."?eliminacionCorrecta&idUsuario=3";
}else {
    $ficha= $_REQUEST["ficha"]."?eliminacionErronea";
}
dao::redireccionar($ficha);
