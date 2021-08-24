<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class loginModelo extends mainModelo
	{
		
		protected static function iniciar_sesion_M($datos){
			$sql = mainModelo::conexion() -> prepare("SELECT * FROM user WHERE user = :user AND password = :pass ");
			$sql->bindParam(":user",$datos['user']);
			$sql->bindParam(":pass",$datos['pass']);
			$sql -> execute();
			return $sql;
		}
	}