<?php 
 
	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['horaAten']) || isset($_POST['saveConfig']) || isset($_POST['name_cat']) || 
    isset($_POST['fechaCita']) || isset($_POST['fecha']) || 
	isset($_POST['fechaSelec']) || isset($_POST['hora_idHoraC']) ||
	isset($_POST['cita_idCitaC']) || isset($_POST['permisosTemp']) || 
	isset($_POST['user_idPerm']) || isset($_POST['idServiConf']) || 
	isset($_POST['idServiciD']) || isset($_POST['serv_addEdit']) || 
	isset($_POST['datosCateg'])  ) {
		
		require_once '../controladores/configControlador.php';
		$inst = new configControlador();

		// add and edit servics general
		if (isset($_POST['serv_addEdit'])) {
			$inst -> addEditServics();
		}
		// para eliminar un servicio, categoria (estado = 0)
		if (isset($_POST['idServiciD'])) {
			$inst -> deleteServicio();
		}
		// add categoria **************************
		if (isset($_POST['name_cat'])) {
			// exit(json_encode($_POST['prectiemserv']));
			$inst->saveServics();
		}
		// add categoria **************************
		if (isset($_POST['datosCateg'])) {
			// exit(json_encode($_POST['prectiemserv']));
			$inst->datosCateg($_POST['datosCateg']);
		}
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
		// para listar todo de un servicio
		if (isset($_POST['idServiConf'])) {
			$inst -> listsServicsIdd($_POST['idServiConf']);
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
    