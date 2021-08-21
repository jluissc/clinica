<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class loginModelo extends mainModelo
	{
		
		protected static function iniciar_sesion_M($datos){
			$sql = mainModelo::conexion() -> prepare("SELECT * FROM usuario WHERE usu_gmail = :user AND usu_password = :pass ");
			$sql->bindParam(":user",$datos['user']);
			$sql->bindParam(":pass",$datos['pass']);
			$sql -> execute();
			return $sql;
		}

		public function saveStore($tienda){
			// $sql = mainModelo::conexion() -> prepare("SELECT * FROM usuario WHERE usu_gmail = :user AND usu_password = :pass ");
			// $sql->bindParam(":user",$tienda['name_reg']);
			// $sql->bindParam(":pass",$tienda['name_reg']);
			// $sql -> execute();
			return false;
		}
	}