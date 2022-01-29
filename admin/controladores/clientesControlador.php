<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/clienteModelo.php';
	}else{
		require_once './modelos/clienteModelo.php';
	} 

	class clienteControlador extends clienteModelo	{

		
		// public function reedListCustomers() {
		public function listsCustomers() {
			session_start(['name' => 'bot']);
			$listCustomers = clienteModelo::reedListCustomers_m();
			$datos =[];
			foreach ($listCustomers as $customer) {
				// <button class="btn btn-outline-primary" onclick="showDetailCustomer('.$customer->id.')">Detalles</button>				
				$nombre = $customer->nombre.' '.$customer->apellidos;
				$correo = $customer->correo;
				if ($_SESSION['tipo'] != 5) {
					$acciones = '<button class="btn btn-outline-info" onclick="showCustomer('.$customer->id.',2)" data-bs-toggle="modal"
						data-bs-target="#info">Editar</button>
					<button class="btn btn-outline-danger" onclick="deleteCustomer('.$customer->id.')">Eliminar</button>';
				} else {
					$acciones = '<button class="btn btn-outline-info" onclick="modoView()" data-bs-toggle="modal">Editar</button>
					<button class="btn btn-outline-danger" onclick="modoView()">Eliminar</button>';
				}
				
				
				array_push($datos,[
					'nombre' => $nombre,
					'dni' => $customer->dni,
					'correo' => $correo,
					'celular' => $customer->celular,
					'acciones' => $acciones,
				]);
			}
			exit(json_encode($datos));
		}

		public function showCustomer(){
			$idAppont = $_POST['idCustomer'];
			clienteModelo::showCustomer_m($idAppont);
			// exit(json_encode($idCustomer));
		}

		public function deleteCustomer(){
			$idAppont = $_POST['idDelete'];
			clienteModelo::deleteCustomer_m($idAppont);
			// exit(json_encode($idCustomer));
		}

		public function insertAppoint(){
			$name_appoint = mainModelo::limpiar_cadena($_POST['name_appoint']);
			$last_appoint = mainModelo::limpiar_cadena($_POST['last_appoint']);
			$email_appoint = mainModelo::limpiar_cadena($_POST['email_appoint']);
			if(strlen($name_appoint)>0){
				if(strlen($last_appoint)>0){
					$datos= [
						'dni_appoint' => $_POST['dni_appoint'],
						'name_appoint' => $name_appoint,
						'last_appoint' => $last_appoint,
						'celphone_appoint' => $_POST['celphone_appoint'],
						'email_appoint' => $email_appoint,
						'addres_appoint' => $_POST['addres_appoint'],
						'idAppoint' => intval($_POST['idAppoint']),
						'pass' => mainModelo::encryption($_POST['dni_appoint']),
						'tipo' => 4,
						'estado' => 1,
					];
					clienteModelo::insertAppoint_m($datos);
				}else exit(json_encode([0,'Apellidos incorrecto']));
			}else exit(json_encode([0,'Nombre incorrecto']));
			
			// exit(json_encode($idCustomer));
		}
	}