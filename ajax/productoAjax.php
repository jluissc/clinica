<?php 

	$peticionAjax = true;

	// require_once '../config/app.php';

	if (isset($_POST['puntuacion']) || isset($_POST['id']) || isset($_POST['search']) ) {
		
		require_once '../controller/productosControlador.php';
		$inst = new productosControlador();
 
		// registro nueva products
		/*if (isset($_POST['puntuacion'])) {
			echo $inst -> agregar_puntuacion_C();
		}*/

		// traer un producto con el id
		if (isset($_POST['id'])) {
			// exit(json_encode($_POST['id']));
			$inst -> showProductoId();
		}
		if (isset($_POST['search'])) {
			// exit(json_encode($_POST['id']));
			$inst -> buscarProducto();
		}


		
 

	} 


     // corregir la tabla de puntuacion y like en el atributo user por cliente