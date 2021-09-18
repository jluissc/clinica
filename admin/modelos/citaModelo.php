<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class citaModelo extends mainModelo
	{
		
		protected static function verificarDni_m($dni){
			$sql = mainModelo::conexion()->prepare("SELECT id, nombre, apellidos,celular, correo FROM persona WHERE dni = $dni");
			$sql -> execute();
            if($sql -> rowCount() > 0){
                $resutl = $sql->fetch(PDO::FETCH_OBJ);
				exit(json_encode($resutl));
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}

		protected static function idPayDirect_m($idAppoint, $monto=50){
			$sql = mainModelo::conexion()->prepare('INSERT INTO cita_pagos (`tipo_pago_id`, `detalles`, `medio_pago`, `fecha`, `total`, `estado`, `citas_id`)
				VALUES (3, "PAGO DIRECTO", "FISICO", now(), :monto, 1, :cita_id)');
			$sql->bindParam(":monto",$monto);
			$sql->bindParam(":cita_id",$idAppoint);
			$sql -> execute();
            if($sql -> rowCount() > 0){
				$sql = null;
				exit(json_encode(1));
			}else{
				$sql = null;
				exit(json_encode(0));
			}
		}

		protected static function reedListAppointment_m($tipo){
			// session_start(['name' => 'bot']);
			$idPaciente = $tipo ? $idPaciente = $_SESSION['id'] : '';
			if($tipo){
				$sql = mainModelo::conexion()->prepare("SELECT p.nombre, p.apellidos, p.celular, p.correo, c.id, c.fecha, c.tipo_cita_id, h.hora, tc.precio FROM citas c 
					INNER JOIN persona p
					ON p.id = c.paciente_id
					INNER JOIN horas h
					ON h.id = c.horas_id 
					INNER JOIN tipo_cita tc
					ON tc.id = c.tipo_cita_id
					WHERE p.id=:id
					ORDER BY c.id DESC");
				$sql->bindParam(":id",$idPaciente);
			}else{
				$sql = mainModelo::conexion()->prepare("SELECT p.nombre, p.apellidos, p.celular, p.correo, c.id, c.fecha, c.tipo_cita_id, h.hora, tc.precio FROM citas c 
					INNER JOIN persona p
					ON p.id = c.paciente_id
					INNER JOIN horas h
					ON h.id = c.horas_id
					INNER JOIN tipo_cita tc
					ON tc.id = c.tipo_cita_id
					ORDER BY c.id DESC");
			}
			$sql -> execute();
			$resutl = $sql->fetchAll(PDO::FETCH_OBJ);				
			$sql = null;
			return $resutl;
			// exit(json_encode($resutl));
		}

		protected static function verificarFecha_m($fecha){
			$sql = mainModelo::conexion()->prepare('SELECT id, fecha, horas_id FROM citas WHERE fecha = "'.$fecha.'"');
			$sql -> execute();
            if($sql -> rowCount() > 0){
                $resutl = $sql->fetchAll(PDO::FETCH_OBJ);
				exit(json_encode($resutl));
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}

		protected static function reedListPayAppoint_m(){
			$sql = mainModelo::conexion()->prepare('SELECT id, fecha, horas_id FROM citas WHERE fecha = "'.$fecha.'"');
			$sql -> execute();
            if($sql -> rowCount() > 0){
                $resutl = $sql->fetchAll(PDO::FETCH_OBJ);
				exit(json_encode($resutl));
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}
		protected static function statusPayAppoint($idAppoint){
			$sql = mainModelo::conexion()->prepare('SELECT tipo_pago_id, estado FROM cita_pagos WHERE citas_id = '.$idAppoint.'');
			$sql -> execute();
            if($sql -> rowCount() == 1){
				$resutl = $sql->fetch(PDO::FETCH_OBJ);
				$sql = null;
                return [true,$resutl];
			}else{
				$sql = null;
                return false;
			}
		}

		protected static function buscarFechaCita_m($fecha){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM cita_no_atencion WHERE dia =:dia');
			$sql->bindParam(":dia",$fecha);
			$sql -> execute();
            if($sql -> rowCount() > 0){
                $resutl = $sql->fetchAll(PDO::FETCH_OBJ);
				$datos = [
					'citaNoAten' => $resutl,
					'horaNoAten' => citaModelo::buscarHoraCita_m($fecha),
					'horaOcupadasCita' => citaModelo::buscarCitaOcupadas_m($fecha),
				];
				exit(json_encode($datos));
			}else{
				$datos = [
					'citaNoAten' => 0,
					'horaNoAten' => citaModelo::buscarHoraCita_m($fecha),
					'horaOcupadasCita' => citaModelo::buscarCitaOcupadas_m($fecha),
				];
				exit(json_encode($datos));
			}
			$sql = null;
		}

		protected static function buscarHoraCita_m($fecha){
			$sql = mainModelo::conexion()->prepare('SELECT hh.horas_id, h.hora  FROM horas_no_atencion hh
				INNER JOIN `horas` h
				ON h.id = hh.horas_id
				WHERE dia =:dia');
			$sql->bindParam(":dia",$fecha);
			$sql -> execute();
            $resutl = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $resutl;
		}

		protected static function validarTransferencia_m($idAppointPay){
			$sql = mainModelo::conexion()->prepare('UPDATE `cita_pagos` SET estado = 1
				WHERE id ='.$idAppointPay.'');
			$sql -> execute();
			// $sql = null;
			if ($sql->rowCount()== 1) {
				exit(json_encode(1));
			} else {
				exit(json_encode(0));
			}
			// return $resutl;
		}

		protected static function saveDatosPayAppoint_m($datos){
			$sql = mainModelo::conexion()->prepare('INSERT INTO `cita_pagos`(`tipo_pago_id`, `detalles`, `medio_pago`, `fecha`, `total`, `estado`, `citas_id`) 
				VALUES (2, :numPago, :medioPago, now(), :total, 0 , :citaId)');
			$sql->bindParam(":numPago",$datos['numb_pay']);
			$sql->bindParam(":medioPago",$datos['name_bank']);
			$sql->bindParam(":total",$datos['total_pay']);
			$sql->bindParam(":citaId",$datos['idAppoint']);
			$sql -> execute();
			if ($sql->rowCount()== 1) {
				exit(json_encode(1));
			} else {
				exit(json_encode(0));
			}
		}

		protected static function searchAppointPay_m($idAppoint){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM cita_pagos WHERE citas_id = '.$idAppoint.'');
			$sql -> execute();
			$listaDatos = $sql->fetch(PDO::FETCH_OBJ);
			if ($sql->rowCount()== 1) {
				exit(json_encode($listaDatos));
			} else {
				exit(json_encode(0));
			}
		}
		protected static function buscarCitaOcupadas_m($fecha){
			$sql = mainModelo::conexion()->prepare('SELECT hh.horas_id, h.hora  FROM citas hh
				INNER JOIN `horas` h
				ON h.id = hh.horas_id
				WHERE fecha =:dia');
			$sql->bindParam(":dia",$fecha);
			$sql -> execute();
            $resutl = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $resutl;
		}

		protected static function listaServic_m(){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM servicios");
			$sql -> execute();
			$listaDatos = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			$datos = [
				'listaServ' => $listaDatos,
				'listaTipoCit' => citaModelo::listaTipoCita_m(),
			];
			exit(json_encode($datos));
		}

		protected static function listaTipoCita_m(){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM tipo_cita");
			$sql -> execute();
			$listaDatos = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $listaDatos;
		}

		
		protected static function saveCita_m($datos){
			$sql = mainModelo::conexion()->prepare("INSERT INTO citas (`fecha`, `horas_id`, `tiempo`,  `estado`, `paciente_id`, `producto_id`, `tipo_cita_id`) 
				VALUES (:fecha, :idHora, :tiempo, :estado, :idUser, :idServic, :tipo)");
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":idHora",$datos['idHora']);
			$sql->bindParam(":tiempo",$datos['tiempo']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":idUser",$datos['idUser']);
			$sql->bindParam(":idServic",$datos['idServic']);
			$sql->bindParam(":tipo",$datos['tipo']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				// session_start(['name' => 'bot']);
				// if($_SESSION['tipo']==1 || in_array(3, $_SESSION['permisos']) ){
				// 	citaModelo::reedListAppointment_m(false);
				// }
				// elseif ($_SESSION['tipo']==4) {
				// 	citaModelo::reedListAppointment_m(true);
				// }
				exit(json_encode(1));
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}

		
	}