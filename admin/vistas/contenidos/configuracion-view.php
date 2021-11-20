<?php if($_SESSION['tipo']==1){ ?><!-- ADMIN -->
    <section class="row">
        <div class="page-heading">
            <h3>CONFIGURACIÓN GENERAL DE CITAS, PERMISO, EMPRESA, </h3>
        </div>
        <div class="col-12 col-lg-12">
            <div class="row">
                <!-- Editar permisos de usuarios -->
                <div class="col-6 col-lg-6 col-md-6" >
                    <div class="card">
                        <div class="card-header">
                            <h4>Servicios</h4> <a class="" style="cursor:pointer" 
                                onclick="tipoModalServc(0)">Crear servicio</a>
                        </div>
                        <div class="row">
                            <div class="card-body">
                                <ul class="list-group" id="listServcsss">
                                    LISTA DE SERVICIOS
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-6 col-md-6" >
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Lista de Configuraciones</h4>
                            <!-- <a class="" style="cursor:pointer"  class="btn btn-outline-warning">
                                Crear Fechas de atención</a> -->
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <ul class="list-group" id="listarConfig">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-6 col-md-6" >
                    <div class="card">
                        <div class="card-header">
                            <h4>Permisos Colaboradores</h4> <a class="" style="cursor:pointer"  data-bs-toggle="modal" data-bs-target="#large2">Crear usuario</a>
                        </div>
                        <div class="row">
                            <div class="col-6 col-lg-6 col-md-6">
                                <div class="card-content pb-4" id="listaColabor">
                                
                                </div>
                            </div>
                            <div class="col-6 col-lg-6 col-md-6">
                                <h5>Seleccionar los permisos </h5>
                                <div class="card-content pb-4">
                                    <div class="card-body">
                                        <ul class="list-group" id="permisosUser">
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1"  type="checkbox" aria-label="..." disabled checked>
                                                PERMISOS
                                            </li>
                                        </ul>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                
               
            </div>
        </div>
    </section>

    <!-- crear servicio general -->
    <!-- modal-dialog modal-dialog-centered -->
    <div class="modal fade" id="servicGenr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Servicio General</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div class="form-group">
                        <label for="name_serv">Nombre servicio general</label>
                        <input type="text" class="form-control" placeholder="Ingrese nombre" id="name_serv">
                    </div>
                    <div class="form-group">
                        <label for="stat_serv">Estado</label>
                        <select name="" id="stat_serv">
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" id="btn_serv">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- SERVICIOS -->
    <div class="modal fade text-left" id="categModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl"
            role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Crear servicios</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                            <div class="col-4 col-lg-4 col-md-4">
                                <div class="card">
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="name_cat">Nombre del servicio</label>
                                        <input type="text" class="form-control" placeholder="Nombre del servicio" id="name_cat">
                                    </div>
                                    <div class="form-group">
                                        <label for="descrip_cat">Descripción del servicio</label>
                                        <input type="text" class="form-control" placeholder="Descripción del servicio (opcional)" id="descrip_cat">
                                    </div>
                                    <div class="form-group">
                                        <label for="precN_cat">Precio Normal</label>
                                        <input type="number" class="form-control" placeholder="Precio normal " id="precN_cat">
                                    </div>
                                    <div class="form-group">
                                        <label for="precO_cat">Precio Oferta</label>
                                        <input type="number" class="form-control" placeholder="Precio Oferta " id="precO_cat">
                                    </div>
                                    <div class="form-group">
                                        <label for="stat_cat">Estado</label>
                                        <select name="" id="stat_cat">
                                            <option value="0">Inactivo</option>
                                            <option value="1">Activo</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="prectiem_cat">Tiempo de atención</label>
                                        <input type="number" class="form-control" placeholder="Tiempo de atención" id="prectiem_cat" onchange="filtrarHours()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">POSIBLES HORAS DE ATENCIÓN</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- <p>
                                                Place checkboxes and radios within list group items and customize as needed
                                            </p> -->
                                            <ul class="list-group" id="listHoursDisp">
                                                
                                            </ul>

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">SELECCIONAR LOS TIPOS DE CITA DISPONIBLES</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            TIPO DE ATENCION
                                            <ul class="list-group" id="listaCitaCrudT">
                                                
                                            </ul>
                                            <br>
                                            DIAS DISPONIBLES
                                            <ul class="list-group" id="listDiasDisp">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer" id="btn_categ">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- DIAS TIPOS Y HORAS DE ATENCION -->
    <div class="modal fade text-left w-100" id="configDiasModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel16" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Configuracion de atención</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 " >
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">SELECCIONAR LOS DÍAS DE ATENCIÓN</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <ul class="list-group" id="listarDiasA">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        
                        
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 " >
                            <!-- <div class="row"> -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">SELECCIONAR LOS TIPOS DE CITA DISPONIBLES</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <ul class="list-group" id="listaCitaCrud">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                            <!-- </div> -->
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 " >
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">INGRESE EL RANGO DE TIEMPO</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nameConf">Nombre de la configuración</label>
                                            <input type="text" class="form-control" placeholder="Ingrese un nombre (opcional)" id="nameConf">
                                        </div>
                                        <div class="form-group">
                                            <label for="horaInicio">Hora Inicio</label>
                                            <input type="time" class="form-control" placeholder="Hora de inicio" id="horaInicio">
                                        </div>
                                        <div class="form-group">
                                            <label for="horaFin">Hora Fin</label>
                                            <input type="time" class="form-control" placeholder="Hora fin" id="horaFin">
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                        </div>
                        <div id="showBTNConfig">

                            <!-- <input type="button" class="btn btn-success" value="Guardar Config" id="btn_savConf"> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="btn_confgDias">
                    <!-- <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancelar</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1"
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button> -->
                </div>
            </div>
        </div>
    </div>



    <!-- PERMISOS USERS -->
    <div class="modal fade text-left" id="large2" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl"
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
                            <div class="col-6 col-lg-6 col-md-6">
                                <?php 
                                    include "./vistas/inc/form-user.php";  
                                ?>    
                                
                            </div>
                            <div class="col-6 col-lg-6 col-md-6">
                                <h5>Seleccionar los permisos </h5>
                                <div class="card-content pb-4">
                                    <div class="card-body">
                                        <ul class="list-group" id="permisoTemporal" >
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1"  type="checkbox" id="permi_1" onchange="selectPermis(1)"  > PAGOS
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1"  type="checkbox" id="permi_2" onchange="selectPermis(2)" > GASTOS
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1"  type="checkbox" id="permi_3" onchange="selectPermis(3)" > CITAS
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1"  type="checkbox" id="permi_4" onchange="selectPermis(4)" > SERVICIOS
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1"  type="checkbox" id="permi_5" onchange="selectPermis(5)" > MATERIALES
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1"  type="checkbox" id="permi_6" onchange="selectPermis(6)" > CLIENTES
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancelar</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 "  onclick="saveUsuario()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        #jjdjdj{
            cursor: pointer;
        }
        #jjdjdj:hover{
            background-color: #93d85e;
        }
    </style>
    <script src="<?php echo SERVERURL ?>vistas/assets/js/config.js"></script>
<?php } 

else{
    include "./vistas/contenidos/404-view.php"; 
}

?>