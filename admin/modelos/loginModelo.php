<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class loginModelo extends mainModelo
	{
		
		protected static function iniciar_sesion_M($datos){
			$sql = mainModelo::conexion() -> prepare("SELECT id, estado, nombre, 
				apellidos, dni, celular, correo, direccion, tipo_user_id FROM `persona` 
				WHERE user = :user AND password = :pass ");
			$sql->bindParam(":user",$datos['user']);
			$sql->bindParam(":pass",$datos['pass']);
			$sql -> execute();
			return $sql;
		}

		protected static function datosUser_m($idUser){
			$sql = mainModelo::conexion() -> prepare("SELECT p.nombre AS perm, p.id AS idPerm FROM `permisos_user` pu
				INNER JOIN permisos p
				ON p.id = pu.permisos_id
				WHERE persona_id =:id");
			$sql->bindParam(":id",$idUser);
			$sql -> execute();
			return $sql;
		}

		protected static function activarSession($id){
			$sql = mainModelo::conexion() -> prepare("UPDATE `persona` SET `logueo`= 1 WHERE id =:id");
			$sql->bindParam(":id",$id);
			$sql -> execute();
			return $sql;
		}
	}