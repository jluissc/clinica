<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class comprasModelo extends mainModelo
	{		
        
        protected static function listarCompras_m(){
            $sql = mainModelo::conexion()->prepare("SELECT g.id, g.precio, g.cantidad, g.fecha, m.nombre FROM materiales m
                INNER JOIN gastos g
                ON m.id = g.materiales_id
            ");
            $sql -> execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);
        }
        
        protected static function verPagos_m($id){
            $sql = mainModelo::conexion()->prepare("SELECT * FROM pagos WHERE persona_id =:id");
            $sql->bindParam(':id',$id);
            $sql -> execute();
            exit(json_encode($sql->fetchAll(PDO::FETCH_OBJ)));
        }
        protected static function payUser_m($datos){
            session_start(['name' => 'bot']);
            $sql = mainModelo::conexion()->prepare("INSERT  INTO pagos_detalles(monto, pagos_id, persona_id) 
                VALUES(:monto, :idPay, :idUser)");
            $sql->bindParam(':monto',$datos['montoPay']);
            $sql->bindParam(':idPay',$datos['idPay']);
            $sql->bindParam(':idUser',$_SESSION['id']);
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