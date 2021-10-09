<?php 
 
	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['horaAten']) || isset($_POST['saveConfig']) || isset($_POST['prectiemserv']) || 
    isset($_POST['fechaCita']) || isset($_POST['fecha']) || 
	isset($_POST['fechaSelec']) || isset($_POST['hora_idHoraC']) ||
	isset($_POST['cita_idCitaC']) || isset($_POST['permisosTemp']) || 
	isset($_POST['user_idPerm']) ) {
		
		require_once '../controladores/configControlador.php';
		$inst = new configControlador();

		// Listar al carga la pagina todo las config *****
		if (isset($_POST['horaAten'])) {
			$inst -> listarHoraAtencion();
		}
		// guardar las configuraciones de atencion *****
		if (isset($_POST['saveConfig'])) {
			$inst->saveConfig();			
		}
		// Para editar los permisos de un usuario
        if (isset($_POST['user_idPerm'])) {
			echo $inst -> updatePermisoUser();
		}
		// para guardar  permisos de user
		if (isset($_POST['permisosTemp'])) {
			$inst -> saveUsuario();
		}
		 

        // prod 
		if (isset($_POST['prectiemserv'])) {
			// exit(json_encode($_POST['prectiemserv']));
			$inst->saveServics();
		}

        if (isset($_POST['fecha'])) {
			echo $inst -> fecha_servicio();
		}

        if (isset($_POST['fechaSelec'])) {
			echo $inst -> updateFechaAtencion();
		}
        if (isset($_POST['fechaCita'])) {
			echo $inst -> updateCitaAtencion();
		}

        if (isset($_POST['hora_idHoraC'])) {
			echo $inst -> updateHoraCrud();
		}

        if (isset($_POST['cita_idCitaC'])) {
			echo $inst -> updateCitaCrud();
		}
		

	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    