<?php
	require_once "_com/DAO.php";
	require_once "_com/Varios.php";

	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

    $resultado = DAO::categoriaEliminar($id);

    if($resultado){
        redireccionar("CategoriaListadoDAO.php?eliminacionCorrecta");
    }else
        redireccionar("CategoriaListadoDAO.php?eliminacionIncorrecta");
?>