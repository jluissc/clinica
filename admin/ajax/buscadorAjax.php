<?php

	session_start(['name' => 'bot']);
	
	require_once '../config/app.php';

	if(isset($_POST['busqueda-user']) || isset($_POST['eliminar-busqueda']) || isset($_POST['busqueda_inicio_prestamo']) || isset($_POST['busqueda_final_prestamo'])){

		$data_url = [
			"usuario" => "user-search",
			"cliente" => "client-search",
			"item" => "item-search",
			"prestamo" => "reservation-search"
		];

		if(isset($_POST['modulo'])){
			$modulo = $_POST['modulo'];
			if (!isset($data_url[$modulo])) {
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"No podemos continuar con la busqueda",
					"Texto"=>"Debido a alguna configuracions",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
		}else{
			$alerta=[
				"Alerta"=>"simple",
				"Titulo"=>"No podemos continuar con la busqueda",
				"Texto"=>"Debido a alguna configuracions",
				"Tipo"=>"error"
			];
			echo json_encode($alerta);
			exit();
		}

		if ($modulo == "prestamo") {
			$fecha_inicio = "fecha_inicio_".$modulo;
			$fecha_final = "fecha_final_".$modulo;

			if (isset($_POST['busqueda_inicio_prestamo']) || isset($_POST['busqueda_final_prestamo'])) {

				if ($_POST['busqueda_inicio_prestamo'] == "" || $_POST['busqueda_final_prestamo'] == "") {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"No podemos continuar con la busqueda",
						"Texto"=>"Campos vacios de fechas",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}

				$_SESSION[$fecha_inicio] = $_POST['busqueda_inicio_prestamo'];
				$_SESSION[$fecha_final] = $_POST['busqueda_final_prestamo'];
			}

			if(isset($_POST['eliminar-busqueda'])){
				unset($_SESSION[$fecha_inicio]);
				unset($_SESSION[$fecha_final]);
			}
		} else {
			$name_var ="busqueda_".$modulo;
			
			if (isset($_POST['busqueda-user']) ) {

				if($_POST['busqueda-user'] == ""){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"No podemos continuar con la busqueda",
						"Texto"=>"Campos vacios de busqueda",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}	
				$_SESSION[$name_var] = $_POST['busqueda-user'];
			}

			//eliminar
			if(isset($_POST['eliminar-busqueda'])){
				unset($_SESSION[$name_var]);
			}
		}

		// redireccionar
		$url = $data_url[$modulo];
		$alerta = [
			"Alerta" => "redireccionar",
			"URL"  => SERVERURL.$url."/"
		];		
		echo json_encode($alerta);
	}else{
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}