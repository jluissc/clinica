<?php 

	$peticionAjax = true;
 
	require_once '../config/app.php';

	if (isset($_POST['listaCompras']) || isset($_POST['updateDatos'])
        || isset($_POST['idMaterial']) || isset($_POST['idDelete'])) {
		
		require_once '../controladores/comprasControlador.php';
		$inst = new comprasControlador();

        // detail appointment
        if (isset($_POST['listaCompras'])) {
            echo $inst -> listarCompras();
        }
		// detail appointment
		if (isset($_POST['updateDatos'])) {
			echo $inst -> updateCompras();
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
    