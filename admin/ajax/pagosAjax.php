<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['datosMateriales']) || isset($_POST['listarPagos'])
        || isset($_POST['Idpagos']) || isset($_POST['idDetalle'])) {
		
		require_once '../controladores/pagosControlador.php';
		$inst = new pagosControlador();

		// detail appointment
		if (isset($_POST['datosMateriales'])) {
			echo $inst -> updateMaterial();
		}
		// detail appointment
		if (isset($_POST['listarPagos'])) {
			echo $inst -> listarPagos();
		}
		if (isset($_POST['Idpagos'])) {
			echo $inst -> verPagos();
		}
		if (isset($_POST['idDetalle'])) {
			echo $inst -> detallePago();
		}
		if (isset($_POST['idDelete'])) {
			echo $inst -> deleteDefinity();
		}

	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    