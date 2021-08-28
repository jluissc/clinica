<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/servicioModelo.php';
	}else{
		require_once './modelos/servicioModelo.php';
	} 

	class servicioControlador extends servicioModelo	{
		
		public function select_servicio_admin() {
			servicioModelo::select_servicio_admin_m();
		}

		public function insert_servicio() {
			$datos = [
				'nombre_r' => $_POST['nombre_r'],
				'descrip_r' => $_POST['descrip_r'],
			];
			servicioModelo::insert_servicio_m($datos);
		}

	} 