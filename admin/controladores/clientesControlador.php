<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/clienteModelo.php';
	}else{
		require_once './modelos/clienteModelo.php';
	} 

	class clienteControlador extends clienteModelo	{

		
		// public function reedListCustomers() {
		public function listsCustomers() {
			$listCustomers = clienteModelo::reedListCustomers_m();
			$datos =[];
			foreach ($listCustomers as $customer) {
				// <button class="btn btn-outline-primary" onclick="showDetailCustomer('.$customer->id.')">Detalles</button>				
				$nombre = $customer->nombre.' '.$customer->apellidos;
				$correo = $customer->correo;
				$acciones = '<button class="btn btn-outline-info" onclick="showCustomer('.$customer->id.',2)" data-bs-toggle="modal"
						data-bs-target="#info">Editar</button>
					<button class="btn btn-outline-danger" onclick="deleteCustomer('.$customer->id.')">Eliminar</button>';
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
			$datos= [

				'dni_appoint' => $_POST['dni_appoint'],
				'name_appoint' => $_POST['name_appoint'],
				'last_appoint' => $_POST['last_appoint'],
				'celphone_appoint' => $_POST['celphone_appoint'],
				'email_appoint' => $_POST['email_appoint'],
				'addres_appoint' => $_POST['addres_appoint'],
				'idAppoint' => intval($_POST['idAppoint']),
				'pass' => mainModelo::encryption($_POST['dni_appoint']),
				'tipo' => 4,
				'estado' => 1,
			];
			clienteModelo::insertAppoint_m($datos);
			// exit(json_encode($idCustomer));
		}
	}