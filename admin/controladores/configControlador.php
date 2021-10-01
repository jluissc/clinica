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
				$listHTML .= '<li><a class="dropdown-item">'.$list->nombre.' <span class="badge bg-info text-dark"><i class="far fa-clock"></i> '.$list->hora.'</span> '.$list->tipo.'</a></li>';
			}
			$listHTML .= '<li>
				<h6 class="dropdown-header" > <a href="'.SERVERURL.'citas">Citas de proximos dias</a></h6>
			</li>';
			foreach ($listsToday[1] as $list) {
				$listHTML .= '<li><a class="dropdown-item">'.$list->fecha.'-'.$list->nombre.' <span class="badge bg-info text-dark"><i class="far fa-clock"></i> '.$list->hora.'</span> '.$list->tipo.'</a></li>';
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
                'estado' => $_POST['estadoPerm'],
                'tipo' => $_POST['tipoPerm'],
                'user_id' => $_POST['user_idPerm'],
            ];
			configModelo::updatePermisoUser_m($datos);
		}

		public function fecha_servicio() {			
			configModelo::horas_no_disponibles($_POST['fecha']);
		}

	} 