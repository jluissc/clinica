<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">    <i class="ti-menu ti-close"></i></a>
            
            <div class="navbar-brand">
                <a href="<?php echo SERVERURL ?>home/">
                    <b class="logo-icon">
                        <img src="<?php echo SERVERURL; ?>vistas/assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                        <img src="<?php echo SERVERURL; ?>vistas/assets/images/logo-icon.png" alt="homepage" class="light-logo" />
                    </b>
                    <span class="logo-text">
                        <img src="<?php echo SERVERURL; ?>vistas/assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                        <img src="<?php echo SERVERURL; ?>vistas/assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                    </span>
                </a>
            </div>
            
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>
        
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="settings" class="svg-icon"></i>
                    </a>
                    <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div> -->
                </li>
            </ul>

            <ul class="navbar-nav float-right">
                
                <!-- <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <form>
                            <div class="customize-input">
                                <input class="form-control custom-shadow custom-radius border-0 bg-white"
                                type="search" placeholder="Search" aria-label="Search">
                                <i class="form-control-icon" data-feather="search"></i>
                            </div>
                        </form>
                    </a>
                </li> -->
    
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo $_SESSION['foto_bot'] ?>" alt="user" class="rounded-circle" width="40">
                        <span class="ml-2 d-none d-lg-inline-block">
                            <span>Hola,</span>
                            <span class="text-dark">
                                <?php 
                                echo $_SESSION['nombre_bot']." ".$_SESSION['apellido_bot']; 
                                ?>
                            </span> 
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i data-feather="user" class="svg-icon mr-2 ml-1"></i>
                            Mi Perfil
                        </a>
                        <?php 
                        // echo $listachatUU -> cant_Chat_C2(); ?>
                        <!-- <a class="dropdown-item" href="javascript:void(0)">
                            <i data-feather="mail" class="svg-icon mr-2 ml-1"></i>
                            Mensajes
                        </a> -->
                        
                        <div class="dropdown-divider"></div>
                        
                        <!-- <a class="dropdown-item" href="javascript:void(0)">
                            <i data-feather="settings" class="svg-icon mr-2 ml-1"></i>
                           Config. de Cuenta
                        </a>
                        
                        <div class="dropdown-divider"></div> -->
                        
                        <a class="dropdown-item btn-exit-system" href="">
                            <i data-feather="power"class="svg-icon mr-2 ml-1"></i>
                            Cerrar Sessión
                        </a>
                        
                        <div class="dropdown-divider"></div>
                        
                        
                    </div>
                </li>

            </ul> 
        </div>
    </nav>
</header>