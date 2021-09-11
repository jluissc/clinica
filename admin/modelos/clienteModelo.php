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
            $sql = mainModelo::conexion()->prepare('SELECT p.id, p.nombre, p.apellidos, p.celular, p.correo FROM persona p
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

		
	}