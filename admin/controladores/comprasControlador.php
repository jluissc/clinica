<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/comprasModelo.php';
	}else{
		require_once './modelos/comprasModelo.php';
	} 

	class comprasControlador extends comprasModelo	{

        public function updateCompras(){
            comprasModelo::updateCompras_m($_POST['updateDatos']);
        }

        public function listarCompras(){
            $gastos = comprasModelo::listarCompras_m();
            $datos =[];
			foreach ($gastos as $gasto) {
                $btn = 'Nothing';				
                // $btn = '<button class="btn btn-outline-danger"  onclick="eliminarCompras('.$gasto->id.')">
                //             Eliminar</button>
				// 		<button class="btn btn-outline-info"  onclick="updateCompras('.$gasto->id.')">
				// 			Editar</button>';				
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
