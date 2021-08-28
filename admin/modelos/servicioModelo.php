<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class servicioModelo extends mainModelo
	{
		
		protected static function select_servicio_admin_m(){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM producto");
			$sql -> execute();
			$listServs = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			exit(json_encode($listServs));
		}

		protected static function insert_servicio_m($datos){
			$sql = mainModelo::conexion()->prepare("INSERT INTO producto (nombre, descripcion, tipo_id) 
				VALUES (:nombre, :descripcion, 1)");
			$sql->bindParam(":nombre",$datos['nombre_r']);
			$sql->bindParam(":descripcion",$datos['descrip_r']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				servicioModelo::select_servicio_admin_m();
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}
	}