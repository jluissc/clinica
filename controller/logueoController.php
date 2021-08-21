<?php 
	session_start(['name' => 'cliente']);
	
	if ($peticionAjax) { 
		require_once '../model/logueoModel.php';
	}else{ 
		require_once './model/logueoModel.php';
	}
	class logueoController extends logueoModel {        

        public function iniciar_sesion_C(){
			$user = $_POST['user'];
			$pass = $_POST['pass'];

			$dato = [
				"user" => $user,
				"pass" => $pass 
			]; 
			$ins = logueoModel::iniciar_sesion_M($dato);


			if($ins -> rowCount() == 1){
				$datos = $ins -> fetch(PDO::FETCH_OBJ);	
				if($datos->cli_estado == 1 ){
					
					// session_start(['name' => 'cliente']);
					$_SESSION['cli_id'] = mainModel::encryption($datos->id_cli);
					$_SESSION['cli_nombre'] = $datos->cli_nombre;
					$_SESSION['cli_apellido'] = $datos->cli_apellido;
					$_SESSION['cli_token'] = md5(uniqid(mt_rand(),true));
					// echo 'ok';
					$resp = [
						'id' => $_SESSION['cli_id'],
						'user' => mainModel::encryption($user),
						'name' => $_SESSION['cli_nombre'],
						'last' => $_SESSION['cli_apellido'],
						'token' => $_SESSION['cli_token'],
						'token2' => mainModel::encryption($_SESSION['cli_token']),
					];
					exit(json_encode($resp));
					
				}else{
					echo 'sp';
					// echo '<script>
					// 	Swal.fire({
					// 		title: "vvvvvvv",
					// 		text: "Error",
					// 		type: "error",
					// 		confirmButtonText: "Aceptar"
					// 	});
					// </script>';
				}
				
			}else{
				
				exit(json_encode('mal'));
			}

		}

		public function verificarUsuario($tipo=''){
			if($tipo){
				$id = mainModel::decryption($_POST['ida']);
				$user = mainModel::decryption($_POST['usera']);
				$token2 = mainModel::decryption($_POST['token2a']);
				$token = $_POST['tokena'];
			}else{

				$id = mainModel::decryption($_POST['id']);
				$user = mainModel::decryption($_POST['user']);
				$token2 = mainModel::decryption($_POST['token2']);
				$token = $_POST['token'];
			}

			$datos = [
				"user" => $user,
				"pass" => $id,
			]; 
			if ($token == $token2) {
				$ins = logueoModel::iniciar_sesion_M($datos,'id');

				if($ins -> rowCount() == 1){
					$users = $ins -> fetch(PDO::FETCH_OBJ);	
					if($users->cli_estado == 1 ){
						if($tipo){
							return 'b';
						}else{

							echo 'b';
						}
					}else{
						// echo 'estado inact';
						echo 'ei';
					}
				}else{
					echo 'ne';
				}
			}else{
				echo 'td';
			}
			
		}

		public function mostrarCuenta(){
			// $user = $this->verificarUsuario(true);
			if($this->verificarUsuario(true) == 'b'){
				$id = mainModel::decryption($_POST['ida']);
				logueoModel::datosUser_M($id);

			}else{
				exit(json_encode('0'));
			}
			// echo 1;
		}

		public function editCuenta(){	
			$id = mainModel::decryption($_POST['iduser']);		
			$dates = [
				'name' => $_POST['name'],
				'last' => $_POST['last'],
				'celphone' => $_POST['celphone'],
				'address' => $_POST['address'],
				'iduser' => $id,
			];
			if(logueoModel::editCuenta_M($dates) =='b'){
					$_SESSION['cli_token'] = md5(uniqid(mt_rand(),true));
					// echo 'ok';
					$resp = [
						'id' => $_POST['iduser'],
						'user' => $_POST['user'],
						'name' => $_POST['name'],
						'last' => $_POST['last'],
						'token' => $_SESSION['cli_token'],
						'token2' => mainModel::encryption($_SESSION['cli_token']),
					];
					exit(json_encode($resp));
			}else{
				exit(json_encode(0));
			}
		}
	}    