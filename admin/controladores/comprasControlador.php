<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/comprasModelo.php';
	}else{
		require_once './modelos/comprasModelo.php';
	} 

	class comprasControlador extends comprasModelo	{

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

        public function listarCompras(){
            $gastos = comprasModelo::listarCompras_m();
            $datos =[];
			foreach ($gastos as $gasto) {
                $btn = '<button class="btn btn-outline-danger"  onclick="eliminarCompras('.$gasto->id.')">
                            Eliminar</button>
						<button class="btn btn-outline-info"  onclick="updateCompras('.$gasto->id.')">
							Editar</button>';				
				array_push($datos,[
					'nombre' => $gasto->nombre,
					'cant' => $gasto->cantidad,
					'price' => $gasto->precio,					
					'date' => $gasto->fecha,					
					'subt' => $gasto->precio,				
					'acciones' => $btn,					
				]);
			}
			exit(json_encode($datos));//envio el array final el formato json a AJAX
        }
	} 
?>
