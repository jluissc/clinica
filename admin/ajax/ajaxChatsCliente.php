<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['idCliente']) || isset($_POST['mensaje']) || isset($_POST['aaaa']) || isset($_POST['listaChat'])) {
		
		require_once '../controladores/controladorChatClientes.php';
		$inst = new controladorChatClientes();

		// ************traer datos del chats seleccionado************
		if (isset($_POST['idCliente'])) {
			$inst -> C_mostrarChatCliente();
		}
        
		// traer categoria Unico
		if (isset($_POST['mensaje'])) {
			$inst -> C_enviarMensajeCliente();
		}

		// editar Categoria
		if (isset($_POST['aaaa'])) {
			$inst -> C_enviarMensajeCliente2();
		}

		// eliminar Categoria
		if (isset($_POST['listaChat'])) {
			echo $inst -> C_listaClientes();	
		}


	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
 