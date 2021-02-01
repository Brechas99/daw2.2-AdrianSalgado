<?php

require_once "_com/dao.php";

dao::destruirSesionRamYCookie();

redireccionar("Index.php");

?>