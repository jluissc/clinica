<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['dni']) || isset($_POST['fecha']) || 
    isset($_POST['listaServ']) || isset($_POST['idUser']) || isset($_POST['id_d']) ) {
		
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

		if (isset($_POST['listaServ'])) {
			echo $inst -> listaServic();
		}

        if (isset($_POST['idUser'])) {
			echo $inst -> saveCita();
		}


	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    