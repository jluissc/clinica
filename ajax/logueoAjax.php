<?php 

	$peticionAjax = true;

	// require_once '../config/app.php';

	if (isset($_POST['verf']) || isset($_POST['session']) || isset($_POST['id']) || isset($_POST['cuenta']) || isset($_POST['edit']) ) {
		
		require_once '../controller/logueoController.php';
		$inst = new logueoController();	

		if (isset($_POST['verf'])) {
			if (isset($_SESSION['user'])) {
				echo "L";
			} else {
				echo "SL";
			}			
		}	

		if (isset($_POST['session'])) {
			$inst -> iniciar_sesion_C();		
		}	
		if (isset($_POST['id'])) {
			$inst -> verificarUsuario();
			
		}	

		if (isset($_POST['cuenta'])) {
			$inst -> mostrarCuenta();
			// echo 'asd';
			
		}	

		if (isset($_POST['edit'])) {
			$inst -> editCuenta();
			// echo 'asd';
			
		}	
	} 