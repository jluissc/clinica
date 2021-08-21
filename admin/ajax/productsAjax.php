<?php 

	$peticionAjax = true;

	require_once '../config/app.php';

	if (isset($_POST['producto_name_reg']) || isset($_POST['prod_rapido']) || isset($_POST['prod_detalles']) || isset($_POST['prod_fotos']) || isset($_POST['producto_name_edit'])  || isset($_POST['producto_tal_edit']) || isset($_POST['category']) || isset($_POST['id_prod_fotos']) || isset($_POST['id_del'])) {
		
		require_once '../controladores/productsControlador.php';
		$inst = new productsControlador();

		// registro nueva products
		if (isset($_POST['producto_name_reg'])) {
			echo $inst -> agregar_products_C();
		}

		// traer products Unico
		if (isset($_POST['prod_rapido'])) {
			$inst ->unic_products_C(); 
		}

		// traer products Unico
		if (isset($_POST['prod_detalles'])) {
			$inst ->unic_products_d_C(); 
		}

		// traer products Unico
		if (isset($_POST['prod_fotos'])) {
			$inst ->unic_products_f_C(); 
		}

		// editar products rapido
		if (isset($_POST['producto_name_edit'])) {
			echo $inst -> update_products_C();	
		}

		// editar products detalles
		if (isset($_POST['producto_tal_edit'])) {
			echo $inst -> update_detalles_prod_C();			
		}

		// editar products
		if (isset($_POST['id_prod_fotos'])) {
			echo $inst -> update_fotos_prod_C();			
		}

		// listar products-categorias
		if (isset($_POST['category'])) {
			$inst -> lista_categorys_C();			
		}

		// eliminar
		if(isset($_POST['id_del'])){
			echo $inst -> delete_products_C();	
		}

		


	} else {
		session_start(['name' => 'bot']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}	
    