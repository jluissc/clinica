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

		public function idPayDirect() {
            $idAppoint = $_POST['idPayDirect'];
            $montoPayDirect = $_POST['montoPayDirect'];
			citaModelo::idPayDirect_m($idAppoint, $montoPayDirect);
		}		

		public function verificarFecha() {
            $fecha = $_POST['fecha'];
			citaModelo::verificarFecha_m($fecha);
		}

		public function buscarFechaCita() {
            $fecha = $_POST['fechaCita'];
            $diaId = $_POST['diaSelectsss'];
            $tipoId = $_POST['tipoServf'];
			citaModelo::buscarFechaCita_m($fecha,$tipoId,$diaId);
		}

		public function validarTransferencia() {
            $estado = $_POST['estadoTransf'];
            $id = $_POST['idPayAppoint'];
			citaModelo::validarTransferencia_m($id);
		}

		public function searchAppointPay() {
            $idAppointdV = $_POST['idAppointdV'];
			citaModelo::searchAppointPay_m($idAppointdV);
		}
		public function saveDatosPayAppoint() {
            // $fecha = $_POST['fechaCita'];
			$datos = [
				'numb_pay' => $_POST['numb_pay'],
				'name_bank' => $_POST['name_bank'],
				'total_pay' => $_POST['total_pay'],
				'idAppoint' => $_POST['idAppoint'],
			];
			citaModelo::saveDatosPayAppoint_m($datos);
		}

		public function reedListAppointment($tipo = false) {
            // $fecha = $_POST['fechaCita'];
			// citaModelo::reedListAppointment_m($tipo);
			$listAppointm = citaModelo::reedListAppointment_m($tipo);
			$html ='';
			foreach ($listAppointm as $appoint) {
				$btnPagar = '<button class="btn btn-outline-primary" onclick="payAppoint('.$appoint->id.')">Pagar Tarjeta</button><button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#info" onclick="datosTransf('.$appoint->id.',true)"> Mandar Transf.</button>';
			// 	$btnsAcc = $tipo ? $btnPagar : '<a>AVISAR AL CLIENTE ó</a> <div class="form-check form-switch">
			// 	<input class="form-check-input" type="checkbox" id="pagoDirecto">
			// 	<label class="form-check-label" for="pagoDirecto">Pagó directo?</label>
			//   </div>' ; 
				$btnsAcc = $tipo ? $btnPagar : '<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" id="pagoDirecto_'.$appoint->id.'" onchange="payDirect('.$appoint->id.')">
				<label class="form-check-label" for="pagoDirecto_'.$appoint->id.'">Pagó directo?</label>
			  </div>' ; 
				$btnPago = $tipo ? '<button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#info" onclick="datosTransf('.$appoint->id.',false)"> Datos Transf.</button>' : '<button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#info" onclick="validarTransf('.$appoint->id.')"> Validar Transf.</button>'; 
				$result = citaModelo::statusPayAppoint($appoint->id);
				// $pago = $result ? ($result[1]->tipo_pago_id == 1 ? '<span class="badge bg-success">Pago Tarjeta</span>' : ($result[1]->estado == 1 ? '<span class="badge bg-success">Transf. Verificado</span>' :'<span class="badge bg-danger">Transf. NO Verif.</span>')) : 'Falta Pagar';
				$pago = $result ? ($result[1]->tipo_pago_id == 1 ? '<span class="badge bg-warning">Pago Tarjeta</span>' : ($result[1]->tipo_pago_id == 3 ? '<span class="badge bg-info">Pago Directo</span>': ($result[1]->estado == 1 ? '<span class="badge bg-success">Transf. Verificado</span>' :'<span class="badge bg-danger">Transf. NO Verif.</span>'))) : '<strong>Falta Pagar/AVISAR AL CLIENTE</strong>';
				// $acciones = $result ? ($result[1]->tipo_pago_id == 2 && $result[1]->estado == 0 ? $btnPago: 'PAGADO') : $btnsAcc;
				$acciones = $result ? ($result[1]->tipo_pago_id == 2 && $result[1]->estado == 0 ? $btnPago: ($result[1]->tipo_pago_id == 3? 'PAGO DIRECTO' : ($result[1]->tipo_pago_id == 1 ? 'Pago Tarjeta' : 'Pago Transferencia'))) : ($btnsAcc);
				// $citaEstado = citaModelo::statusPayAppoint($appoint->id) ? 'PAGADO' : 'FALTA PAGAR' ;
				// $btnPagof = citaModelo::statusPayAppoint($appoint->id) ? $btnPago : '' ;
				$html .='<tr>
						<td>'.$appoint->nombre.' '.$appoint->apellidos.'</td>
						<td>'.$appoint->correo.'</td>
						<td>'.$appoint->celular.'</td>
						<td>'.$appoint->fecha.'</td>
						<td>'.$appoint->hora.'</td>';
						/* if($_SESSION['tipo']== 1) */ $html .='<td>S/. .00</td>';
				$html .='<td>'.$pago.'</td>
						<td>'.$acciones.'</td>							
					</tr>';
			}
			return $html; 
		}

		public function saveCita() {
			$user = json_decode($_POST['guardCitaUs']);
			if($user->iduser != 0){
				$datos = [
					'fecha' => $user->fecha,
					'tiempo' => 30,
					'mensaje' => '',
					'estado' => 1,
					'atentido' => 1,
					'paciente' => $user->iduser,
					'horas' => $user->hora,	
					'servicio' => $user->servicSelect,
				];
				$idCita = citaModelo::saveCita_m($datos,'new');
				if($user->servicSelect == 17){/* CAMBIAR el id de CONSULTAS */
					if( $idCita != 0){
						$datosr = [
							'nombre' => $user->nameHist,
							'persona_id' => $user->iduser,
							'code' => rand(1000,9999),
						];
						$idHist = citaModelo::saveHistorial_m($datosr);
						if( $idHist != 0){
							$datosr = [
								'historial_id' => $idHist,
								'tratamientos_id' => $idCita,
							];
							citaModelo::saveDetallHistorial_m($datosr);
						}else{
							exit(json_encode(0));
						}
					}else{
						exit(json_encode(0));
					}
				}else{
					$datosr = [
						'historial_id' =>  $user->listHistt,
						'tratamientos_id' => $idCita,
					];
					citaModelo::saveDetallHistorial_m($datosr);
				}
				
			}else{
				$datos = [
					'nombre' => $user->nombre,
					'apellidos' => $user->apellidos,
					'dni' => $user->dni,
					'celular' => $user->celular,
					'correo' => $user->correo,
					'user' => $user->dni,
					'pass' => $user->dni,
					'tipo' => 4,
					'estado' => 1,
				];
				$idUser = citaModelo::saveUsuario_m($datos);
				$datosc = [
					'fecha' => $user->fecha,
					'tiempo' => 30,
					'mensaje' => '',
					'estado' => 1,
					'atentido' => 1,
					'paciente' => $idUser->id,
					'horas' => $user->hora,	
					'servicio' => $user->servicSelect,
				];
				$idCita = citaModelo::saveCita_m($datosc,'new');
				if( $idCita != 0){
					$datosr = [
						'nombre' => $user->nameHist,
						'persona_id' => $idUser->id,
						'code' => rand(1000,9999),
					];
					$idHist = citaModelo::saveHistorial_m($datosr);
					if( $idHist != 0){
						$datosr = [
							'historial_id' => $idHist,
							'tratamientos_id' => $idCita,
						];
						citaModelo::saveDetallHistorial_m($datosr);
					}else{
						exit(json_encode(0));
					}
				}else{
					exit(json_encode(0));
				}
			}
			
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