<?php

require_once "_com/DAO.php";

$resultado = DAO::categoriaObtenerTodas();

echo json_encode($resultado);