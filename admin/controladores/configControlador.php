<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/configModelo.php';
	}else{
		require_once './modelos/configModelo.php';
	} 
 
	class configControlador extends configModelo	{
		
		public function addEditServics() {
			$datosServ = [
				'name' => $_POST['serv_name'],
				'status' => $_POST['serv_status'],
				'id' => $_POST['serv_addEdit'],
			];
			configModelo::addEditServics_m($datosServ);
		}
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
				$listHTML .= '<li><p class="text-center">'.$list->nombre.' ::: '.$list->namC .'</p><a class="dropdown-item">'.$list->fecha.' <span class="badge bg-info text-dark"><i class="far fa-clock"></i> </span> '.$list->hora.'  </a> </li><hr>';
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

		public function listsServicsIdd($id) {
			configModelo::listsServicsId_m($id);
		}
		public function deleteServicio() {
			$datos = [
				'id' => $_POST['idServiciD'],
				'tipo' => $_POST['tipoServ']
			];
			configModelo::deleteServicio_m($datos);
		}

		public function updatePermisoUser() {
			$datos = [
                'tipo' => $_POST['tipoPerm'],
                'user_id' => $_POST['user_idPerm'],
            ];
			configModelo::updatePermisoUser_m($datos);
		}
		public function datosCateg($id) {
			configModelo::datosCateg_m($id);
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
				'nameserv' => $_POST['name_cat'],
				'descripserv' => $_POST['descrip_cat'],
				'precNserv' => $_POST['precN_cat'],
				'precOserv' => $_POST['precO_cat'],
				'prectiemserv' => $_POST['prectiem_cat'],
				'estado' => $_POST['status_cat'],
				'tipo' => $_POST['tipo_cat'],
				'id_serv' => $_POST['id_serv'],
				// 'idServicEdit' => $_POST['id_serv'],
			];			
			if($_POST['tipo_cat']){/* EDITAR */
				$idInsert = configModelo::saveServics_m($datos);
				if(count(json_decode($_POST['horasSelect']))>0){
					$reso = [];
					foreach (json_decode($_POST['horasSelect']) as $hora) {
						$datos2 = [
							'id' => $hora->id,
							'estado' => 0,
						];
						configModelo::insertHoraServc_m($datos2,true);
					}
					exit(json_encode($reso));
				}else{
					exit(json_encode('sin camb'));
				}
			}else{ /* crear categoria */
				$idInsert = configModelo::saveServics_m($datos);
				if($idInsert){
					foreach (json_decode($_POST['diasSelect']) as $dia) {
						foreach (json_decode($_POST['tiposSelect']) as $cita) {
							$datos2 = [
								'servicios' => $idInsert,
								'tipo_cita' => $cita->id,
								'estado' => 1,
								'dia' => $dia->id,
							];
							configModelo::insertServicTypes_m($datos2);
						}
					}
					foreach (json_decode($_POST['horasSelect']) as $hora) {
						$datos2 = [
							'hora' => $hora->hora,
							'estado' => 1,
							'servicios_id' => $idInsert,
						];
						configModelo::insertHoraServc_m($datos2);
					}
					exit(json_encode(configModelo::listServics_m()));
				}else{
					exit(json_encode('error'));
				}
			}
			
		}

	} 