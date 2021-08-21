<?php 

require_once './controladores/vistasControlador.php';
require_once './config/app.php';

$plantilla = new vistasControlador();
$plantilla ->obtener_plantilla_C();

