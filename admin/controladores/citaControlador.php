<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/citaModelo.php';
	}else{
		require_once './modelos/citaModelo.php';
	} 

	class citaControlador extends citaModelo	{

		public function listaServic() {
			citaModelo::listaServic_m();
		}
		
		public function verificarDni() {
            $dni = $_POST['dni'];
			citaModelo::verificarDni_m($dni);
		}
		

		public function verificarFecha() {
            $fecha = $_POST['fecha'];
			citaModelo::verificarFecha_m($fecha);
		}

		public function buscarFechaCita() {
            $fecha = $_POST['fechaCita'];
			citaModelo::buscarFechaCita_m($fecha);
		}

		public function reedListAppointment($tipo = false) {
            // $fecha = $_POST['fechaCita'];
			citaModelo::reedListAppointment_m($tipo);
			$listAppointm = citaModelo::reedListAppointment_m($tipo);
			$html ='';
			foreach ($listAppointm as $appoint) {
				$html .='<tr>
						<td>'.$appoint->nombre.' '.$appoint->apellidos.'</td>
						<td>'.$appoint->correo.'</td>
						<td>'.$appoint->celular.'</td>
						<td>'.$appoint->fecha.'</td>
						<td>'.$appoint->hora.'</td>
						<td>
							<span class="badge bg-success">Activo</span>
						</td>
					</tr>';
			}
			return $html; 
		}

		public function saveCita() {
			$datos = [
				'idUser' => $_POST['idUser'],
				'idServic' => $_POST['idServic'],
				'idHora' => $_POST['idHora'],
				'fecha' => $_POST['fechaf'],
				'tiempo' => 30,
				'estado' => 1,
				'tipo' => $_POST['tipoCita'],

			];
			citaModelo::saveCita_m($datos);
		}

		

	} 