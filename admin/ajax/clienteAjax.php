<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['idCustomer']) || isset($_POST['idDelete'])) {
		
		require_once '../controladores/clientesControlador.php';
		$inst = new clienteControlador();

		// registro nueva products
		if (isset($_POST['idCustomer'])) {
			$inst -> showCustomer();
		}

		if (isset($_POST['idDelete'])) {
            $inst -> deleteCustomer();
			// exit(json_encode($_POST['idDelete']));
		}
	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    