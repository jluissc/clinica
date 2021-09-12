<?php 
	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class clienteModelo extends mainModelo
	{
		protected static function reedListCustomers_m(){			
            $sql = mainModelo::conexion()->prepare("SELECT p.id, p.nombre, p.apellidos, p.celular, p.correo FROM persona p
                WHERE tipo_user_id= 4 AND estado = 1
                ORDER BY p.id DESC");
			$sql -> execute();
			$resutl = $sql->fetchAll(PDO::FETCH_OBJ);				
			$sql = null;
			return $resutl;
		}

		protected static function showCustomer_m($idappoint){			
            $sql = mainModelo::conexion()->prepare('SELECT p.id, p.dni, p.nombre, p.apellidos, p.celular, p.correo, p.direccion FROM persona p
                WHERE id= '.$idappoint.'');
			$sql -> execute();
			$resutl = $sql->fetch(PDO::FETCH_OBJ);				
			$sql = null;
			exit(json_encode($resutl));
		}

		protected static function deleteCustomer_m($idappoint){			
            $sql = mainModelo::conexion()->prepare('UPDATE persona SET estado = 0
                WHERE id= '.$idappoint.'');
			$sql -> execute();
			if($sql->rowCount()== 1){
				$sql = null;
				exit(json_encode(1));				
			}else{
				$sql = null;
				exit(json_encode(0));
			}				
		}

		protected static function insertAppoint_m($datos){

			if($datos['idAppoint']!=0){
				$sql = mainModelo::conexion()->prepare('UPDATE persona SET nombre =:nombre,
					apellidos=:apellidos, celular=:celular, correo=:correo, direccion=:direccion WHERE id=:id' );
				$sql->bindParam(":id",$datos['idAppoint']);
			}else{
				$sql = mainModelo::conexion()->prepare('INSERT INTO persona (`nombre`, `apellidos`, `dni`,
					`celular`, `correo`, `direccion`, `user`,`password`, `tipo_user_id`, `estado`) 
					VALUES(:nombre, :apellidos, :dni, :celular, :correo,
					:direccion, :user, :pass, :tipo, :estado)');				
				$sql->bindParam(":dni",$datos['dni_appoint']);	
				$sql->bindParam(":user",$datos['dni_appoint']);	
				$sql->bindParam(":pass",$datos['dni_appoint']);
				$sql->bindParam(":tipo",$datos['tipo']);
				$sql->bindParam(":estado",$datos['estado']);
			}	
			$sql->bindParam(":nombre",$datos['name_appoint']);
			$sql->bindParam(":apellidos",$datos['last_appoint']);
			$sql->bindParam(":celular",$datos['celphone_appoint']);
			$sql->bindParam(":correo",$datos['email_appoint']);
			$sql->bindParam(":direccion",$datos['addres_appoint']);
			
			$sql -> execute();	
            // $sql->bindParam(":id_usu",$datos['id_usu']);
			if($sql->rowCount()== 1){
				$sql = null;
				exit(json_encode(1));				
			}else{
				$sql = null;
				exit(json_encode(0));
			}				
		}
		
	}