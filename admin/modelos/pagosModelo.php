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
        protected static function updateDatos_m($datos){
            // $datos = 
            $pdo = mainModelo::conexion();
            $sql = $pdo->prepare("INSERT INTO pagos(nombre, persona_id) VALUES(:nombre, :user )");
            $sql->bindParam(':nombre',$datos['nombre']);
            $sql->bindParam(':user',$datos['user']);
            $sql -> execute();
            if($sql->rowCount()>0) return $pdo->lastInsertId();
            else return 0;
        }
        protected static function updateDatos2_m($datos){
            // $datos = }
            session_start(['name' => 'bot']);
            $pdo = mainModelo::conexion();
            $sql = $pdo->prepare("INSERT INTO pagos_detalles(monto, pagos_id, persona_id) VALUES(:monto, :pay, :user )");
            $sql->bindParam(':monto',$datos['monto']);
            $sql->bindParam(':pay',$datos['pagos']);
            $sql->bindParam(':user',$_SESSION['id']);
            $sql -> execute();
            if($sql->rowCount()>0) exit(json_encode(1));
            else exit(json_encode(0));
        }
	}