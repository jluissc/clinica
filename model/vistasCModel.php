<?php 
	/**
	 * 
	 */
	class vistasCModel{

		protected static function obtener_vistas_M($ruta){
			$listasVistas = ["home","productos","detalles","pedidos","categoria","oferta","nosotros"];

			if(in_array($ruta,$listasVistas)){

				
					// si exist el archivo el d eabajo
					if(is_file("./view/contenidos/".$ruta."-view.php")){
						$contenido = "./view/contenidos/".$ruta."-view.php";
					} else{
						$contenido = "404";
					}
			} elseif ($ruta == "index" || $ruta == "login") {
				$contenido = "home";
			}else{
				$contenido = "404";				
			}
			return $contenido;
		}

	}