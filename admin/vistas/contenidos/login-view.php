
<?php  

if (isset($_POST['usuario_log']) && isset($_POST['clave_log'])) {
	if ($_POST['usuario_log'] === '' && $_POST['clave_log'] === '' ) {
		echo '<script>
		Swal.fire({
			title: "Error",
			text: "Campos Vacios",
			type: "error",
			confirmButtonText: "Aceptar"
		});
	</script>';
	} else {
		require_once './controladores/loginControlador.php';
		$inst = new loginControlador();
		echo $inst -> iniciar_sesion_C();
	}
	
}
?>
<div id="auth">        
	<div class="row h-100">
		<div class="col-lg-5 col-12">
			<div id="auth-left">
				<div class="auth-logo">
					<a><img src="<?php echo SERVERURL ?>vistas/assets/images/logo/logo.png" alt="Logo"></a>
				</div>
				<h1 class="auth-title">Iniciar Session</h1>
				<p class="auth-subtitle mb-5">Ingrese para poder ver sus citas o reservarlas</p>
	
				<form action="" method="POST" autocomplete="off" >
					<div class="form-group position-relative has-icon-left mb-4">
						<input class="form-control" name="usuario_log" type="text"
								placeholder="Ingrese DNI">
						<div class="form-control-icon">
							<i class="bi bi-person"></i>
						</div>
					</div>
					<div class="form-group position-relative has-icon-left mb-4">
						<input class="form-control" name="clave_log" type="password"
								placeholder="Ingrese clave">
						<div class="form-control-icon">
							<i class="bi bi-shield-lock"></i>
						</div>
					</div>
					<div class="form-check form-check-lg d-flex align-items-end">
						<input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
						<label class="form-check-label text-gray-600" for="flexCheckDefault">
							Recuerdamelo
						</label>
					</div>
					<button type="submit" class="btn btn-block btn-dark">Iniciar</button>
				</form>
				<div class="text-center mt-5 text-lg fs-4">
					<p class="text-gray-600">Regresar a pagina principal <a href="../home" class="font-bold">click aqui</a>.</p>
					<p><!-- <a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>. --></p>
				</div>
			</div>
		</div>
		<div class="col-lg-7 d-none d-lg-block">
			<div id="auth-right">
	
			</div>
		</div>
	</div>		
</div>