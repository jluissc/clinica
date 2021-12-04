<?php 

	/**
	 * 
	 */
	require_once 'mainModelo.php';
	class materialModelo extends mainModelo
	{		
		protected static function updateMaterial_m($datos){
            $datos =  json_decode($datos);
            if($datos->newMaterial){
                $sql = mainModelo::conexion()->prepare("UPDATE materiales SET nombre =:name_mat , descripcion =:descr_mat
                    WHERE id =:id");
                $sql->bindParam(':id',$datos->newMaterial);
            }else{
                $sql = mainModelo::conexion()->prepare("INSERT INTO materiales (nombre, descripcion) VALUES (:name_mat, :descr_mat)");
            }
            $sql->bindParam(':name_mat',$datos->name_mat);
            $sql->bindParam(":descr_mat",$datos->descr_mat);
			$sql -> execute();
			// if($sql->rowCount()>0) exit(json_encode(materialModelo::listaMateriales()));
			if($sql->rowCount()>0) exit(json_encode(1));
            else exit(json_encode(0));
		}
        
        protected static function listaMateriales(){
            $sql = mainModelo::conexion()->prepare("SELECT * FROM materiales WHERE estado = 1");
            $sql -> execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);
        }
        protected static function listaMateriales2(){
            $sql = mainModelo::conexion()->prepare("SELECT * FROM materiales WHERE estado = 1");
            $sql -> execute();
            exit(json_encode($sql->fetchAll(PDO::FETCH_OBJ)));
            // return ;
        }
        protected static function deleteDefinity_m($id){
            $sql = mainModelo::conexion()->prepare("UPDATE materiales SET estado = 0 WHERE id =:id");
            $sql->bindParam(':id',$id);
            $sql -> execute();
            if($sql->rowCount()>0) exit(json_encode(1));
            else exit(json_encode($id));
        }
        protected static function searchMaterial_m($id){
            $sql = mainModelo::conexion()->prepare("SELECT * FROM materiales WHERE id =:id");
            $sql->bindParam(':id',$id);
            $sql -> execute();
            exit(json_encode($sql->fetch(PDO::FETCH_OBJ)));
        }
	}