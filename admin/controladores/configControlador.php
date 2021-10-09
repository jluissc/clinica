<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/configModelo.php';
	}else{
		require_once './modelos/configModelo.php';
	} 
 
	class configControlador extends configModelo	{
		
		public function listarHoraAtencion() {
			configModelo::listarHoraAtencion_m();
		}

		public function saveConfig() {
			$code = rand(10001, 99999);
			$name = $_POST['nameConf'];
			$horaInicio = $_POST['horaInicio'];
			$horaFin = $_POST['horaFin'];
			$idConfig = configModelo::saveConfig_m($code,$name,$horaInicio, $horaFin);
			foreach (json_decode($_POST['diaSelect']) as $dia) { 
				foreach (json_decode($_POST['tipoSelect']) as $tipo) {
					$datos = [
						'dia' => $dia->diaId,
						'tipo' => $tipo->citaId,
						'idConfig' => $idConfig,
						'inicio' => $_POST['horaInicio'],
						'fin' => $_POST['horaFin'],
					];
					configModelo::saveConfigDiaHora_m($datos);
				}
			}
			return 1;
		}

		public function listNotifications() {
			$listsToday = configModelo::listNotifications_m();
			// $listsNetxs = configModelo::listNotifications_m();

			$listHTML = '<li>
				<h6 class="dropdown-header" > <a href="'.SERVERURL.'citas">Citas de hoy</a></h6>
			</li>';
			foreach ($listsToday[0] as $list) {
				$listHTML .= '<li><a class="dropdown-item">'.$list->nombre.' <span class="badge bg-info text-dark"><i class="far fa-clock"></i> '.$list->hora.'</span> </a> <br>'.$list->namC .'</li><hr>';
			}
			$listHTML .= '<li>
				<h6 class="dropdown-header" > <a href="'.SERVERURL.'citas">Citas de proximos dias</a></h6>
			</li>';
			foreach ($listsToday[1] as $list) {
				$listHTML .= '<li><p class="text-center">'.$list->nombre.' ::: '.$list->namC .'</p><a class="dropdown-item">'.$list->fecha.' <span class="badge bg-info text-dark"><i class="far fa-clock"></i> </span> '.$list->hora.'  </a> </li><hr>';
			}
			return $listHTML;
		}

		public function estadoHoraAtenc() {
			$datos = [
                'estadoH' => $_POST['estadoH'],
                'idH' => $_POST['idH'],
            ];
			configModelo::estadoHoraAtenc_m($datos);
		}

		public function updateFechaAtencion() {
			$datos = [
                'estadoH' => $_POST['estadoSelec'],
                'fechaSelec' => $_POST['fechaSelec'],
                'hora_idSelec' => $_POST['hora_idSelec'],
                'sede' => $_POST['sede'],
            ];
			configModelo::updateFechaAtencion_m($datos);
		}

		public function updateCitaAtencion() {
			$datos = [
                'estadoH' => $_POST['estadoCita'],
                'fechaSelec' => $_POST['fechaCita'],
                'hora_idSelec' => $_POST['cita_idCita'],
                'sede' => $_POST['sedeC'],
            ];
			configModelo::updateCitaAtencion_m($datos);
		}
		public function updateHoraCrud() {
			$datos = [
                'estado' => $_POST['estadoHoraC'],
                'hora_id' => $_POST['hora_idHoraC'],
            ];
			configModelo::updateHoraCrud_m($datos);
		}

		public function updateCitaCrud() {
			$datos = [
                'estado' => $_POST['estadoCitaC'],
                'cita_id' => $_POST['cita_idCitaC'],
            ];
			configModelo::updateCitaCrud_m($datos);
		}

		public function updatePermisoUser() {
			$datos = [
                'tipo' => $_POST['tipoPerm'],
                'user_id' => $_POST['user_idPerm'],
            ];
			configModelo::updatePermisoUser_m($datos);
		}

		public function fecha_servicio() {			
			configModelo::horas_no_disponibles($_POST['fecha']);
		}
		public function saveUsuario() {
			$datos= [
				'dni_appoint' => $_POST['dni_appoint'],
				'name_appoint' => $_POST['name_appoint'],
				'last_appoint' => $_POST['last_appoint'],
				'celphone_appoint' => $_POST['celphone_appoint'],
				'email_appoint' => $_POST['email_appoint'],
				'tipo' => 2,
				'estado' => 1,
			];
			// if(configModelo::saveUsuario_m($datos) != 0){

			$idInsert = configModelo::saveUsuario_m($datos);
			foreach (json_decode($_POST['permisosTemp']) as $permi) {
				$datos2 = [
					'user_id' => $idInsert->id,
					'tipo' => $permi->id,
				];
				configModelo::insertPermisoUser_m($datos2);
			}
			
			exit(json_encode(1));
		}
		public function saveServics() {
			$datos= [
				'nameserv' => $_POST['nameserv'],
				'descripserv' => $_POST['descripserv'],
				'precNserv' => $_POST['precNserv'],
				'precOserv' => $_POST['precOserv'],
				'prectiemserv' => $_POST['prectiemserv'],
				'estado' => 1,
			];

			

			$idInsert = configModelo::saveServics_m($datos);
			if($idInsert){
				foreach (json_decode($_POST['citaSelectt']) as $cita) {
					$datos2 = [
						'servicios' => $idInsert,
						'tipo_cita' => $cita->citaId,
					];
					configModelo::insertServicTypes_m($datos2);
				}
				foreach (json_decode($_POST['horasSelect']) as $hora) {
					$datos2 = [
						'hora' => $hora->hora,
						'estado' => 1,
						'servicios_id' => $idInsert,
					];
					configModelo::insertHoraServc_m($datos2);
				}
				exit(json_encode(1));
			}else{
				exit(json_encode('error'));
			}
		}

	} 