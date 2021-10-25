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

		public function reedHistorialApoointId() {

			// citaModelo::reedHistorialApoointId_m($_POST['idHistorial']);
			$div = '';
			$lista = citaModelo::reedHistorialApoointId_m($_POST['idHistorial']);
			foreach ($lista as $listt) {
				$list = citaModelo::listaDescr($listt->id);
				$descrip = $list[0] ? $list[1]->descripcion : '';
				$div .='<li>
					<div>
						<time>'.$listt->fecha.' '.$listt->hora.'</time> 
						<hr><p>SERVICIO : '.$listt->servicio.'</p>
						<hr><p>DESCRIPCIÓN : '.$descrip .'</p>
					</div>
				</li>';
			}
			exit(json_encode($div));

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
		public function leerListTratamientos() {
            // $fecha = $_POST['fechaCita'];
			$datos = [
				'numb_pay' => $_POST['numb_pay'],
				'name_bank' => $_POST['name_bank'],
				'total_pay' => $_POST['total_pay'],
				'idAppoint' => $_POST['idAppoint'],
			];
			citaModelo::saveDatosPayAppoint_m($datos);
		}

		public function reedListAppointment() {
			session_start(['name' => 'bot']);
			$tipo = $_SESSION['tipo'];
			$datos =[];
			$listAppointm = citaModelo::reedListAppointment_m();
			foreach ($listAppointm as $appoint) {
				$nn = $appoint->usuario.' '.$appoint->apellidos;
				$pagoDirecto = '<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" id="pagoDirecto_'.$appoint->idcita.'" onchange="payDirect('.$appoint->idcita.')">
					<label class="form-check-label" for="pagoDirecto_'.$appoint->idcita.'">Pagó directo?</label>
					</div>' ; 
				$result = citaModelo::statusPayAppoint($appoint->idcita);
				$montopago = $result[0] ? $result[1]->total : 0.0;
				$pago = $result[0] ? ($result[1]->tipo_pago_id1 == 1 ? ($result[1]->estado ? 'Pago Tarjeta/Aceptado' : 'Pago Tarjeta/No Aceptado'): ($result[1]->tipo_pago_id1 == 2 ? ($result[1]->estado ? 'Transferencia/Aceptado' : 'Transferencia/No Aceptado') : ($result[1]->estado ? 'Pago Directo/Aceptado' : 'Pago Directo/No Aceptado'))) : 'Falta Pagar';
				$acciones = $tipo == 1 ? ($result[0] ? ($result[1]->tipo_pago_id1 == 1 ? 'Pago Tarjeta' : ($result[1]->tipo_pago_id1 == 2 ? ($result[1]->estado ? 'Pago Transferencia Activo' :'<button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#info" onclick="validarTransf('.$appoint->idcita.')"> Validar Transf.</button>') : 'Pago Directo') ) : $pagoDirecto) : 
					($result[0] ? ($result[1]->tipo_pago_id1 == 2 ? ($result[1]->estado ? 'Aceptado' : 'Falta Verificar'): 'Pagado' ) : '<button class="btn btn-outline-primary" onclick="payAppoint('.$appoint->idcita.')">Pagar Tarjeta</button><button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#info" onclick="datosTransf('.$appoint->idcita.',true)"> Mandar Transf.</button>');
				array_push($datos,[
					'nombre' => $nn,
					'dni' => $appoint->dni,
					'correo' => $appoint->correo,
					'celular' => $appoint->celular,
					'fecha' => $appoint->fecha,
					'hora' => $appoint->hora, 
					'monto' => 'S/. '.$appoint->precio_venta ,
					'total' => 'S/. '.$montopago,
					'pago' =>  $pago,
					'acciones' => $acciones,
				]);
			}
			exit(json_encode($datos));//envio el array final el formato json a AJAX
		}
		public function reedListHistorialAppointment() {
			session_start(['name' => 'bot']);
			$datos =[];
			$listAppointm = citaModelo::reedListHistorialAppointment_m();
			foreach ($listAppointm as $appoint) {
				$acciones = '<button class="btn btn-outline-primary" onclick="showHistorial('.$appoint->idHis.')">Ver Historial</button>';
				$nn = $appoint->usuario.' '.$appoint->apellidos;
				
				array_push($datos,[
					'nombre' => $nn,
					'dni' => $appoint->dni,
					'correo' => $appoint->correo,
					'celular' => $appoint->celular,
					'name' => $appoint->nameC,
					'code' => $appoint->code,
					'acciones' => $acciones,
				]);
			}
			exit(json_encode($datos));//envio el array final el formato json a AJAX
		}
		public function searchHistUser(){
			session_start(['name' => 'bot']);
			$id = $_SESSION['id'];
			$res = citaModelo::ListHIstorial_m($id);
			exit(json_encode($res));
		}

		public function saveCita() {
			$user = json_decode($_POST['guardCitaUs']);
			if($user->iduser != 0){
				
				$datos = [
					'fecha' => $user->fecha,
					'tiempo' => 30,
					'mensaje' => '',
					'estado' => 1,
					'atentido' => 0,
					'paciente' => $user->tipoUse == 4 ? $user->idUPaci : $user->iduser,
					'horas' => $user->hora,	
					'servicio' => $user->servicSelect,
					'tipo_cita_id' => $user->cita,
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
					'atentido' => 0,
					'paciente' => $idUser->id,
					'horas' => $user->hora,	
					'servicio' => $user->servicSelect,
					'tipo_cita_id' => $user->cita,
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