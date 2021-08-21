<?php 
	
	require_once 'mainModel.php'; 
	
	class logueoModel extends mainModel
	{
		
		protected static function iniciar_sesion_M($datos,$id=''){
			if($id != ''){
				$sql = mainModel::conexion() -> prepare("SELECT * FROM cliente WHERE cli_user = :user AND id_cli = :pass ");
			}else{
				$sql = mainModel::conexion() -> prepare("SELECT * FROM cliente WHERE cli_user = :user AND cli_pass = :pass AND cli_estado = 1 ");
			}
			$sql->bindParam(":user",$datos['user']);
			$sql->bindParam(":pass",$datos['pass']);
			$sql -> execute();
			return $sql;
		}

		protected static function traer_producto_id_M($id){
			$sql = mainModel::conexion()->prepare("SELECT * FROM `producto` AS p
				INNER JOIN categoria AS c
				ON p.prod_id_cat = c.id_cat
				INNER JOIN detped AS dpr
				ON p.id_prod = dpr.detped_id_prod
				INNER JOIN fotos_prod AS fp
				ON p.id_prod = fp.fotp_id_prod
				
				WHERE p.prod_estado = 1 AND p.id_prod = $id ");
			$sql -> execute();
			$datos = $sql -> fetch(PDO::FETCH_OBJ);
			$datos = $sql -> rowCount();
			$sql = null;
			return $datos;			
		}

		protected static function traer_coment_prod_M($id){
			$sql = mainModel::conexion()->prepare("SELECT * FROM `coment_prod` AS c INNER JOIN usuario AS u ON c.comp_id_usu = u.id_usu  WHERE comp_id_prod = $id ");
			$sql -> execute();
			$datos = $sql -> fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $datos;			
		}

		protected static function agregar_puntuacion_M($datos){
			$sql = mainModel::conexion()->prepare("INSERT INTO `puntprod`(`puntpr_estado`, `puntpr_id_usu`, `puntpr_id_prod`) VALUES (:punto, :clien , :prod) ");
			$sql ->bindParam(":punto", $datos['punto']);
			$sql ->bindParam(":clien", $datos['clien']);
			$sql ->bindParam(":prod", $datos['prod']);

			$sql -> execute();
			// return $sql;			
			$sql = null;
		}

		protected static function datosUser_M($id){
			$sql = mainModel::conexion() -> prepare("SELECT cli_nombre,cli_apellido,cli_celular,cli_direccion FROM cliente WHERE id_cli = :user");
			
			$sql->bindParam(":user",$id);
			$sql -> execute();
			$datos = $sql -> fetch(PDO::FETCH_OBJ);
			$sql = null;
			exit(json_encode($datos));
		}

		protected static function editCuenta_M($datos){
			$sql = mainModel::conexion() -> prepare("UPDATE cliente SET cli_nombre=:name, cli_apellido=:last,cli_celular =:celphone,cli_direccion =:address WHERE id_cli = :iduser");
			
			$sql->bindParam(":name",$datos['name']);
			$sql->bindParam(":last",$datos['last']);
			$sql->bindParam(":celphone",$datos['celphone']);
			$sql->bindParam(":address",$datos['address']);
			$sql->bindParam(":iduser",$datos['iduser']);
			$sql -> execute();
			if($sql -> rowCount() == 1){
				// exit(json_encode('b'));
				return 'b';
			}else{
				// exit(json_encode('m'));
				return 'm';
			}
			$sql = null;
		}


	}   