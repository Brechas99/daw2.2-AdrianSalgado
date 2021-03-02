<?php

require_once "_com/Clases.php";
require_once "_com/DAO.php";

$persona = new Persona($_REQUEST["id"], $_REQUEST["nombre"], $_REQUEST["apellidos"], $_REQUEST["telefono"], $_REQUEST["estrella"], $_REQUEST["categoriaId"]);

$persona = DAO::personaActualizar($persona);

echo json_encode($persona);