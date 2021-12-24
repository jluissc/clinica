<nav class="navbar navbar-expand navbar-light " style="background-color: #82d3e6;">
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
                <?php if($_SESSION['tipo']==1 || $_SESSION['tipo']==2 ){ ?><!-- ADMIN o CAJERO -->
                
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
                            <p class="mb-0 text-sm text-gray-600"><?php echo $_SESSION['tipo'] == 1 ? 'ADMINISTRADOR' : ($_SESSION['tipo'] == 2 ? 'COLABORADOR' :'PACIENTE')  ?></p>
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
                    <li><a class="dropdown-item" href="#" onclick="StatusCuenta()"><i class="icon-mid bi bi-person me-2"></i> Mi Perfil</a></li>
                    <?php if($_SESSION['tipo']==1 || $_SESSION['tipo']==2 ){ ?>
                        <li><a class="dropdown-item" href="#" onclick="StatusEmpresa()"><i class="icon-mid bi bi-gear me-2"></i> Configuraciones</a></li>
                        <?php } ?>
                    <li> <hr class="dropdown-divider"> </li>
                    <li class="btn-exit-system"><a class="dropdown-item" href="#"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Cerrar Session</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="modal fade text-left" id="cuentaEmpresa" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
        role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Datos de contacto de empresa</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-12 col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-6">
                                    <label> NOMBRE EMPRESA:</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Nombre" class="form-control" id="nombre_emp" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>DIRECCIÓN: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Dirección" class="form-control" id="address_emp">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label> CELULAR 1:</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Celular" class="form-control" id="cel1_emp">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label> CORREO:</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Correo institucional" class="form-control" id="correo_emp">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>FACEBOOK:</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Link" class="form-control" id="face_emp" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>INSTAGRAM:</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Link" class="form-control" id="inst_emp" >
                                    </div>
                                </div>
                            </div>
                        </div>                          
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="btns_pagos">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button type="button" class="btn btn-primary ml-1 "  onclick="updateEmpresa()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Editar</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="cuentaModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
        role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Crear Usuario y permisos</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-12 col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <label>DNI: </label>
                                    <div class="form-group">
                                        <input type="number" placeholder="DNI" 
                                        class="form-control" id="dni_cc" onchange="validarDni()" max="8">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label> NOMBRES:</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Nombres" class="form-control" id="nombre_c" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>APELLIDOS: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Apellidos" class="form-control" id="apellido_c" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label> CELULAR:</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Celular" class="form-control" id="celular_c" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>CORREO: </label>
                                    <div class="form-group">
                                        <input type="email" placeholder="Correo" class="form-control" id="correo_c" required>
                                    </div>
                                </div>
                            </div>
                        </div>                          
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="btns_pagos">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button type="button" class="btn btn-primary ml-1 "  onclick="updateDatos()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>