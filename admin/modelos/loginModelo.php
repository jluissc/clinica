<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class loginModelo extends mainModelo
	{
		
		protected static function iniciar_sesion_M($datos){
			$sql = mainModelo::conexion() -> prepare("SELECT * FROM `persona` WHERE user = :user AND password = :pass ");
			$sql->bindParam(":user",$datos['user']);
			$sql->bindParam(":pass",$datos['pass']);
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