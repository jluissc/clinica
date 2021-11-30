<?php 
	require_once 'mainModelo.php';
	class configModelo extends mainModelo
	{	
		protected static function listarHoraAtencion_m(){
			session_start(['name' => 'bot']);
			$sql = mainModelo::conexion()->prepare("SELECT * FROM horas");
			$sql -> execute();
			$horasAtencion = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			$datos = [
				'tipoUser' => $_SESSION['tipo'],
				'idUser' => $_SESSION['tipo'] == 4 || $_SESSION['tipo'] == 2 ? $_SESSION['id'] : 0,
				'listConfig' => configModelo::listConfig_m(),
				'hisTrat' => $_SESSION['tipo'] == 4 || $_SESSION['tipo'] == 2 ? configModelo::reedListHistorialAppointment_m() : 0,
				'listaServGen' => configModelo::listaServGen_m(),
				'listServics' => configModelo::listServics_m(),
				'listCategs' => configModelo::listCategs_m(),
				'diasAtencion' => configModelo::listarDiasAtencion_m(),
				'tipoAtencion' => configModelo::listarTipoAtencion_m(),
				// 'horaAtencion' => $horasAtencion,
				'users' => configModelo::listarUsers_m(),
				'permisos' => configModelo::listarPermisos_m(),
				// 'servicios' => configModelo::listarServicios_m(),
			];
			exit(json_encode($datos));
		}
		protected static function reedListHistorialAppointment_m(){
			
			if($_SESSION['tipo'] == 4 || $_SESSION['tipo'] == 2){
				$sql = mainModelo::conexion()->prepare("SELECT p.nombre AS usuario,p.dni, p.apellidos, p.celular, p.correo, h.code, h.nombre AS nameC, h.id AS idHis  FROM historial h
					INNER JOIN persona p
					ON p.id = h.persona_id
					WHERE p.id=:iss
					ORDER BY h.id DESC");
				$sql->bindParam(":iss",$_SESSION['id']);
			}else{
				$sql = mainModelo::conexion()->prepare("SELECT p.nombre AS usuario,p.dni, p.apellidos, p.celular, p.correo, h.code, h.nombre AS nameC, h.id AS idHis FROM historial h 
					INNER JOIN persona p
					ON p.id = h.persona_id
					ORDER BY h.id DESC");
			}
			$sql -> execute();
			$resutl = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $resutl;
		}
		protected static function listServics_m(){
			$sql = mainModelo::conexion()->prepare("SELECT sg.nombre as serv, s.nombre as cat, sg.estado as sg_est, s.estado as s_est, 
				sg.id as sg_id, s.id as s_id, s.descripcion, s.precio_normal, s.precio_venta, s.tiempo, s.consulta FROM servicio_general sg
				LEFT JOIN servicios s
				ON s.servicio_general_id = sg.id
			 WHERE sg.elimino = 0 AND s.elimino = 0");
			$sql -> execute();
			$servics = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $servics;
		}
		protected static function listaServGen_m(){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM `servicio_general` WHERE estado = 1 AND elimino = 0");
			$sql -> execute();
			$servics = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $servics;
		}
		protected static function listCategs_m(){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM servicios");
			$sql -> execute();
			$servics = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $servics;
		}
		protected static function listConfig_m(){
			$sql = mainModelo::conexion()->prepare("SELECT  s.nombre as servicio, s.id as s_id, 
				c.id as c_id, c.codigo, c.nombre as c_nombre, c.horaInicio, c.horaFin, 
				dt.id as dt_id, dt.dias_id, dt.estado, dt.tipo_atencion FROM 
				dias_hora_atencion dt
				INNER JOIN config c
				ON c.id = dt.config_id
				INNER JOIN servicio_general s
				ON c.servicio_general_id = s.id
			");
			$sql -> execute();
			$permisos = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $permisos;
		}
		protected static function listarDiasAtencion_m(){
			$sql = mainModelo::conexion()->prepare("SELECT id, nombre FROM dias");
			$sql -> execute();
			$tipoAtencion = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $tipoAtencion;
		}
		protected static function listarTipoAtencion_m(){
			$sql = mainModelo::conexion()->prepare("SELECT id, nombre FROM tipo_atencion");
			$sql -> execute();
			$tipoAtencion = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $tipoAtencion;
		}
		protected static function addEditServics_m($datos){
			$pdo = mainModelo::conexion();
			if($datos['id']){
				$sql = $pdo->prepare("UPDATE servicio_general SET nombre = :name , estado = :status WHERE id = :id");
				$sql->bindParam(":id",$datos['id']);
			}else{
				$sql = $pdo->prepare("INSERT INTO servicio_general (nombre, estado) VALUES(:name, :status)");
			}
				$sql->bindParam(":name",$datos['name']);
				$sql->bindParam(":status",$datos['status']);
			$sql -> execute();
			if($sql->rowCount()>0){
				// $s = $pdo->lastInsertId();
				exit(json_encode(configModelo::listServics_m()));
			}else{
				exit(json_encode(0));
			}
		}
		protected static function deleteServicio_m($datos){
			if($datos['tipo']== 1){
				$sql = mainModelo::conexion()->prepare("UPDATE `servicio_general` SET elimino = 1 WHERE id =:id");
			}else if($datos['tipo']== 2){
				$sql = mainModelo::conexion()->prepare("UPDATE `servicios`  SET elimino = 1 WHERE id =:id");
			}
			$sql->bindParam(":id", $datos['id']);
			$sql -> execute();
			if($sql->rowCount()>0){
				exit(json_encode(configModelo::listServics_m()));
			}else{
				exit(json_encode(0));
			}
		}
		
		
		protected static function listarServicios_m(){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM servicios");
			$sql -> execute();
			$tipoAtencion = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $tipoAtencion;
		}
		protected static function listarUsers_m(){
			$sql = mainModelo::conexion()->prepare("SELECT p.id, p.nombre,p.correo, p.tipo_user_id, pu.* FROM persona p
				INNER JOIN permisos_user pu
				ON p.id = pu.persona_id
				WHERE p.tipo_user_id = 2 OR p.tipo_user_id = 3");
			$sql -> execute();
			$tipoAtencion = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $tipoAtencion;
		}
		

		protected static function listarPermisos_m(){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM permisos");
			$sql -> execute();
			$permisos = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $permisos;
		}
		protected static function saveConfig_m($datos){
			$pdo =mainModelo::conexion();
			$sql = $pdo->prepare("INSERT INTO `config` (`codigo`, nombre,horaInicio,horaFin, servicio_general_id) 
				VALUES (:code, :nombre, :ini, :fin, :id_serv) ");
			$sql->bindParam(":code",$datos['code']);
			$sql->bindParam(":nombre",$datos['name']);
			$sql->bindParam(":ini",$datos['horaInicio']);
			$sql->bindParam(":fin",$datos['horaFin']);
			$sql->bindParam(":id_serv",$datos['id_serv']);
            $sql -> execute();			
			$sql = null;
			return $pdo->lastInsertId();
		}
		protected static function saveConfigDiaHora_m($datos){
			$sql = mainModelo::conexion()->prepare("INSERT INTO `dias_hora_atencion` (`dias_id`, `config_id`, `tipo_atencion`, `horainicio`, `horafin`) 
				VALUES (:dia,  :idConf,:tipo, :inicio, :fin) ");
			$sql->bindParam(":dia",$datos['dia']);
			$sql->bindParam(":idConf",$datos['idConfig']);
			$sql->bindParam(":tipo",$datos['tipo']);
			$sql->bindParam(":inicio",$datos['inicio']);
			$sql->bindParam(":fin",$datos['fin']);
            $sql -> execute();			
			
			if($sql -> rowCount() > 0){
				$sql = null;
				return 1;
			}else{
				$sql = null;
				return 0;
			}
		}
		protected static function saveUsuario_m($datos){
			$sql = mainModelo::conexion()->prepare('INSERT INTO persona (`nombre`, `apellidos`, `dni`,
				`celular`, `correo`,  `user`,`password`, `tipo_user_id`, `estado`) 
				VALUES(:nombre, :apellidos, :dni, :celular, :correo,
				 :user, :pass, :tipo, :estado)');				
			$sql->bindParam(":dni",$datos['dni_appoint']);	
			$sql->bindParam(":user",$datos['dni_appoint']);	
			$sql->bindParam(":pass",$datos['dni_appoint']);
			$sql->bindParam(":tipo",$datos['tipo']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":nombre",$datos['name_appoint']);
			$sql->bindParam(":apellidos",$datos['last_appoint']);
			$sql->bindParam(":celular",$datos['celphone_appoint']);
			$sql->bindParam(":correo",$datos['email_appoint']);

			if($sql -> execute()){
				// if($sql->rowCount()== 1){
				// 	$consult = mainModelo::ejecutar_consulta_simple('SELECT id FROM persona WHERE dni = '.$datos["dni_appoint"].'');
				// 	$IdInsert = $consult->fetch(PDO::FETCH_OBJ);
				// 	return $IdInsert;				
				// }else{
				// 	$sql = null;
				// 	return 0;
				// }	
				$sql = null;
				return 1;
			}else{
				$sql = null;
				return 0;
			}
		}
		protected static function saveServics_m($datos){
			// $tipo =;
			$pdo=mainModelo::conexion();
			if ($datos['tipo']) {
				$sql = $pdo->prepare('UPDATE `servicios` SET `nombre`=:nombre, `descripcion`=:descr, 
					`precio_normal`=:precnor, `precio_venta`=:precofer, `estado`=:estado, `tiempo`=:timme WHERE id=:id');	
				$sql->bindParam(":id",$datos['id_serv']);	
				$sql->bindParam(":nombre",$datos['nameserv']);	
				$sql->bindParam(":descr",$datos['descripserv']);	
				$sql->bindParam(":precnor",$datos['precNserv']);
				$sql->bindParam(":precofer",$datos['precOserv']);
				$sql->bindParam(":estado",$datos['estado']);
				$sql->bindParam(":timme",$datos['prectiemserv']);
				$sql -> execute();
				if ($sql->rowCount()>0) {				
					exit(json_encode(configModelo::listServics_m()));
				} else {
					exit(json_encode(configModelo::listServics_m()));
				}	
			} else {	
				$sql = $pdo->prepare('INSERT INTO `servicios`(`nombre`, `descripcion`, `precio_normal`, `precio_venta`, 
					`estado`, `tiempo`,`servicio_general_id`)
				VALUES(:nombre, :descr, :precnor, :precofer, :estado, :timme, :id_serv)');
				$sql->bindParam(":nombre",$datos['nameserv']);	
				$sql->bindParam(":descr",$datos['descripserv']);	
				$sql->bindParam(":precnor",$datos['precNserv']);
				$sql->bindParam(":precofer",$datos['precOserv']);
				$sql->bindParam(":estado",$datos['estado']);
				$sql->bindParam(":timme",$datos['prectiemserv']);
				$sql->bindParam(":id_serv",$datos['id_serv']);
				$sql -> execute();
				if ($sql->rowCount()>0) {
					return $pdo->lastInsertId();
				} else {
					return false;
				}					
			}
			
		}


		// ************************


		
		protected static function listNotifications_m(){
			$datoss = [ 
				configModelo::citasReservadas(), 
				configModelo::citasReservadasNexs(),
			];
			// $datos = configModelo::citasReservadas();
			return $datoss;
		}

		protected static function citasReservadasNexs($fecha=''){
			// $dia = $fecha != '' ? $fecha : date('Y-m-d');
			// $sql = mainModelo::conexion()->prepare("SELECT c.id as idCita, c.estado,  
			// 	c.horas_id as id, c.mensaje, p.nombre, p.dni, p.celular , h.hora, c.fecha, tc.nombre as namC  FROM `tratamientos` c
			// 	INNER JOIN `persona` p
			// 	ON p.id = c.paciente_id
			// 	INNER JOIN `horas` h
			// 	ON c.horas_id  = h.id
			// 	INNER JOIN tipo_cita tc
			// 	ON tc.id = c.tipo_cita_id
			// 	-- INNER JOIN `tipo_cita` tc
			// 	-- ON tc.id  = c.tipo_cita_id
			// 	WHERE c.fecha >:dia ORDER BY h.id ASC LIMIT 5" );
			// $sql->bindParam(":dia",$dia);
            // $sql -> execute();
			// $lista = $sql->fetchAll(PDO::FETCH_OBJ);
			// $sql = null;
			// return $lista;
		}

		
		protected static function estadoHoraAtenc_m($datos){
			$sql = mainModelo::conexion()->prepare("UPDATE horas_atencion SET estado =:estado  WHERE id =:id");
			$sql->bindParam(":estado",$datos['estadoH']);
			$sql->bindParam(":id",$datos['idH']);
            $sql -> execute();
			if($sql -> rowCount() > 0){
				configModelo::listarHoraAtencion_m();
			}else{
				exit(json_encode(0));
			}
		}
		protected static function updateFechaAtencion_m($datos){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM `horas_no_atencion` WHERE dia =:dia AND horas_id =:hora_id AND sede_id =:sede");
			$sql->bindParam(":dia",$datos['fechaSelec']);
			$sql->bindParam(":hora_id",$datos['hora_idSelec']);
			$sql->bindParam(":sede",$datos['sede']);
            $sql -> execute();
			if($sql -> rowCount() > 0){
				configModelo::deleteHourNotAtencion($datos);
				exit(json_encode(1));
			}else{
				configModelo::insertHourNotAtencion($datos);
				exit(json_encode(0));
			}
		}		
		protected static function deleteHourNotAtencion($datos){
			$sql = mainModelo::conexion()->prepare("DELETE FROM `horas_no_atencion` WHERE dia =:dia AND horas_id =:hora_id AND sede_id =:sede");
			$sql->bindParam(":dia",$datos['fechaSelec']);
			$sql->bindParam(":hora_id",$datos['hora_idSelec']);
			$sql->bindParam(":sede",$datos['sede']);
            $sql -> execute();			
			$sql = null;
		}		
		protected static function insertHourNotAtencion($datos){
			$sql = mainModelo::conexion()->prepare("INSERT INTO `horas_no_atencion` (`dia`, `horas_id`, `sede_id`) 
				VALUES (:dia, :hora , :sede) ");
			$sql->bindParam(":dia",$datos['fechaSelec']);
			$sql->bindParam(":hora",$datos['hora_idSelec']);
			$sql->bindParam(":sede",$datos['sede']);
            $sql -> execute();			
			$sql = null;
		}
		protected static function updatePermisoUser_m($datos){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM `permisos_user` 
				WHERE persona_id =:persona_id AND permisos_id =:permisos_id");
			$sql->bindParam(":persona_id",$datos['user_id']);
			$sql->bindParam(":permisos_id",$datos['tipo']);
            $sql -> execute();
			if($sql -> rowCount() > 0){
				configModelo::deletePermisoUser_m($datos);
				exit(json_encode(1));
			}else{
				configModelo::insertPermisoUser_m($datos);
				exit(json_encode(0));
			}
		}		
		protected static function deletePermisoUser_m($datos){
			$sql = mainModelo::conexion()->prepare("DELETE FROM `permisos_user` 
				WHERE persona_id =:persona_id AND permisos_id =:permisos_id");
			$sql->bindParam(":persona_id",$datos['user_id']);
			$sql->bindParam(":permisos_id",$datos['tipo']);
            $sql -> execute();			
			$sql = null;
		}	

		protected static function datosCateg_m($id){
			$sql = mainModelo::conexion()->prepare("SELECT id, estado, dias_id, tipo_cita_id FROM servicios_tipo_dias 
				WHERE servicios_id = :id");
			$sql->bindParam(":id",$id);
            $sql -> execute();
			$servics = $sql->fetchAll(PDO::FETCH_OBJ);			
			$sql = null;
			$datos = [
				'servics' => $servics,
				'horas' => configModelo::horasCateg($id),
			];
			exit(json_encode($datos));
		}		
		protected static function horasCateg($id){
			$sql = mainModelo::conexion()->prepare("SELECT id, hora, estado FROM horas 
				WHERE servicios_id = :id");
			$sql->bindParam(":id",$id);
            $sql -> execute();
			$servics = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;	
			return $servics;
		}		
		protected static function insertPermisoUser_m($datos){
			$sql = mainModelo::conexion()->prepare("INSERT INTO `permisos_user` (`persona_id`, `permisos_id`) 
				VALUES (:persona_id, :permisos_id) ");
			$sql->bindParam(":persona_id",$datos['user_id']);
			$sql->bindParam(":permisos_id",$datos['tipo']);
            $sql -> execute();			
			$sql = null;
		}		
		protected static function tipoUser_m($id){
			$sql = mainModelo::conexion()->prepare("UPDATE persona SET tipo_user_id = 2 WHERE id = :id");
			$sql->bindParam(":id",$id);
            $sql -> execute();			
			if( $sql->rowCount() > 0){
				return 1;
			}else{
				return 0;
			}
		}		
		protected static function insertServicTypes_m($datos){
			// $existe = mainModelo::conexion()->prepare("SELECT * FROM `servicios_tipo` WHERE `servicios_id` =:servId AND `tipo_cita_id` =:tipID");
			// $existe->bindParam(":servId",$datos['servicios']);
			// $existe->bindParam(":tipID",$datos['tipo_cita']);
			// $existe -> execute();
			// if( $existe->rowCount() > 0){
			// 	// return 'existe';
			// 	$sql = mainModelo::conexion()->prepare("UPDATE `servicios_tipo` SET estado = 1 WHERE `servicios_id` =:servicios AND `tipo_cita_id` =:tipo_cita");
			// }else{
				// return 'no-existe';
				$sql = mainModelo::conexion()->prepare("INSERT INTO `servicios_tipo_dias` (`servicios_id`, `tipo_cita_id`,`estado`, `dias_id`) 
				VALUES (:servicios, :tipo_cita, :estado, :dia) ");
			// }
			$sql->bindParam(":servicios",$datos['servicios']);
			$sql->bindParam(":tipo_cita",$datos['tipo_cita']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":dia",$datos['dia']);
            $sql -> execute();	
			// if( $existe->rowCount() > 0){
			// 	return 1;
			// }else{
			// 	return 0;
			// }
			$sql = null;
		}		
		protected static function insertHoraServc_m($datos, $tipo=false){
			if($tipo){
				$sql = mainModelo::conexion()->prepare("UPDATE `horas` SET estado=:estado WHERE id=:id ");
				$sql->bindParam(":id",$datos['id']);
				$sql->bindParam(":estado",$datos['estado']);
			}else{
				$sql = mainModelo::conexion()->prepare("INSERT INTO `horas` (`hora`, `estado`,`servicios_id`) 
					VALUES (:hora, :estado, :serviId) ");
			$sql->bindParam(":hora",$datos['hora']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":serviId",$datos['servicios_id']);
		}
            $sql -> execute();			
			$sql = null;
		}		
		protected static function updateCitaAtencion_m($datos){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM `cita_no_atencion` WHERE dia =:dia AND tipo_cita_id =:hora_id AND sede_id =:sede");
			$sql->bindParam(":dia",$datos['fechaSelec']);
			$sql->bindParam(":hora_id",$datos['hora_idSelec']);
			$sql->bindParam(":sede",$datos['sede']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				configModelo::deleteCitaNotAtencion($datos);
				exit(json_encode(1));
			}else{
				configModelo::insertCitaNotAtencion($datos);
				exit(json_encode(0));
			}
		}
		protected static function deleteCitaNotAtencion($datos){
			$sql = mainModelo::conexion()->prepare("DELETE FROM `cita_no_atencion` WHERE dia =:dia AND tipo_cita_id =:hora_id AND sede_id =:sede");
			$sql->bindParam(":dia",$datos['fechaSelec']);
			$sql->bindParam(":hora_id",$datos['hora_idSelec']);
			$sql->bindParam(":sede",$datos['sede']);
            $sql -> execute();			
			$sql = null;
		}		
		protected static function insertCitaNotAtencion($datos){
			$sql = mainModelo::conexion()->prepare("INSERT INTO `cita_no_atencion` (`dia`, `tipo_cita_id`, `sede_id`) 
				VALUES (:dia, :hora , :sede) ");
			$sql->bindParam(":dia",$datos['fechaSelec']);
			$sql->bindParam(":hora",$datos['hora_idSelec']);
			$sql->bindParam(":sede",$datos['sede']);
            $sql -> execute();			
			$sql = null;
		}
		protected static function horas_no_disponibles($fecha){
			$sql = mainModelo::conexion()->prepare("SELECT horas_id as id FROM `horas_no_atencion` WHERE dia =:dia");
			$sql->bindParam(":dia",$fecha);
            $sql -> execute();
			$listaHoras = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			$datos = [
				'horasNoDispo' => $listaHoras,
				'citasNDisp' => configModelo::citas_no_disponioles($fecha),
				'citasReser' => configModelo::citasReservadas($fecha),
			];
			exit(json_encode($datos));
		}
		protected static function citasReservadas($fecha=''){
			// $dia = $fecha != '' ? $fecha : date('Y-m-d');
			// $sql = mainModelo::conexion()->prepare("SELECT c.id as idCita, c.estado,  
			// 	c.horas_id as id, c.mensaje, p.nombre, p.dni, p.celular , h.hora, c.fecha, tc.nombre as namC  FROM `tratamientos` c
			// 	INNER JOIN `persona` p
			// 	ON p.id = c.paciente_id
			// 	INNER JOIN `horas` h
			// 	ON c.horas_id  = h.id
			// 	INNER JOIN tipo_cita tc
			// 	ON tc.id = c.tipo_cita_id
			// 	WHERE c.fecha =:dia ORDER BY h.id ASC" );
			// $sql->bindParam(":dia",$dia);
            // $sql -> execute();
			// $lista = $sql->fetchAll(PDO::FETCH_OBJ);
			// $sql = null;
			// return $lista;
		}
		protected static function citas_no_disponioles($fecha){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM `cita_no_atencion` WHERE dia =:dia");
			$sql->bindParam(":dia",$fecha);
            $sql -> execute();
			$lista = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $lista;
		}
		protected static function updateHoraCrud_m($datos){
			$sql = mainModelo::conexion()->prepare("UPDATE `horas` SET `estado` =:estado WHERE id =:id");
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":id",$datos['hora_id']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				configModelo::listarHoraAtencion_m();
			}else{
				exit(json_encode(0));
			}
		}
		protected static function updateCitaCrud_m($datos){
			$sql = mainModelo::conexion()->prepare("UPDATE `tipo_cita` SET `estado` =:estado WHERE id =:id");
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":id",$datos['cita_id']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				configModelo::listarHoraAtencion_m();
			}else{
				exit(json_encode(0));
			}
		}

		protected static function listsServicsId_m($id){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM `servicios` WHERE id =:id");
			$sql->bindParam(":id", $id);
			$sql -> execute();
			// if($sql -> rowCount() > 0){
			$datos = [
				'servicio' => $sql->fetch(PDO::FETCH_OBJ),
				'horas' => configModelo::horasServicList($id),
				'tipo' => configModelo::tipoServicList($id),
			];
			exit(json_encode($datos));
		}
		

		protected static function horasServicList($id){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM `horas` WHERE servicios_id =:id AND estado=1");
			$sql->bindParam(":id", $id);
			$sql -> execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);			
		}
		protected static function tipoServicList($id){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM `servicios_tipo` WHERE servicios_id =:id");
			$sql->bindParam(":id", $id);
			$sql -> execute();
			return $sql->fetchAll(PDO::FETCH_OBJ);			
		}
	}