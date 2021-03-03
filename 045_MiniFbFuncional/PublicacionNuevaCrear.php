<?php
require_once "_com/dao.php";

$asunto= $_REQUEST["asunto"];
$contenido= $_REQUEST["nuevaPublicacion"];
$fecha= date("Y-m-d H:i:s");

if(isset($_REQUEST["destinatarioId"])) {
    $destinatario= $_REQUEST["destinatarioId"];
}else {
    $destinatario= null;
}
if(isset($_REQUEST["destacadoHasta"])) {
    $destacadoHasta= $_REQUEST["destacadoHasta"];
}else {
    $destacadoHasta= null;
}

dao::publicacionCrear($fecha, $_SESSION["id"], $destinatario, $destacadoHasta, $asunto, $contenido);
dao::redireccionar($_REQUEST["ficha"]);

?>