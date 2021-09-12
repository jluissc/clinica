<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['idCustomer']) || isset($_POST['idDelete']) || 
		isset($_POST['dni_appoint'])) {
		
		require_once '../controladores/clientesControlador.php';
		$inst = new clienteControlador();

		// 
		if (isset($_POST['idCustomer'])) {
			$inst -> showCustomer();
		}
		if (isset($_POST['dni_appoint'])) {
			$inst -> insertAppoint();
		}

		if (isset($_POST['idDelete'])) {
            $inst -> deleteCustomer();
		}
	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    