 <?php 
	
	require_once 'mainModelo.php';
	class categoryModelo extends mainModelo {

		protected static function agregar_category_M($datos) {
			$sql=mainModelo::conexion()->prepare("INSERT INTO categoria(cat_nombre, cat_estado, cat_elimino, cat_id_usu) VALUES(:nombre, :estado, :elimino, :id_usu)");
			$sql->bindParam(":nombre",$datos['nombre']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":elimino",$datos['elimino']);
			$sql->bindParam(":id_usu",$datos['id_usu']);
			$sql->execute();
			return $sql;
			$sql = null;
		}


		protected static function lista_category_M() {

			$id_u =  $_SESSION['id_bot'];
			$sql = mainModelo::conexion() -> 
			prepare("
				SELECT * FROM categoria WHERE cat_elimino = 0 AND cat_id_usu = $id_u");
			$sql -> execute();
			$listCat = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql = null;
			return $listCat;
		}
 
		protected static function unic_category_M($id) {
			$sql = mainModelo::conexion() -> prepare("SELECT * FROM categoria WHERE id_cat = :id");
			$sql -> bindParam(":id", $id);
			$sql -> execute();
			$listCat = $sql->fetch(PDO::FETCH_OBJ);
			$listCat -> tipo = 'category';
			$sql = null;
			exit(json_encode($listCat));
		}

		protected static function update_category_M($datos) {
			$sql=mainModelo::conexion()->prepare("UPDATE categoria SET cat_nombre = :name, cat_estado =:status WHERE id_cat =:id");
			$sql->bindParam(":name",$datos['name']);
			$sql->bindParam(":status",$datos['status']);
			$sql->bindParam(":id",$datos['id']);
			$sql->execute();
			return $sql;
			$sql = null;
		}

		protected static function delete_category_M($datos) {
			$sql=mainModelo::conexion()->prepare("UPDATE categoria SET cat_elimino = 1, cat_estado = 0 WHERE id_cat =:id");
			$sql->bindParam(":id",$datos['id']);
			$sql->execute();
			return $sql;
			$sql = null;
		}
	}