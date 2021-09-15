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
			// citaModelo::reedListAppointment_m($tipo);
			$listAppointm = citaModelo::reedListAppointment_m($tipo);
			$html ='';
			foreach ($listAppointm as $appoint) {
				$btnPagar = '<button class="btn btn-outline-primary" onclick="payAppoint('.$appoint->id.')">Pagar Tarjeta</button><button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#info" onclick="datosTransf('.$appoint->id.')"> Mandar Transf.</button>';
				$btnsAcc = $tipo ? $btnPagar : 'AVISAR AL CLIENTE'; 
				$btnPago = $tipo ? '<button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#info" onclick="datosTransf('.$appoint->id.',0)"> Datos Transf.</button>' : '<button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#info"> Validar Transf.</button>'; 
				$result = citaModelo::statusPayAppoint($appoint->id);
				$pago = $result ? ($result[1]->tipo_pago_id == 1 ? '<span class="badge bg-success">Pago directo</span>' : ($result[1]->estado == 1 ? '<span class="badge bg-success">Transf. Verificado</span>' :'<span class="badge bg-danger">Transf. NO Verif.</span>')) : 'Falta Pagar';
				$acciones = $result ? ($result[1]->tipo_pago_id == 2 && $result[1]->estado == 0 ? $btnPago: 'PAGADO') : $btnsAcc;
				// $citaEstado = citaModelo::statusPayAppoint($appoint->id) ? 'PAGADO' : 'FALTA PAGAR' ;
				// $btnPagof = citaModelo::statusPayAppoint($appoint->id) ? $btnPago : '' ;
				$html .='<tr>
						<td>'.$appoint->nombre.' '.$appoint->apellidos.'</td>
						<td>'.$appoint->correo.'</td>
						<td>'.$appoint->celular.'</td>
						<td>'.$appoint->fecha.'</td>
						<td>'.$appoint->hora.'</td>
						<td>'.$pago.'</td>
						<td>'.$acciones.'</td>							
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
		
		public function reedListPayAppoint(){
			$listAppointm = citaModelo::reedListPayAppoint_m();
			$html ='';
			foreach ($listAppointm as $appoint) {
				// $citaEstado = citaModelo::StatusPayAppoint($appoint->id) ? 'PAGADO' : 'FALTA PAGAR' ;
				$html .='<tr>
						<td>'.$appoint->nombre.' '.$appoint->apellidos.'</td>
						<td>'.$appoint->correo.'</td>
						<td>'.$appoint->celular.'</td>
						<td>'.$appoint->fecha.'</td>
						<td>'.$appoint->hora.'</td>
						<td>'.$appoint->hora.'</td>
						<td>
							<button class="btn btn-outline-info"> Detalles</button>
					</tr>';
			}
			return $html; 
		}

	} 