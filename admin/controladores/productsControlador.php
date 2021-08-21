<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/productsModelo.php';
	}else{
		require_once './modelos/productsModelo.php';
	} 

	class productsControlador extends productsModelo	{
		
		public function agregar_products_C(){
			$name = mainModelo::limpiar_cadena($_POST['producto_name_reg']);
			// $status = mainModelo::limpiar_cadena($_POST['producto_status_reg']);
			$status = 0;
			$price = mainModelo::limpiar_cadena($_POST['producto_price_reg']);
			$stock = mainModelo::limpiar_cadena($_POST['producto_stock_reg']);
			$cat = mainModelo::limpiar_cadena($_POST['producto_cat_reg']);
			$especif = mainModelo::limpiar_cadena($_POST['especif']);

			$marca = mainModelo::limpiar_cadena($_POST['producto_marca_reg']);
			$modelo= mainModelo::limpiar_cadena($_POST['producto_modelo_reg']);
			$descuent = mainModelo::limpiar_cadena($_POST['producto_descuento_reg']);
			$fecha = mainModelo::limpiar_cadena($_POST['producto_fecha_reg']);
			$tags = mainModelo::limpiar_cadena($_POST['producto_tags_reg']);


			if($name == '' || $name == null || $price == '' || $price == null || $stock =='' || $stock == null){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Datos vacios",
					"Texto"=>"Rellenar los campos del producto",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			
			
			$datos_products = [
				"name" => $name,
				"status" => $status,
				"price" => $price,
				"stock" => $stock,
				"especif" => $especif,
				"cat" => $cat,
				"marca" => $marca,
				"modelo" => $modelo,
				"descuent" => $descuent,
				"fecha" => $fecha,
				"tags" => $tags,
				"elimino" => 0
			];
			// echo var_dump($datos_products);
			$id_prod = productsModelo::agregar_products_M($datos_products);

			// $datos_detalles = [
			// 	"tall" => $tal,
			// 	"col" => $col,
			// 	"pes" => $pes,
			// 	"alt" => $alt,
			// 	"anch" => $anch,
			// 	"larg" => $larg,
			// 	"id_prod" => $id_prod

			// ];
			
			// $agregarC = productsModelo::agregar_det_products_M($datos_detalles);

			if($id_prod){
				$espacio = productsModelo::guardarEspacio($id_prod);
				if ($espacio == 2) {
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Datos Guardados",
						"Texto"=>"El producto fue guardado",
						"Tipo"=>"success"
					];
				}elseif($espacio == 1){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Fallo",
						"Texto"=>"No se pudo guardar el id para foto",
						"Tipo"=>"error"
					];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Fallo",
						"Texto"=>"No se pudo guardar el id para detalle",
						"Tipo"=>"error"
					];
				}
				
				echo json_encode($alerta);
				exit();
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Fallo al guardar",
					"Texto"=>"No se pudo guardar el producto, intentalo de nuevo",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
		
		} 

		public function lista_products_C(){
			$datos = productsModelo::lista_products_M();
			$tr = '';
			foreach ($datos as $key => $prod) {
				$estado = $prod->prod_estado == 1 ? 'checked' : '';
				$title = $prod->prod_estado ==1 ? 'Activo' : 'Desactivo';
				$status =$prod->prod_estado ==1 ? 'text-primary': 'text-danger';
				$key+=1;
	                	// <i class="fa fa-circle '.$status.' font-12" data-toggle="tooltip" data-placement="top" title="'.$prod->scor_status.'  Estrellas    '.$prod->likp_likp.' Likes"></i>
				$tr .= '<tr>
	                <td>'.$key.'</td>
	                <td>'.$prod->prod_nombre.'</td>
	                <td>S/. '.$prod->prod_precio.'</td>
	                <td>'.$prod->prod_stock.' Unid</td>
	                <td>
	                	<a href="#" class="btn btn-warning"  onclick="traerDatos('.$prod->id_prod.',2)" data-toggle="modal" data-target="#editProductos"><i class="fas fa-info-circle"></i></a>
	                	<a href="#" class="btn btn-success"  onclick="traerDatos('.$prod->id_prod.',3)" data-toggle="modal" data-target="#editProductos_det"><i class="fas fa-edit"></i></a>
	                	<a href="#" class="btn btn-primary"  onclick="traerDatos('.$prod->id_prod.',4)" data-toggle="modal" data-target="#editProductos_fot"><i class="fas fa-images"></i></a>
	                	<a href="#" onclick="eliminar('.$prod->id_prod.',1)" class="btn btn-danger text-right "><i class="far fa-trash-alt"></i>    </a>
		            </td>
	               
	            </tr>';
 
			} 
			return $tr;
		} 

		public function unic_products_C() {

			$id = productsModelo::unic_products_M($_POST['prod_rapido'],"products");
		}

		public function unic_products_d_C() {

			$id = productsModelo::unic_products_M($_POST['prod_detalles'],"detalles");
		}

		public function unic_products_f_C() {

			$id = productsModelo::unic_products_M($_POST['prod_fotos'],"fotos");
		}

		public function lista_categorys_C() {
			productsModelo::lista_categorys_M();
		}

		public function update_products_C(){

			$name = mainModelo::limpiar_cadena($_POST['producto_name_edit']);
			$price = mainModelo::limpiar_cadena($_POST['producto_price_edit']);
			$stock = mainModelo::limpiar_cadena($_POST['producto_stock_edit']);
			$id_p = mainModelo::limpiar_cadena($_POST['id_prod']);

			$especif = mainModelo::limpiar_cadena($_POST['especif_edit']);
			$marca = mainModelo::limpiar_cadena($_POST['producto_marca_edit']);
			$modelo = mainModelo::limpiar_cadena($_POST['producto_modelo_edit']);
			$tags = mainModelo::limpiar_cadena($_POST['producto_tags_edit']);
			$desc = mainModelo::limpiar_cadena($_POST['producto_desc_edit']);
			$fecdesc = mainModelo::limpiar_cadena($_POST['producto_fecdesc_edit']);

			$status = isset($_POST['producto_status_edt']) ? 1 : 0;


			$productos = [
				"name" => $name,
				"status" => $status,
				"price" => $price,
				"stock" => $stock,
				"especif" => $especif,
				"id" => $id_p,
				"marca" => $marca,
				"modelo" => $modelo,
				"desc" => $desc,
				"fecdesc" => $fecdesc,
				"tags" => $tags,
			];

			$agregarC = productsModelo::update_products_M($productos);

			if($agregarC -> rowCount() == 1){
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Dato Editado",
						"Texto"=>"La categoria fue editado",
						"Tipo"=>"success"
					];
					echo json_encode($alerta);
					exit();
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un problemaa",
					"Texto"=>"Comuniquese con su proveedor",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
		} 

		public function update_detalles_prod_C(){


			$tal = mainModelo::limpiar_cadena($_POST['producto_tal_edit']);
			$col = mainModelo::limpiar_cadena($_POST['producto_col_edit']);
			$pes = mainModelo::limpiar_cadena($_POST['producto_pes_vol_edit']);
			$alt = mainModelo::limpiar_cadena($_POST['producto_alt_edit']);
			$anch = mainModelo::limpiar_cadena($_POST['producto_anch_edit']);
			$larg = mainModelo::limpiar_cadena($_POST['producto_larg_edit']);
			$id_pd = mainModelo::limpiar_cadena($_POST['id_prodd']);			

			$detalles = [
				"talla" => $tal,
				"color" => $col,
				"pes_vol" => $pes,
				"alt" => $alt,
				"anch" => $anch,
				"larg" => $larg,
				"id" => $id_pd	
			];

			$agregarC = productsModelo::update_detalles_prod_M($detalles);

			if($agregarC -> rowCount() == 1){

				
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Dato Editado",
						"Texto"=>"La categoria fue editado",
						"Tipo"=>"success"
					];
					echo json_encode($alerta);
					exit();
				
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un problemaa",
					"Texto"=>"Comuniquese con su proveedor",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
		} 

		public function delete_products_C(){
			$datos = [
				"id" => $_POST['id_del']
			];

			$agregarC = productsModelo::delete_products_M($datos);

			if($agregarC -> rowCount() == 1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Dato Eliminado",
					"Texto"=>"El producto fue eliminado",
					"Tipo"=>"success" 
				];
				echo json_encode($alerta);
				exit();
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un problema",
					"Texto"=>"Comuniquese con su proveedor",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
		}


		public function update_fotos_prod_C(){
			
			if(empty($_FILES['fot_port']['name']) && empty($_FILES['fot_u']['name']) && empty($_FILES['fot_d']['name']) && empty($_FILES['fot_t']['name'])){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Sin cambios",
					"Texto"=>"No eligiste alguna imagen para el producto",
					"Tipo"=>"error"  
				];
				echo json_encode($alerta);
				exit();
			}else{
				$id = mainModelo::limpiar_cadena($_POST['id_prod_fotos']);
				$idf = mainModelo::limpiar_cadena($_POST['id_fots']);

				$sql = "SELECT * FROM fotos_prod WHERE fotp_id_prod =".$id;
				$consulta = mainModelo::ejecutar_consulta_simple($sql);
				$f = $consulta -> fetch(PDO::FETCH_OBJ);				


				$imagen_port = empty($_FILES['fot_port']['name']) ? $f ->foto_url : "../vistas/assets/images/product/".basename($_FILES['fot_port']['name']);
				$imagen_port1 =empty($_FILES['fot_port']['name']) ? $f ->foto_url : "/vistas/assets/images/product/".basename($_FILES['fot_port']['name']);

				$imagen_uno = empty($_FILES['fot_u']['name']) ? $f ->foto_p : "../vistas/assets/images/product/".basename($_FILES['fot_u']['name']);
				$imagen_u = empty($_FILES['fot_u']['name']) ? $f ->foto_p : "/vistas/assets/images/product/".basename($_FILES['fot_u']['name']);

				$imagen_dos = empty($_FILES['fot_d']['name']) ? $f ->foto_s : "../vistas/assets/images/product/".basename($_FILES['fot_d']['name']);
				$imagen_d = empty($_FILES['fot_d']['name']) ? $f ->foto_s : "/vistas/assets/images/product/".basename($_FILES['fot_d']['name']);

				$imagen_tres = empty($_FILES['fot_t']['name']) ? $f ->foto_t : "../vistas/assets/images/product/".basename($_FILES['fot_t']['name']);
				$imagen_t = empty($_FILES['fot_t']['name']) ? $f ->foto_t : "/vistas/assets/images/product/".basename($_FILES['fot_t']['name']);

				if (!empty($imagen_port) ) {
					move_uploaded_file($_FILES['fot_port']['tmp_name'], $imagen_port);
				} 
				if (!empty($imagen_uno) ) {
					move_uploaded_file($_FILES['fot_u']['tmp_name'], $imagen_uno);
				}
				if  (!empty($imagen_dos) ) {
					move_uploaded_file($_FILES['fot_d']['tmp_name'], $imagen_dos);
				}
				if  (!empty($imagen_tres) ) {
					move_uploaded_file($_FILES['fot_t']['tmp_name'], $imagen_tres);
				}

				$datos_fotos = [
					"fot_port" => $imagen_port1,
					"fot_u" => $imagen_u,
					"fot_d" => $imagen_d,
					"fot_t" => $imagen_t,
					"id" => $idf
				];

				$agregar_fotos = productsModelo::update_fotos_prod_M($datos_fotos);

				if($agregar_fotos -> rowCount() == 1){
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Datos subido",
						"Texto"=>"Imagenes subidas con exito",
						"Tipo"=>"success" 
					];
					echo json_encode($alerta);
					exit();
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un problema",
						"Texto"=>"Comuniquese con su proveedor",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			
			}
			
		}

	} 