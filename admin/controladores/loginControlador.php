<?php 
	
	if ($peticionAjax) {
		require_once '../modelos/loginModelo.php';
	}else{
		require_once './modelos/loginModelo.php';
	}

	/**
	 *  
	 */
	class loginControlador extends loginModelo{
		
		public function iniciar_sesion_C(){
			$user=mainModelo::limpiar_cadena($_POST['usuario_log']);
			$pass=mainModelo::limpiar_cadena($_POST['clave_log']);
			
			if($user == '' || $pass == '' ){

				echo '<script>
						Swal.fire({
							title: "Error",
							text: "Campos Vacios",
							type: "error",
							confirmButtonText: "Aceptar"
						});
					</script>';

			}

			if(mainModelo::verificar_datos("[a-zA-Z0-9]{1,35}",$user)) {
				echo '<script>
						Swal.fire({
							title: "Error",
							text: "Usuario Vacio",
							type: "error",
							confirmButtonText: "Aceptar"
						});
					</script>';
			}
			if(mainModelo::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$pass)) {
				echo '<script>
						Swal.fire({
							title: "Error",
							text: "Clave Vacia",
							type: "error",
							confirmButtonText: "Aceptar"
						});
					</script>';
			}

			// $aaaa = mainModelo::encryption($pass);


			$dato = [
				"user" => $user,
				"pass" => $pass,
			];

			$ins = loginModelo::iniciar_sesion_M($dato);
			
			if($ins -> rowCount() == 1){
				$datos = $ins -> fetch();
				if($datos['estado'] == 1){
					loginModelo::activarSession($datos['id']);
					$inst = loginModelo::datosUser_m($datos['id']);
					// if($inst -> rowCount() == 1){
						session_start(['name' => 'bot']);
						$datosPermi = $inst -> fetchAll();
						$permisos = array();
						$a =1;
						foreach ($datosPermi as $key => $permi) {							
							// array_push($permisos,[
							// 	'idPerm' => $permi['idPerm'],
							// 	'perm' => $permi['perm'],
							// ]);
							array_push($permisos,$permi['idPerm']);
						}
						$_SESSION['permisos'] = $permisos;
						$_SESSION['id'] = $datos['id'];
						$_SESSION['nombre'] = $datos['nombre'];
						$_SESSION['apellido'] = $datos['apellidos'];
						$_SESSION['dni'] = $datos['dni'];
						$_SESSION['email'] = $datos['correo'];
						$_SESSION['celular'] = $datos['celular'];
						$_SESSION['direccion'] = $datos['direccion'];
						$_SESSION['tipo'] = $datos['tipo_user_id'];
						$_SESSION['logueo'] = $datos['logueo'];
						$_SESSION['token'] = md5(uniqid(mt_rand(),true));					
						
						return header("Location: ".SERVERURL."home/");
					// }
					
					
				}else{
					echo '<script>
						Swal.fire({
							title: "Error",
							text: "Usuario Inactivo",
							type: "error",
							confirmButtonText: "Aceptar"
						});
					</script>';
				}
				
			}else{ 
				echo '<script>
						Swal.fire({
							title: "Error",
							text: "No se encontro usuario",
							type: "error",
							confirmButtonText: "Aceptar"
						});
					</script>';
			} 

		}

		public function forzar_cierre_C(){
			session_unset();
			session_destroy();
			if (headers_sent()) {
				echo "<script> window.location.href='".SERVERURL."login/';</script>";
			}else{
				return header("Location: ".SERVERURL."login/");
			}
		}

		public function cierre_sesion_C(){
			session_start(['name' => 'bot']);
			$token = mainModelo::decryption($_POST['token']);
			$usuario = mainModelo::decryption($_POST['usuario']);

			if ($token == $_SESSION['token_bot'] && $usuario == $_SESSION['usuario_bot']) {
				session_unset();
				session_destroy();
				$alerta = [
					"Alerta" => "redireccionar",
					"URL" => SERVERURL."login/"
				];
				echo json_encode($alerta);
				exit();
			} else {
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No se pudo cerrar la session de sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
			}		
		}
	}

