<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class homeModelo extends mainModelo
	{
		
		protected static function readAppointmentToday_m(){
            $fechaActual = date('Y-m-d');
			$sql = mainModelo::conexion()->prepare("SELECT c.id, c.tipo_cita_id, p.nombre, p.apellidos, p.celular, p.dni, h.hora, s.nombre AS servic FROM tratamientos c 
				INNER JOIN persona p
				ON p.id = c.paciente_id
				INNER JOIN horas h
				ON h.id = c.horas_id
				INNER JOIN servicios s
				ON s.id = c.servicios_id
				INNER JOIN tipo_atencion tc
				ON tc.id = c.tipo_cita_id
				
				WHERE c.fecha =:fecha ORDER BY h.id ASC");
            // $sql->bindParameters(':fecha',$fechaActual);
            $sql->bindParam(":fecha",$fechaActual);
			$sql -> execute();
			$appointments = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
            return $appointments;			
		}

		protected static function estadoDetalleTratam_m($tipo=0,$idAppoint){
			$sql = mainModelo::conexion()->prepare("SELECT id FROM tratamiento_detalle				
				WHERE tratamientos_id = :idcita");
            // $sql->bindParameters(':fecha',$fechaActual);
            $sql->bindParam(":idcita",$idAppoint);
			$sql -> execute();
			if($sql->rowCount() > 0){
				return true;
			}else{
				return false;
			}
				
		}

		protected static function readAppointmentNexts_m(){
			$idPaciente = $_SESSION['id'];
            $fechaActual = date('Y-m-d');
			$sql = mainModelo::conexion()->prepare("SELECT c.fecha, c.tipo_cita_id, h.hora FROM tratamientos c 
				INNER JOIN persona p
				ON p.id = c.paciente_id
                INNER JOIN horas h
                ON h.id = c.horas_id
				WHERE c.fecha >:fecha AND c.paciente_id =:id");
            // $sql->bindParameters(':fecha',$fechaActual);
            $sql->bindParam(":fecha",$fechaActual);
            $sql->bindParam(":id",$idPaciente);
			$sql -> execute();
			$appointments = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
            return $appointments;			
		}
        
		protected static function showDetailAppoint_m($idAppoint){
			$sql = mainModelo::conexion()->prepare("SELECT c.id, p.nombre, p.apellidos, p.celular, 
				c.mensaje, c.tipo_cita_id, h.hora FROM citas c 
				INNER JOIN persona p
				ON p.id = c.paciente_id
				INNER JOIN horas h
				ON h.id = c.horas_id
				WHERE c.id =:idAppoint");
			$sql->bindParam(":idAppoint",$idAppoint);
			$sql -> execute();
			$appointment = $sql->fetch(PDO::FETCH_OBJ);
			$sql = null;
			exit(json_encode($appointment));
		}

		protected static function saveDetalleTratam_m($datos){
			$sql = mainModelo::conexion()->prepare("INSERT INTO tratamiento_detalle (`descripcion`, `recetas`, `otros`, `tratamientos_id`) VALUES 
				(:descr, :rece, :otr, :cita_id)");
			$sql->bindParam(":descr",$datos->descripDet);
			$sql->bindParam(":rece",$datos->recetDet);
			$sql->bindParam(":otr",$datos->otroDet);
			$sql->bindParam(":cita_id",$datos->idAppoint);
			$sql -> execute();
			if($sql->rowCount()>0){
				$sql = null;
				$sql2 = mainModelo::conexion()->prepare("UPDATE tratamientos SET atentido = 1 WHERE id = $datos->idAppoint");
				$sql2 -> execute();
				if($sql2->rowCount() >0 ) exit(json_encode(1));
				else exit(json_encode(0));
			}else{
				$sql = null;
				exit(json_encode(0));
			}
		}

		protected static function dateQuantity_m(){
			// $patients = homeModelo::quantityPatients();
			$dates = [
				'patients' =>homeModelo::quantityPatients()->quant,
				'appoints' =>homeModelo::quantityAppoints()->quant,
				'pay' =>homeModelo::quantityPayToday()->quant,
				'payOut' =>homeModelo::quantityPayOutToday()->quant,
			];			
			return $dates;
		}

		protected static function quantityPatients(){
			$sql = mainModelo::conexion()->prepare("SELECT COUNT(id) AS quant FROM `persona` WHERE tipo_user_id = 4");
			$sql -> execute();
			$date = $sql->fetch(PDO::FETCH_OBJ);
			$sql = null;
			return $date;
		}

		protected static function quantityAppoints(){
			$sql = mainModelo::conexion()->prepare("SELECT COUNT(id) AS quant FROM `tratamientos`");
			$sql -> execute();
			$date = $sql->fetch(PDO::FETCH_OBJ);
			$sql = null;
			return $date;
		}
		protected static function quantityPayToday(){
			$sql = mainModelo::conexion()->prepare("SELECT SUM(total) as quant FROM `tratamiento_pagos` WHERE estado = 1");
			$sql -> execute();
			$date = $sql->fetch(PDO::FETCH_OBJ);
			$sql = null;
			return $date;
		}
		protected static function quantityPayOutToday(){
			$sql = mainModelo::conexion()->prepare("SELECT SUM(monto) as quant FROM `pagos_detalles`");
			$sql -> execute();
			$date = $sql->fetch(PDO::FETCH_OBJ);
			$sql = null;
			return $date;
		}
	}