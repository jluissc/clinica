<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo COMPANY; ?></title>
	<?php include "./vistas/inc/link.php"; ?>
    
</head>
<body class="light"> 
    
	
	<?php 
		$peticionAjax = false;
		require_once "./controladores/vistasControlador.php"; 
		$IV = new vistasControlador();
		$vistas = $IV -> obtener_vistas_C();
		if($vistas == "login" || $vistas == "404"){
			require_once "./vistas/contenidos/".$vistas."-view.php";
		}else{
			session_start(['name' => 'bot']);
			$pagina = explode("/",$_GET['ruta']);
			require_once "./controladores/loginControlador.php"; 
			$inst = new loginControlador();
			if (!isset($_SESSION['token']) || 
            !isset($_SESSION['nombre']) || 
            !isset($_SESSION['email']) || 
            !isset($_SESSION['id']) ) {
				echo $inst -> forzar_cierre_C();
				exit();
			}	 	
	?>
    <!-- ********** -->
    <div id="app">
        <?php if($_SESSION['tipo'] == 1){ ?>
            <div id="sidebar" class="active">
                <div class="sidebar-wrapper active">
                    <div class="sidebar-header">
                        <div class="d-flex justify-content-between">
                            <div class="logo">
                                <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                            </div>
                            <div class="toggler">
                                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-menu">
                        <?php 
                            include "./vistas/inc/navLateral.php"; 
                        ?>
                    </div>
                    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
                </div>
            </div>
            <div id="main" class='layout-navbar'>
                
                <header class='mb-3'>
                    <?php 
                        include "./vistas/inc/navHorizontalAdmin.php"; 
                    ?>
                </header>
                
                <div id="main-content">
                    <div class="page-heading">
                        <?php include $vistas; ?>
                    </div>
                    <footer>
                        <div class="footer clearfix mb-0 text-muted">
                            <div class="float-start">
                                <p>2021 &copy; Mazer</p>
                            </div>
                            <div class="float-end">
                                <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                        href="http://ahmadsaugi.com">A. Saugi</a></p>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        <?php }elseif($_SESSION['tipo'] == 4){ ?>
            <div id="main" class="layout-horizontal">
                <header class="mb-5">
                    <?php 
                        include "./vistas/inc/navHorizontalCustomer.php"; 
                    ?>
                    
                </header>

                <div class="content-wrapper container">
                    
                    <div class="page-heading">
                        <h3>Horizontal Layout</h3>
                    </div>
                    <div class="page-content">
                        <?php include $vistas; ?>
                    </div>

                </div>
                <footer>
                    <div class="container">
                        <div class="footer clearfix mb-0 text-muted">
                            <div class="float-start">
                                <p>2021 &copy; Mazer</p>
                            </div>
                            <div class="float-end">
                                <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                        href="http://ahmadsaugi.com">A. Saugi</a></p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        <?php } ?>
        
    </div>
    <?php 
        include "./vistas/inc/logout.php"; 
        include "./vistas/inc/scrip.php"; 
        }    
    ?>
</body>
</html>