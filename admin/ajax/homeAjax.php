<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['idAppoint']) || isset($_POST['savedetaTrat'])
	|| isset($_POST['user']) || isset($_POST['userUpdate'])) {
		
		require_once '../controladores/homeControlador.php';
		$inst = new homeControlador();

		// detail appointment
		if (isset($_POST['idAppoint'])) {
			echo $inst -> showDetailAppoint();
		}
		// detail appointment
		if (isset($_POST['savedetaTrat'])) {
			echo $inst -> saveDetalleTratam();
		}
		if (isset($_POST['user'])) {
			echo $inst -> datosUserExtra();
		}
		if (isset($_POST['userUpdate'])) {
			echo $inst -> updateDatosExtra();
		}

	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    