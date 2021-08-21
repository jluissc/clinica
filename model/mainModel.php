<?php 

if ($peticionAjax) {
	require_once '../config/server.php';
}else{
	require_once './config/server.php';
}


	// const SGBD = "mysql:host=".SERVER.";dbname=".DB;
	class mainModel
	{
		protected static function conexion() {
			$con = new PDO(SGBD, USER, PASS);
			$con -> exec("SET CHARACTER SET utf8");
			return $con;
		}

		protected static function ejecutar_consulta_simple($cons){
			$sql = self::conexion()->prepare($cons);
			$sql -> execute();
			return $sql;
		}
		
		public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

		// desencriptar cadenas 
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}
	}