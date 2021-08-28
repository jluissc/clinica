<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['listaS']) || isset($_POST['nombre_r']) ) {
		
		require_once '../controladores/servicioControlador.php';
		$inst = new servicioControlador();

		// registro nueva products
		if (isset($_POST['listaS'])) {
			echo $inst -> select_servicio_admin();
		}
        // prod 
		if (isset($_POST['nombre_r'])) {
			echo $inst -> insert_servicio();
		}

	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    