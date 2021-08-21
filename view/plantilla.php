<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Docmed</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo SERVERURL ?>view/img/favicon.png">
	
    <title>
		<?php echo COMPANY?>
	</title>
	<?php 
		include "./view/inc/link.php"; 		
	?>
    
</head>
<body>

    <!--====== Main App ======-->
    <!-- <div id="app">	 -->
	
		<?php 
			include "./view/inc/navBar.php"; 
		?>
		
		<?php 
			$peticionAjax = false;			
			require_once "./controller/vistasCController.php"; 			
			$IV = new vistasCController();			
			$vistas = $IV -> obtener_vistas_C();
			// require_once 'inc/agregar_carrito_success.php';
			include $vistas;			
		?>
	
		<?php 
			include "./view/inc/footer.php"; 			
		?>
	<!-- </div> -->
	<?php 
		include "./view/inc/scrip.php"; 
	?>

</body>
</html>
