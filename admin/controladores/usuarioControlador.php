<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/usuarioModelo.php';
	}else{
		require_once './modelos/usuarioModelo.php';
	}

	class usuarioControlador extends usuarioModelo	{

		public function listar_user_C(){
			$idEnvio = $_SESSION['id_bot'];
			$listaUser = usuarioModelo::listar_user_M($idEnvio);
			$div = '';
			foreach ($listaUser as $user) {
				$rol = '';
				switch ($user ->rol_id_rol) {
					case 1:
						$rol = 'primary';
						break;
					
					case 2:
						$rol = 'success';
						break;
					case 3:
						$rol = 'warning';
						break;
					default:
						# code...
						break;
				}



				$div.= '<div class="col-md-3"> 
					<div class="card text-white bg-'.$rol.' text-center">
						<div class="card-header">
							<h4 class="mb-0 text-white"> '.$user->u_name.' '.$user->u_last.'</h4>
						</div>
						<div class="card-body">
							<h3 class="card-title text-white">Special title treatment</h3>
							<p class="card-text">With supporting text below as a natural lead-in to
								additional
							content.</p>
							 <button class="btn btn-danger"  onclick="traerDatos('.$user->id_u.')" data-toggle="modal" data-target="#editUser"><i class="fas fa-edit"></i>Ver Datos</button>
						</div>
					</div>
				</div>';
			}
			return $div;
		}

		public function mostrar_unico_user_C(){
			$id = usuarioModelo::mostrar_unico_user_M($_POST['idDato']);
		}
		

		public function update_user_C(){
			session_start(['name' => 'bot']);
			$privilegio = $_SESSION['privilegio_bot'];

			$name=mainModelo::limpiar_cadena($_POST['user_name_edit']);
			$last=mainModelo::limpiar_cadena($_POST['user_last_edit']);
			$user=mainModelo::limpiar_cadena($_POST['user_user_edit']);
			$pass=mainModelo::limpiar_cadena($_POST['user_pass_edit']);
			$status = isset($_POST['user_status_edt']) ? 1 : 0;
			$id=mainModelo::limpiar_cadena($_POST['id_user']);
			$privi=mainModelo::limpiar_cadena($_POST['user_privelgio_edit']);


			if($privilegio ==2){
				
				$id_u = $_SESSION['id_bot'];
				$userS=mainModelo::limpiar_cadena($_POST['user_user']);
				$passS=mainModelo::limpiar_cadena($_POST['user_pass']);
				if($userS == null || $userS == ''){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Datos vacios",
					"Texto"=>"Credenciales vacios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($passS == null || $passS == ''){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Dato Vacio",
					"Texto"=>"Credenciales vacios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

				$check_cuenta= mainModelo::ejecutar_consulta_simple("SELECT * FROM user WHERE u_user = '$userS' AND u_pass = '$passS' AND id_u= $id_u");
				if($check_cuenta -> rowCount() <=0){
					$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Tus credenciales erroneos",
								"Texto"=>"Intentalo denuevo",
								"Tipo"=>"error"
							];
					echo json_encode($alerta);
					exit();
				}
			}
			
			
				

			
			if($name == null || $name == ''){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Dato Vacio",
					"Texto"=>"Completa los datos",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$name)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}


			$datos = [
				"name" => $name,
				"last" => $last,
				"user" => $user,
				"pass" => $pass,
				"status" => $status,
				"id" => $id,
				"privi" => $privi

			];

			$agregarC = usuarioModelo::update_user_M($datos);

			if($agregarC -> rowCount() == 1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Dato Editado",
					"Texto"=>"El usuario fue editado",
					"Tipo"=>"success"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un problemsa",
					"Texto"=>"Comuniquese con su proveedor",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			

			
			
		}

		

	}   