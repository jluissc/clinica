<?php 
	if ($peticionAjax) {
		require_once '../model/pedidosModel.php';
	}else{
		require_once './model/pedidosModel.php';
	}
	// encontrar el error de la url *************
	class pedidosController extends pedidosModel
	{
		public function guardarPedido(){
			$user = mainModel::decryption($_POST['user']);
            $datos = [
				'total' => $_POST['total'],
				'codigo' => $_POST['codigo'],
				'user' => $user,
				'estado' => 1,
			];
			pedidosModel::guardarPedido_M($datos);
        } 

		public function listaPedidos_C(){
			$user = mainModel::decryption($_POST['user']);
			// $ins = logueoModel::iniciar_sesion_M($datos,'id');
			$cons = "SELECT * FROM cliente WHERE id_cli = $user";
			$ins = mainModel::ejecutar_consulta_simple($cons);

			if($ins -> rowCount() == 1){
				$users = $ins -> fetch(PDO::FETCH_OBJ);	
				if($users->cli_estado == 1 ){
					pedidosModel::listaPedidos_M($user);
				}else{
					exit(json_encode('no'));
				}
			}else{
				exit(json_encode('no'));
			}
            
        } 
		public function listaDetPedido_C(){	
			// exit(json_encode('asdasd'));
			pedidosModel::listaDetPedido_M($_POST['id_ped']);				
        } 
		public function listaProdMas_C(){	
			// exit(json_encode('asdasd'));
			pedidosModel::listaProdMas_M();				
        } 

		public function guardarDetalles(){
			$idPedido = pedidosModel::idPedido_M($_POST['codigo_ped']);
			$IdTienda = pedidosModel::idTienda_M($_POST['id_prod']);
			// $idTienda = pedidosModel::idTienda_M($_POST['id_prod']);
			if ($idPedido != 'm') {
				$datos = [
					'cant' => $_POST['cantidad'],
					'id_prod' => $_POST['id_prod'],
					'id_ped' => $idPedido->id_ped,
					'color' => $_POST['color'],
					'talla' => $_POST['talla'],
					'precio' => $_POST['precio'],
					'tienda' => $IdTienda->prod_id_usu,
					// 'id_tiend' => $idTienda->prod_id_usu,
				];
				pedidosModel::guardarDetalles_M($datos);
			} else {
				exit(json_encode('mal'));
			}
			
			// echo 'mmm';
		}
	}  