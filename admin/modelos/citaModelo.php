<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class citaModelo extends mainModelo
	{
		/* *************** */
		protected static function verificarDni_m($dni){
			$sql = mainModelo::conexion()->prepare("SELECT id, nombre, apellidos,celular, correo FROM persona WHERE dni = $dni");
			$sql -> execute();
            if($sql -> rowCount() > 0){
                $resutl = $sql->fetch(PDO::FETCH_OBJ);
				$datos = [
					'user' => $resutl,
					'listHist' => citaModelo::ListHIstorial_m($resutl->id),
				];
				exit(json_encode($datos));
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}

		protected static function ListHIstorial_m($idPers){
			$sql = mainModelo::conexion()->prepare("SELECT id, code, nombre FROM historial WHERE persona_id = $idPers");
			$sql -> execute();
            if($sql -> rowCount() > 0){
                return  $sql->fetchAll(PDO::FETCH_OBJ);
			}else{
				return 0;
			}
		}
		/* ************** */
		protected static function buscarFechaCita_m($fecha,$tipoId,$diaId){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM tratamientos WHERE fecha =:fecha');
			$sql->bindParam(":fecha",$fecha);
			$sql -> execute();
            if($sql -> rowCount() > 0){
                $resutl = $sql->fetchAll(PDO::FETCH_OBJ);	
				$datos = [
					'tipoCita' => citaModelo::listarTipoCitas($tipoId),
					'dias' => citaModelo::listardiaHoraAtencion($diaId,$tipoId),
					'horas' => citaModelo::listarHorasDias($tipoId),
					'citas' => $resutl,
				];	
				exit(json_encode($datos));			
			}else{				
				$datos = [
					'tipoCita' => citaModelo::listarTipoCitas($tipoId),
					'dias' => citaModelo::listardiaHoraAtencion($diaId,$tipoId),
					'horas' => citaModelo::listarHorasDias($tipoId),
					'citas' => 0,
				];
				exit(json_encode($datos));			
			}
		}
		/* ************** */
		protected static function listarTipoCitas($tipoId){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM servicios_tipo WHERE servicios_id =:tipo');
			$sql->bindParam(":tipo",$tipoId);
			$sql -> execute();  
			if($sql -> rowCount() > 0){
				$resutl = $sql->fetchAll(PDO::FETCH_OBJ);	
				return $resutl;
			}else{
				return 0;          
			}
		}
		/* ************** */
		protected static function listardiaHoraAtencion($diaId,$tipoId){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM dias_hora_atencion 
			WHERE dias_id =:dia');
			$sql->bindParam(":dia",$diaId);
			// $sql->bindParam(":tipo",$tipoId);
			$sql -> execute();  
			if($sql -> rowCount() > 0){
				$resutl = $sql->fetchAll(PDO::FETCH_OBJ);	
				return $resutl;
			}else{
				return 0;          
			}
		}
		/* ************** */
		protected static function listarHorasDias($tipoId){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM horas WHERE servicios_id =:dia');
			$sql->bindParam(":dia",$tipoId);
			$sql -> execute();  
			if($sql -> rowCount() > 0){
				$resutl = $sql->fetchAll(PDO::FETCH_OBJ);	
				return $resutl;
			}else{
				return 0;          
			}
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
				$sql = mainModelo::conexion()->prepare("SELECT * FROM tratamientos c 
					INNER JOIN persona p
					ON p.id = c.paciente_id
					INNER JOIN horas h
					ON h.id = c.horas_id 
					WHERE p.id=:id
					ORDER BY c.id DESC");
				$sql->bindParam(":id",$idPaciente);
			}else{
				$sql = mainModelo::conexion()->prepare("SELECT * FROM tratamientos c 
					INNER JOIN persona p
					ON p.id = c.paciente_id
					INNER JOIN horas h
					ON h.id = c.horas_id
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
			$sql = mainModelo::conexion()->prepare('SELECT tipo_pago_id1, estado FROM cita_pagos WHERE citas_id = '.$idAppoint.'');
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

		protected static function buscarFechddddaCita_m($fecha){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM tratamientos WHERE fecha =:fecha');
			$sql->bindParam(":fecha",$fecha);
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

		
		protected static function saveCita_m($datos,$tipo =''){
			$pdo = mainModelo::conexion();
			$sql = $pdo->prepare("INSERT INTO tratamientos (`fecha`, `tiempo`, `mensaje`, `estado`, `atentido`, `paciente_id`, `horas_id`, `servicios_id`) 
				VALUES (:fecha, :tiempo, :mensaje, :estado, :atentido, :paciente, :horas, :servicio)");
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":tiempo",$datos['tiempo']);
			$sql->bindParam(":mensaje",$datos['mensaje']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":atentido",$datos['atentido']);
			$sql->bindParam(":paciente",$datos['paciente']);
			$sql->bindParam(":horas",$datos['horas']);
			$sql->bindParam(":servicio",$datos['servicio']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				if($tipo != ''){
					return $pdo->lastInsertId();
				}else{
					// $sql = null;
					exit(json_encode(1));
				}
			}else{
				if($tipo != ''){
					return 0;
				}else{
					// $sql = null;
					exit(json_encode(0));
				}
			}
		}
		protected static function saveHistorial_m($datos){
			$pdo = mainModelo::conexion();
			$sql = $pdo->prepare("INSERT INTO historial (`code`, `persona_id`, `nombre`) 
				VALUES (:code, :persona_id, :nombre)");
			$sql->bindParam(":code",$datos['code']);
			$sql->bindParam(":persona_id",$datos['persona_id']);
			$sql->bindParam(":nombre",$datos['nombre']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				return $pdo->lastInsertId();
				
			}else{
				return 0;				
			}
		}

		protected static function saveDetallHistorial_m($datos){
			$pdo = mainModelo::conexion();
			$sql = $pdo->prepare("INSERT INTO `historial_detalle`(`historial_id`, `tratamientos_id`)
				VALUES (:historial_id, :tratamientos_id)");
			$sql->bindParam(":historial_id",$datos['historial_id']);
			$sql->bindParam(":tratamientos_id",$datos['tratamientos_id']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				exit(json_encode(1));				
			}else{
				exit(json_encode(0));			
			}
		}

		protected static function saveUsuario_m($datos){
			$sql = mainModelo::conexion()->prepare('INSERT INTO persona (`nombre`, `apellidos`, `dni`,
				`celular`, `correo`,  `user`,`password`, `tipo_user_id`, `estado`) 
				VALUES(:nombre, :apellidos, :dni, :celular, :correo,
				 :user, :pass, :tipo, :estado)');				
			$sql->bindParam(":nombre",$datos['nombre']);
			$sql->bindParam(":apellidos",$datos['apellidos']);
			$sql->bindParam(":dni",$datos['dni']);	
			$sql->bindParam(":celular",$datos['celular']);
			$sql->bindParam(":correo",$datos['correo']);
			$sql->bindParam(":user",$datos['user']);	
			$sql->bindParam(":pass",$datos['pass']);
			$sql->bindParam(":tipo",$datos['tipo']);
			$sql->bindParam(":estado",$datos['estado']);

			if($sql -> execute()){
				if($sql->rowCount()== 1){
					$consult = mainModelo::ejecutar_consulta_simple('SELECT id FROM persona WHERE dni = '.$datos["dni"].'');
					$IdInsert = $consult->fetch(PDO::FETCH_OBJ);
					return $IdInsert;				
				}else{
					$sql = null;
					return 0;
				}	
			}else{
				$sql = null;
				return 0;
			}
		}

		
	}