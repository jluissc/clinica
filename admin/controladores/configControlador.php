<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/configModelo.php';
	}else{
		require_once './modelos/configModelo.php';
	} 
 
	class configControlador extends configModelo	{
		public function datosUser(){
			configModelo::datosUser_m();
		  }	
		public function updateDatos(){
			configModelo::updateDatos_m($_POST['userUpdate']);
		  }	
		public function updateEmpresa(){
			configModelo::updateEmpresa_m($_POST['empresaUpdate']);
		  }	
		public function datosEmpresa(){
			configModelo::datosEmpresa_m();
			// $dates = configModelo::datosEmpresa_m();
			// return $dates;
		  }	
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
			$datosConf = [
				'code' => rand(10001, 99999),
				'name' => $_POST['inp_nameConf'],
				'horaInicio' => $_POST['inp_horaInicio'],
				'horaFin' => $_POST['inp_horaFin'],
				'id_serv' => $_POST['id_servSelc'],
			];
			$idConfig = configModelo::saveConfig_m($datosConf);
			foreach (json_decode($_POST['inp_diasAt']) as $dia) { 
				foreach (json_decode($_POST['inp_tipoAt']) as $tipo) {
					$datos = [
						'dia' => $dia->id,
						'tipo' => $tipo->id,
						'idConfig' => $idConfig,
						'inicio' => $_POST['inp_horaInicio'],
						'fin' => $_POST['inp_horaFin'],
					];
					configModelo::saveConfigDiaHora_m($datos);
				}
			}
			exit(json_encode(configModelo::listConfig_m()));
		}

		public function listNotifications() {
			$listsToday = configModelo::listNotifications_m();

			$listHTML = '<li >
				<h6 class="dropdown-header" > <a href="'.SERVERURL.'citas">Citas de hoy</a></h6>
			</li>';
			if ($listsToday[0]) {
				foreach ($listsToday[0] as $list) {
					$listHTML .= '<li class="list-group-item  align-items-center">
					<span style="font-size: 12px;"> '.$list->serv.' ::: '.$list->cat .'</span>
					<span style="font-size: 12px;"> '.$list->nombre.' ::: '.$list->namC .'</span>
					<span class="badge bg-warning badge-pill badge-round ml-1">'.$list->fecha.' :: '.$list->hora.'</span>
				</li>';
				}
			} else {
				$listHTML .= '<li class="dropdown-header text-center"><strong>No hay cita hoy, por el momento</strong></li> <hr>';
			}
			$listHTML .= '<li>
				<h6 class="dropdown-header" > <a href="'.SERVERURL.'citas">Citas de proximos dias</a></h6>
			</li>';
			if(count($listsToday[1])>0){

				foreach ($listsToday[1] as $list) {
					$listHTML .= '<li class="list-group-item  align-items-center">
							<span style="font-size: 12px;"> '.$list->serv.' ::: '.$list->cat .'</span>
							<span style="font-size: 12px;"> '.$list->nombre.' ::: '.$list->namC .'</span>
							<span class="badge bg-warning badge-pill badge-round ml-1">'.$list->fecha.' :: '.$list->hora.'</span>
						</li>';
				}
			} else {
				$listHTML .= '<li class="dropdown-header text-center"><strong>No hay cita proximas, por el momento</strong></li> <hr>';
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
			if(configModelo::tipoUser_m($_POST['id_cust'])){
				foreach (json_decode($_POST['permisosTemp']) as $permi) {
					$datos2 = [
						'user_id' => $_POST['id_cust'],
						'tipo' => $permi->id,
					];
					configModelo::insertPermisoUser_m($datos2);
				}
				exit(json_encode(configModelo::listarUsers_m()));
			}else{
				exit(json_encode(0));
			}			
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
				'consult_type' => $_POST['consult_type'],
				'cant_Time' => $_POST['cant_Time'],
				'id_serv' => $_POST['id_serv'],
				// 'idServicEdit' => $_POST['id_serv'],
			];			
			if($_POST['tipo_cat']){/* EDITAR */
				if(configModelo::saveServics_m($datos)){
					exit(json_encode(1));
				}else{
					exit(json_encode(0));
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
					exit(json_encode([configModelo::listServics_m(),configModelo::listaServGen_m()]));
				}else{
					exit(json_encode('error'));
				}
			}
			
		}

	} 