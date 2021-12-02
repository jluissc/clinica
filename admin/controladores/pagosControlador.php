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
        public function detallePago(){
            pagosModelo::detallePago_m($_POST['idDetalle']);
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
