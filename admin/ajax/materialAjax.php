<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['datosMateriales']) || isset($_POST['listarMat'])
        || isset($_POST['idMaterial']) || isset($_POST['idDelete'])) {
		
		require_once '../controladores/materialControlador.php';
		$inst = new materialControlador();

		// detail appointment
		if (isset($_POST['datosMateriales'])) {
			echo $inst -> updateMaterial();
		}
		// detail appointment
		if (isset($_POST['listarMat'])) {
			echo $inst -> listarMater();
		}
		if (isset($_POST['idMaterial'])) {
			echo $inst -> searchMaterial();
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
    