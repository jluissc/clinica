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

		protected static function reedListAppointment_m($tipo){
			// session_start(['name' => 'bot']);
			$idPaciente = $tipo ? $idPaciente = $_SESSION['id'] : '';
			if($tipo){
				$sql = mainModelo::conexion()->prepare("SELECT p.nombre, p.apellidos, p.celular, p.correo, c.fecha, c.tipo_cita_id, h.hora FROM citas c 
					INNER JOIN persona p
					ON p.id = c.paciente_id
					INNER JOIN horas h
					ON h.id = c.horas_id WHERE p.id=:id
					ORDER BY c.id DESC");
				$sql->bindParam(":id",$idPaciente);
			}else{
				$sql = mainModelo::conexion()->prepare("SELECT p.nombre, p.apellidos, p.celular, p.correo, c.fecha, c.tipo_cita_id, h.hora FROM citas c 
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