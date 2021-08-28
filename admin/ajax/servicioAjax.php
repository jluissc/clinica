<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['listaS']) || isset($_POST['nombre_r']) || 
    isset($_POST['idServ_Edit']) || isset($_POST['nombre_e']) || isset($_POST['id_d']) ) {
		
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
    