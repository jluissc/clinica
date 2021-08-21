<?php 
	/**
	 * 
	 */
	
	require_once './model/vistasCModel.php';
	class vistasCController extends vistasCModel
	{
		public function obtener_plantilla_C()
		{
			return require_once './view/plantilla.php';
		}

		public function obtener_vistas_C()
		{
			if (isset($_GET['ruta'])) {
				$ruta = explode("/", $_GET['ruta']);
				
				$respuesta = vistasCModel::obtener_vistas_M($ruta[0]);
				
			}else{
				$respuesta = "./view/contenidos/home-view.php";
			}
			return $respuesta;
		}
	}  
