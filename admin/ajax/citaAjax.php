<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['dni']) || isset($_POST['fecha']) || 
    isset($_POST['idServ_Edit']) || isset($_POST['nombre_e']) || isset($_POST['id_d']) ) {
		
		require_once '../controladores/citaControlador.php';
		$inst = new citaControlador();

		// registro nueva products
		if (isset($_POST['dni'])) {
			echo $inst -> verificarDni();
		}
        // prod 
		if (isset($_POST['fecha'])) {
			echo $inst -> verificarFecha();
		}

        if (isset($_POST['idServ_Edit'])) {
			echo $inst -> show_servicio();
		}

        if (isset($_POST['nombre_e'])) {
			echo $inst -> update_servicio();
		}

        if (isset($_POST['id_d'])) {
			echo $inst -> delete_servicio();
		}

	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    