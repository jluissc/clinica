<?php 

require_once 'config/app.php'; 

require_once './controller/vistasCController.php';
$plantilla = new vistasCController();
$plantilla ->obtener_plantilla_C(); 

