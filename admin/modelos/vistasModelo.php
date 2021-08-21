<?php 
	/**
	 * 
	 */
	class vistasModelo{

		protected static function obtener_vistas_M($ruta){
			$listasVistas = ["client-list","client-new","client-search","client-update","bussines","home","user","products","category","chat-admin","chat-ca","comments","chats-clientes","pedidos"];
			if(in_array($ruta,$listasVistas)){
				// si exist el archivo el d eabajo
				if(is_file("./vistas/contenidos/".$ruta."-view.php")){
					$contenido = "./vistas/contenidos/".$ruta."-view.php";
				} else{
					$contenido = "404";
				}
			} elseif ($ruta =="login" || $ruta == "index") {
				$contenido = "login";
			}else{
				$contenido = "404";				
			}
			return $contenido;
		}

	}