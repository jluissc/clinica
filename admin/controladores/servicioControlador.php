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

		public function show_servicio() {
			$idServ = $_POST['idServ_Edit'];
			servicioModelo::show_servicio_m($idServ);
		}

		public function insert_servicio() {
			$datos = [
				'nombre_r' => $_POST['nombre_r'],
				'descrip_r' => $_POST['descrip_r'],
			];
			servicioModelo::insert_servicio_m($datos);
		}

		public function update_servicio() {
			$datos = [
				'id' => $_POST['id'],
				'nombre_e' => $_POST['nombre_e'],
				'descrip_e' => $_POST['descrip_e'],
			];
			servicioModelo::update_servicio_m($datos);
		}

		public function delete_servicio() {
			$idServ = $_POST['id_d'];
			servicioModelo::delete_servicio_m($idServ);
		}

	} 