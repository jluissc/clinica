<?php 
	/**
	 * 
	 */
	class vistasCModel{

		protected static function obtener_vistas_M($ruta){
			$listasVistas = ["home","terapia","odontologia","nosotros","contactos"];

			if(in_array($ruta,$listasVistas)){				
				// si exist el archivo el d eabajo
				if(is_file("./view/contenidos/".$ruta."-view.php")){
					$contenido = "./view/contenidos/".$ruta."-view.php";
				} else{
					$contenido = "404";
				}
			} elseif ($ruta == "index" || $ruta == "login" || $ruta == "inicio") {
				$contenido = "./view/contenidos/home-view.php";
			}else{
				$contenido = "./view/contenidos/404-view.php";			
			}
			return $contenido;
		}

	}