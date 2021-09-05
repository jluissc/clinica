<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/citaModelo.php';
	}else{
		require_once './modelos/citaModelo.php';
	} 

	class citaControlador extends citaModelo	{

		public function listaServic() {
			citaModelo::listaServic_m();
		}
		
		public function verificarDni() {
            $dni = $_POST['dni'];
			citaModelo::verificarDni_m($dni);
		}
		

		public function verificarFecha() {
            $fecha = $_POST['fecha'];
			citaModelo::verificarFecha_m($fecha);
		}

		public function saveCita() {
			$datos = [
				'idUser' => $_POST['idUser'],
				'idServic' => $_POST['idServic'],
				'idHora' => $_POST['idHora'],
				'fecha' => $_POST['fechaf'],
				'tiempo' => 30,
				'estado' => 1,
				'tipo' => $_POST['tipoCita'],

			];
			citaModelo::saveCita_m($datos);
		}

		

	} 