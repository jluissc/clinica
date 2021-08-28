<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class citaModelo extends mainModelo
	{
		
		protected static function verificarDni_m($dni){
			$sql = mainModelo::conexion()->prepare("SELECT id FROM user WHERE dni = $dni");
			$sql -> execute();
            if($sql -> rowCount() > 0){
                $resutl = $sql->fetch(PDO::FETCH_OBJ);
				exit(json_encode($resutl));
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}

		protected static function show_servicio_m($idServ){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM producto WHERE id = $idServ");
			$sql -> execute();
			$listServs = $sql->fetch(PDO::FETCH_OBJ);
            if($sql -> rowCount() > 0){
				exit(json_encode($listServs));
			}else{
				exit(json_encode(1));
			}
			
		}

		protected static function delete_servicio_m($idServ){
			$sql = mainModelo::conexion()->prepare("DELETE FROM producto WHERE id=$idServ");
			$sql -> execute();
			if($sql -> rowCount() > 0){
				// servicioModelo::select_servicio_admin_m();
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}

		protected static function insert_servicio_m($datos){
			$sql = mainModelo::conexion()->prepare("INSERT INTO producto (nombre, descripcion, tipo_id) 
				VALUES (:nombre, :descripcion, 1)");
			$sql->bindParam(":nombre",$datos['nombre_r']);
			$sql->bindParam(":descripcion",$datos['descrip_r']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				// servicioModelo::select_servicio_admin_m();
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}

		protected static function update_servicio_m($datos){
			$sql = mainModelo::conexion()->prepare("UPDATE  producto SET nombre =:nombre, descripcion=:descripcion
				WHERE id = :id");
			$sql->bindParam(":nombre",$datos['nombre_e']);
			$sql->bindParam(":descripcion",$datos['descrip_e']);
			$sql->bindParam(":id",$datos['id']);
			$sql -> execute();
			if($sql -> rowCount() > 0){
				// servicioModelo::select_servicio_admin_m();
			}else{
				exit(json_encode(0));
			}
			$sql = null;
		}
	}