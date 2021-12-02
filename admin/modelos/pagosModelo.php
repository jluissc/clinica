<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class pagosModelo extends mainModelo
	{		
        
        protected static function listarPagos_m(){
            $sql = mainModelo::conexion()->prepare("SELECT DISTINCT pe.id, pe.nombre, pe.apellidos, pe.dni FROM pagos p INNER JOIN persona pe ON pe.id = p.persona_id");
            $sql -> execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);
        }
        
        protected static function verPagos_m($id){
            $sql = mainModelo::conexion()->prepare("SELECT * FROM pagos WHERE persona_id =:id");
            $sql->bindParam(':id',$id);
            $sql -> execute();
            exit(json_encode($sql->fetchAll(PDO::FETCH_OBJ)));
        }
        protected static function detallePago_m($id){
            $sql = mainModelo::conexion()->prepare("SELECT * FROM pagos_detalles WHERE pagos_id =:id");
            $sql->bindParam(':id',$id);
            $sql -> execute();
            exit(json_encode($sql->fetchAll(PDO::FETCH_OBJ)));
        }
	}