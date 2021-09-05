<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class configModelo extends mainModelo
	{
		
		protected static function listarHoraAtencion_m(){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM horas");
			$sql -> execute();
			$horasAtencion = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			$datos = [
				'horaAtencion' => $horasAtencion,
				'tipoAtencion' => configModelo::listarTipoAtencion_m(),
			];
			exit(json_encode($datos));
		}
		protected static function listarTipoAtencion_m(){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM tipo_cita");
			$sql -> execute();
			$tipoAtencion = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $tipoAtencion;
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
			$sql = mainModelo::conexion()->prepare("SELECT * FROM `horas_no_atencion` WHERE dia =:dia");
			$sql->bindParam(":dia",$fecha);
            $sql -> execute();
			$listaHoras = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			$datos = [
				'horas' => $listaHoras,
				'citas' => configModelo::citas_no_disponioles($fecha),
				'fecha' => $fecha,
			];
			exit(json_encode($datos));
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
				// exit(json_encode(1));
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
				// exit(json_encode(1));
				configModelo::listarHoraAtencion_m();
			}else{
				exit(json_encode(0));
			}
		}
	}