<?php  

	$peticionAjax = true; 

	require_once '../config/app.php';

	if (isset($_POST['dni']) || isset($_POST['tipoUserH']) ||
	isset($_POST['fecha']) || isset($_POST['tipoUserHist']) || 
	isset($_POST['idHistorial']) || 
    isset($_POST['listaServ']) || isset($_POST['idUser']) ||
	isset($_POST['listAppoint']) || isset($_POST['fechaCita'])||
	isset($_POST['numb_pay']) ||  isset($_POST['idAppointdV']) ||
	isset($_POST['estadoTransf']) || isset($_POST['idPayDirect']) || 
	isset($_POST['guardCitaUs']) || isset($_POST['searcHistUser'])) {
		
		require_once '../controladores/citaControlador.php';
		$inst = new citaControlador();

		// BUSCAR USUARIO POR DNI
		if (isset($_POST['dni'])) {
			echo $inst -> verificarDni();
		}
		// Listar la lista de personas con citas o tratamientos
		if (isset($_POST['tipoUserH'])) {
			$inst->reedListAppointment();
		}
		// Listar la lista de personas historial
		if (isset($_POST['tipoUserHist'])) {
			$inst->reedListHistorialAppointment();
		}
		// Listar la lista de personas historial
		if (isset($_POST['idHistorial'])) {
			$inst->reedHistorialApoointId();
		}
		// BUSCAR CITAS YA RESERVADAS
		if (isset($_POST['fechaCita'])) {
			echo $inst -> buscarFechaCita();
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
		/* ¨¨¨¨¨¨¨¨¨¨¨¨ */
        if (isset($_POST['guardCitaUs'])) {
			echo $inst -> saveCita();
		}
		/* ¨¨¨¨¨¨¨¨¨¨¨¨ */
        if (isset($_POST['searcHistUser'])) {
			// exit($_POST['searcHistUser']);
			$inst -> searchHistUser();
		}

       

        if (isset($_POST['estadoTransf'])) {
			echo $inst -> validarTransferencia();
		}

        if (isset($_POST['idAppointdV'])) {
			echo $inst -> searchAppointPay();
		}
		// pago de transferencia *************
        if (isset($_POST['numb_pay'])) {
			// echo $inst -> buscarFechaCita();
			$inst -> saveDatosPayAppoint();
			// exit(json_encode($_POST['numb_pay']));
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
    