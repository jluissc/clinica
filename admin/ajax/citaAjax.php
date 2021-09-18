<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['dni']) || isset($_POST['fecha']) || 
    isset($_POST['listaServ']) || isset($_POST['idUser']) ||
	isset($_POST['listAppoint']) || isset($_POST['fechaCita'])||
	isset($_POST['numb_pay']) ||  isset($_POST['idAppointdV']) ||
	isset($_POST['estadoTransf']) || isset($_POST['idPayDirect'])) {
		
		require_once '../controladores/citaControlador.php';
		$inst = new citaControlador();

		// registro nueva products
		if (isset($_POST['dni'])) {
			echo $inst -> verificarDni();
		}

		if (isset($_POST['idPayDirect'])) {
			$inst -> idPayDirect();
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

        if (isset($_POST['fechaCita'])) {
			echo $inst -> buscarFechaCita();
		}

        if (isset($_POST['estadoTransf'])) {
			echo $inst -> validarTransferencia();
		}

        if (isset($_POST['idAppointdV'])) {
			echo $inst -> searchAppointPay();
		}

        if (isset($_POST['numb_pay'])) {
			// echo $inst -> buscarFechaCita();
			$inst -> saveDatosPayAppoint();
			exit(json_encode($_POST['numb_pay']));
		}

        if (isset($_POST['listAppoint'])) {
			session_start(['name' => 'bot']);
			if($_SESSION['tipo']==1 || in_array(3, $_SESSION['permisos']) ){
				$inst -> reedListAppointment();
			}
			elseif ($_SESSION['tipo']==4) {
				$inst -> reedListAppointment(true);
			}
		}


	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    