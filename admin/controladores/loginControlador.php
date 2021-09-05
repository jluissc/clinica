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
			
			if($user == null && $pass == null ){

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
					// if($logueo -> rowCount() == 1 ){
						session_start(['name' => 'bot']);
						$_SESSION['id'] = $datos['id'];
						$_SESSION['nombre'] = $datos['nombre'];
						$_SESSION['apellido'] = $datos['apellidos'];
						$_SESSION['dni'] = $datos['dni'];
						$_SESSION['email'] = $datos['correo'];
						$_SESSION['foto'] = $datos['foto'];
						$_SESSION['tipo'] = $datos['tipo_user_id'];
						$_SESSION['logueo'] = $datos['logueo'];
						$_SESSION['token'] = md5(uniqid(mt_rand(),true));					
						
						return header("Location: ".SERVERURL."home/");
					// }else{
					// 	echo '<script>
					// 		console.log(" no cambio estado logueo");
					// 	</script>';
					// }
					
				}else{
					echo '<script>
						console.log("usuario estado inactivo");
					</script>';
				}
				
			}else{ 
				echo '<script>
				console.log("no se encontro paciente");
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

