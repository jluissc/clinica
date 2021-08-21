<?php 

	$peticionAjax = true;

	require_once '../config/app.php';	

	if (isset($_POST['token']) && isset($_POST['usuario'])) {
		require_once '../controladores/loginControlador.php';
		$inst = new loginControlador();
		echo $inst -> cierre_sesion_C();

	} 
	elseif(isset($_POST['email'])){
		echo 'que hay nuevo viejo';
	}
	else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	} 