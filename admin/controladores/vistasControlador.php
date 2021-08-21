<?php 
	/**
	 * 
	 */
	
	require_once './modelos/vistasModelo.php';
	class vistasControlador extends vistasModelo
	{
		public function obtener_plantilla_C()
		{
			return require_once './vistas/plantilla.php';
		}

		public function obtener_vistas_C()
		{
			if (isset($_GET['ruta'])) {
				$ruta = explode("/", $_GET['ruta']);
				$respuesta = vistasModelo::obtener_vistas_M($ruta[0]);
			}else{
				$respuesta = "login";
			}
			return $respuesta;
		}
		
		
	}