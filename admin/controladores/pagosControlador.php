<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/pagosModelo.php';
	}else{
		require_once './modelos/pagosModelo.php';
	} 

	class pagosControlador extends pagosModelo	{

        public function verPagos(){
			
            pagosModelo::verPagos_m($_POST['Idpagos']);
        }
        public function payUser(){
			$datos = [
				'idPay' => $_POST['idPay'],
				'montoPay' => $_POST['montoPay'],
			];
            pagosModelo::payUser_m($datos);
        }
        public function detallePago(){
            pagosModelo::detallePago_m($_POST['idDetalle']);
        }
        public function updateDatos(){
			$pagos = json_decode($_POST['updateDatos']);
			$datos = [
				'user' => $pagos->id,
				'nombre' => $pagos->concept,
			];
			$id = pagosModelo::updateDatos_m($datos);
            if($id){
				$detalles = [
					'monto' => $pagos->monto,
					'pagos' => $id,
					'user' => $pagos->id,
				];
				pagosModelo::updateDatos2_m($detalles);
			}
			else exit(json_encode($id));
        }

        public function listarPagos(){
            $users = pagosModelo::listarPagos_m();
            $datos =[];
			foreach ($users as $user) {
                $btn = ' <button class="btn btn-outline-info"  onclick="verPagos('.$user->id.')">
                            Pagos</button>';				
				array_push($datos,[
					'nombre' => $user->nombre.' '.$user->apellidos,
					'dni' => $user->dni,
					'acciones' => $btn,					
				]);
			}
			exit(json_encode($datos));//envio el array final el formato json a AJAX
        }
	} 
?>
