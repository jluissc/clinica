<nav class="navbar navbar-expand navbar-light " style="
    background-color: #82d3e6;
">
    <div class="container-fluid">
        <a href="#" class="burger-btn d-block">
            <i class="bi bi-justify fs-3"></i>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> 
                <?php if($_SESSION['tipo']==1 || in_array(3, $_SESSION['permisos']) ){ ?><!-- ADMIN o CAJERO -->
                
                <li class="nav-item dropdown me-3">
                    <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                        
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="background-color: #e1e6dc;">
                        <?php
                            require_once './controladores/configControlador.php';
                            $inst = new configControlador();
                            echo $inst -> listNotifications();
                        ?>
                        <!-- <li><a class="dropdown-item">1 pago por verificar</a></li>
                        <li><a class="dropdown-item">1 pago por verificar</a></li> -->
                    </ul>
                    <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle" style="
                        margin-left: -26px;
                        margin-top: 24px;">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </li>
                <?php } ?><!-- ADMIN o CAJERO -->
            </ul>
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600"><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido'] ?></h6>
                            <p class="mb-0 text-sm text-gray-600"><?php echo $_SESSION['tipo'] == 1 ? 'ADMINISTRADOR' : 'PACIENTE'  ?></p>
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="<?php echo SERVERURL  ?>vistas/assets/images/faces/1.jpg">
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="background-color: #e1e6dc;">
                    <li> <h6 class="dropdown-header">Hola, <?php echo $_SESSION['nombre'] ?>!</h6> </li>
                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> Mi Perfil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i> Configuraciones</a></li>
                    <li> <hr class="dropdown-divider"> </li>
                    <li class="btn-exit-system"><a class="dropdown-item" href="#"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Cerrar Session</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>