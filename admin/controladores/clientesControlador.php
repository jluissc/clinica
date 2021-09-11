<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/clienteModelo.php';
	}else{
		require_once './modelos/clienteModelo.php';
	} 

	class clienteControlador extends clienteModelo	{

		
		public function reedListCustomers() {
			$listCustomers = clienteModelo::reedListCustomers_m();
			$html ='';
			foreach ($listCustomers as $customer) {
				$html .='<tr>
						<td>'.$customer->nombre.' '.$customer->apellidos.'</td>
						<td>'.$customer->correo.'</td>
						<td>'.$customer->celular.'</td>
						<td>'.$customer->correo.'</td>
						<td>'.$customer->celular.'</td>
						<td>
							<button class="btn btn-outline-primary" onclick="showDetailCustomer('.$customer->id.')">Detalles</button>
							<button class="btn btn-outline-info" onclick="showCustomer('.$customer->id.')">Editar</button>
							<button class="btn btn-outline-danger" onclick="deleteCustomer('.$customer->id.')">Eliminar</button>
						</td>
					</tr>';
			}
			return $html; 
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
	}