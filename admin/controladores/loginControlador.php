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

			$aaaa = mainModelo::encryption($pass);


			$dato = [
				"user" => $user,
				"pass" => $aaaa
			];

			$ins = loginModelo::iniciar_sesion_M($dato);

			if($ins -> rowCount() == 1){
				$datos = $ins -> fetch();
				if($datos['usu_estado'] == 1){

					session_start(['name' => 'bot']);
					$_SESSION['id_bot'] = $datos['id_usu'];
					$_SESSION['nombre_bot'] = $datos['usu_nombre'];
					$_SESSION['apellido_bot'] = $datos['usu_apellido'];
					$_SESSION['usuario_bot'] = $datos['id_usu'];
					$_SESSION['privilegio_bot'] = $datos['usu_id_neg'];
					$_SESSION['foto_bot'] = $datos['usu_foto'];
					$_SESSION['token_bot'] = md5(uniqid(mt_rand(),true));
					
					
					return header("Location: ".SERVERURL."home/");
				}else{
					echo '<script>
						Swal.fire({
							title: "No Tienes Permisos",
							text: "Error",
							type: "error",
							confirmButtonText: "Aceptar"
						});
					</script>';
				}
				
			}else{ 
				echo '<script>
						Swal.fire({
							title: "Usuario No Encontrado",
							text: "Error",
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

