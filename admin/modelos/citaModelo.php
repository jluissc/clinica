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
		protected static function buscarFechaCita_m($fecha,$cat,$diaId, $serv){		
			$sql = mainModelo::conexion()->prepare('SELECT * FROM tratamientos WHERE fecha =:fecha AND servicios_id =:id');
			$sql->bindParam(":fecha",$fecha);
			$sql->bindParam(":id",$cat);
			$sql -> execute();
            if($sql -> rowCount() > 0){
                $resutl = $sql->fetchAll(PDO::FETCH_OBJ);	
				$datos = [
					'citas' => $resutl,
					'diaDisponi' => citaModelo::checkDay($serv,$diaId),
					'horas' => citaModelo::listarHorasDias($cat),
					'tipoCita' => citaModelo::listarTipoCitas($cat,$diaId),		
				];	
				exit(json_encode($datos));			
			}else{				
				$datos = [
					'citas' => 0,
					'diaDisponi' => citaModelo::checkDay($serv,$diaId),
					'horas' => citaModelo::listarHorasDias($cat),
					'tipoCita' => citaModelo::listarTipoCitas($cat,$diaId),
				];
				exit(json_encode($datos));			
			}
		}
		// **********************************
		protected static function reedHistorialApoointId_m($idHistorial){
			$sqlF = mainModelo::conexion()->prepare("SET GLOBAL lc_time_names = 'es_ES'");
			$sqlF -> execute();
			$sql = mainModelo::conexion()->prepare("SELECT t.id, DATE_FORMAT(t.fecha, '%d de %b %Y') as fecha, h.hora, s.nombre AS servicio FROM historial_detalle hd
				INNER JOIN tratamientos t
				ON hd.tratamientos_id = t.id
				INNER JOIN servicios s
				ON t.servicios_id = s.id
				INNER JOIN horas h
				ON t.horas_id = h.id
				WHERE historial_id =:id ORDER BY hd.id");
			$sql->bindParam(":id",$idHistorial);
			$sql -> execute();
            if($sql -> rowCount() > 0){
                $resutl = $sql->fetchAll(PDO::FETCH_OBJ);					
				// exit(json_encode($resutl));			
				return $resutl;	
			}else{
				exit(json_encode(0));
			}
		}
		/* ************** */
		protected static function listaDescr($idTrat){
			$sql = mainModelo::conexion()->prepare('SELECT descripcion FROM tratamiento_detalle WHERE tratamientos_id =:id');
			$sql->bindParam(":id",$idTrat);
			$sql -> execute();  
			if($sql -> rowCount() > 0){
				$resutl = $sql->fetch(PDO::FETCH_OBJ);	
				return [true,$resutl];
			}else{
				return [false];          
			}
		}
		protected static function checkDay($serv,$diaId){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM dias_hora_atencion dh
			INNER JOIN config c
			ON c.id = dh.config_id 			
			WHERE c.servicio_general_id =:serv AND dh.dias_id =:dia');
			$sql->bindParam(":serv",$serv);
			$sql->bindParam(":dia",$diaId);
			$sql -> execute();  
			if($sql -> rowCount() > 0){
				$resutl = $sql->fetchAll(PDO::FETCH_OBJ);	
				return $resutl;
			}else{
				return 0;          
			}
		}
		protected static function listarTipoCitas($tipoId,$diaId){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM servicios_tipo_dias WHERE servicios_id =:tipo and dias_id =:dia');
			$sql->bindParam(":tipo",$tipoId);
			$sql->bindParam(":dia",$diaId);
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
		protected static function listarHorasDias($cat){
			$sql = mainModelo::conexion()->prepare('SELECT * FROM horas WHERE servicios_id =:id');
			$sql->bindParam(":id",$cat);
			$sql -> execute();  
			if($sql -> rowCount() > 0){
				$resutl = $sql->fetchAll(PDO::FETCH_OBJ);	
				return $resutl;
			}else{
				return 0;          
			}
		}

		protected static function idPayDirect_m($idAppoint, $monto=50){
			$sql = mainModelo::conexion()->prepare('INSERT INTO tratamiento_pagos (`tipo_pago_id`, `detalles`, `medio_pago`, `fecha`, `total`, `estado`, `tratamientos_id`)
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

		protected static function reedListAppointment_m(){
			// echo $tipo;
			$sqlF = mainModelo::conexion()->prepare("SET GLOBAL lc_time_names = 'es_ES'");
			$sqlF -> execute();
			// $idPaciente = $tipo ? $_SESSION['id'] : '';
			// if($_SESSION['tipo'] == 4 || $_SESSION['tipo'] == 2){
			if($_SESSION['tipo'] == 4 ){
				$sql = mainModelo::conexion()->prepare("SELECT p.nombre AS usuario, DATE_FORMAT(c.fecha, '%d de %b %Y') as fecha, c.id AS idcita, p.apellidos, p.celular, 
					p.correo, h.hora, s.precio_venta, p.dni,s.nombre as cat, sg.nombre FROM tratamientos c
					INNER JOIN persona p
					ON p.id = c.paciente_id
					INNER JOIN horas h
					ON h.id = c.horas_id 
					INNER JOIN servicios s
					ON s.id = c.servicios_id
					INNER JOIN servicio_general sg
					ON sg.id = s.servicio_general_id
					WHERE p.id=:iss
					ORDER BY c.id DESC");
				$sql->bindParam(":iss",$_SESSION['id']);
			}else{
				$sql = mainModelo::conexion()->prepare("SELECT p.nombre AS usuario, p.apellidos, 
					p.correo, p.dni, p.celular, DATE_FORMAT(c.fecha, '%d de %b %Y') as fecha, c.id AS idcita,  
					h.hora, s.precio_venta, s.nombre as cat, sg.nombre FROM tratamientos c 
					INNER JOIN persona p
					ON p.id = c.paciente_id
					INNER JOIN horas h
					ON h.id = c.horas_id
					INNER JOIN servicios s
					ON s.id = c.servicios_id
					INNER JOIN servicio_general sg
					ON sg.id = s.servicio_general_id
					ORDER BY c.id DESC");
			}
			$sql -> execute();
			$resutl = $sql->fetchAll(PDO::FETCH_OBJ);
			// array_push($resutl, ['id'=>$tipo]);
			$sql = null;
			return $resutl;
			// exit(json_encode($resutl));
		}
		protected static function reedListHistorialAppointment_m(){
			
			// if($_SESSION['tipo'] == 4 || $_SESSION['tipo'] == 2){
			if($_SESSION['tipo'] == 4 ){
				$sql = mainModelo::conexion()->prepare("SELECT DISTINCT p.id , p.nombre AS usuario,p.dni, p.apellidos, p.celular, p.correo, h.code, h.nombre AS nameC, h.id AS idHis , sg.nombre as servG, c.nombre as cat FROM historial h 
				INNER JOIN persona p
				ON p.id = h.persona_id
				INNER JOIN tratamientos t
				ON t.paciente_id = p.id
				INNER JOIN servicios c
				ON c.id = t.servicios_id
				INNER JOIN servicio_general sg
				ON sg.id = c.servicio_general_id
					WHERE p.id=:iss
					ORDER BY h.id DESC");
				$sql->bindParam(":iss",$_SESSION['id']);
			}else{
				// $sql = mainModelo::conexion()->prepare("SELECT p.nombre AS usuario,p.dni, p.apellidos, p.celular, 
				// 	p.correo, h.code, h.nombre AS nameC, h.id AS idHis FROM historial h 
				// 	INNER JOIN persona p
				// 	ON p.id = h.persona_id
				// 	ORDER BY h.id DESC");
				$sql = mainModelo::conexion()->prepare("SELECT DISTINCT p.id , p.nombre AS usuario,p.dni, p.apellidos, p.celular, 
					p.correo, h.code, h.nombre AS nameC, h.id AS idHis, sg.nombre as servG, c.nombre as cat FROM historial h 
					INNER JOIN persona p
					ON p.id = h.persona_id
					INNER JOIN tratamientos t
					ON t.paciente_id = p.id
					INNER JOIN servicios c
					ON c.id = t.servicios_id
					INNER JOIN servicio_general sg
					ON sg.id = c.servicio_general_id
					ORDER BY h.id DESC");
			}
			$sql -> execute();
			$resutl = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $resutl;
		}
		// jjhjhj 
		// jjkjkj 
		// jkj 
		// kjk 
		// kjkj 
		// kj  kjk
		// kjkkj jhjhjh hjhjhjhj hjhj 
		 

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
			$sql = mainModelo::conexion()->prepare('SELECT tipo_pago_id, estado, total FROM tratamiento_pagos WHERE tratamientos_id = '.$idAppoint.'');
			$sql -> execute();
            if($sql -> rowCount() == 1){
				$resutl = $sql->fetch(PDO::FETCH_OBJ);
				$sql = null;
                return [true,$resutl];
			}else{
				$sql = null;
                return [false,0];
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
			$sql = mainModelo::conexion()->prepare('UPDATE `tratamiento_pagos` SET estado = 1
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
			$sql = mainModelo::conexion()->prepare('INSERT INTO `tratamiento_pagos`(`tipo_pago_id`, `detalles`, `medio_pago`, `fecha`, `total`, `estado`, `tratamientos_id`) 
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
			$sql = mainModelo::conexion()->prepare('SELECT * FROM tratamiento_pagos WHERE tratamientos_id = '.$idAppoint.'');
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
			$sql = $pdo->prepare("INSERT INTO tratamientos (`fecha`, `tiempo`, `mensaje`, `estado`, `atentido`, 
				`paciente_id`, `horas_id`, `servicios_id`,`tipo_cita_id`) 
				VALUES (:fecha, :tiempo, :mensaje, :estado, :atentido, :paciente, :horas, :servicio, :tipo_cita)");
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":tiempo",$datos['tiempo']);
			$sql->bindParam(":mensaje",$datos['mensaje']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":atentido",$datos['atentido']);
			$sql->bindParam(":paciente",$datos['paciente']);
			$sql->bindParam(":horas",$datos['horas']);
			$sql->bindParam(":servicio",$datos['servicio']);
			$sql->bindParam(":tipo_cita",$datos['tipo_cita_id']);
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