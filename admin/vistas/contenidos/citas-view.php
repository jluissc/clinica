<?php 
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?>
<section class="row">    
    <div class="me-1 mb-1 d-inline-block">
        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
            data-bs-target="#large" >
            Buscar Cita 
        </button>

        <div class="modal fade text-left" id="large" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                role="document">
                <div class="modal-content" id="showServc">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel17">Crear Cita</h4>
                        <?php 
                            if($_SESSION['tipo']==1 || in_array(3, $_SESSION['permisos']) ){
                        ?>

                            <span class="badge bg-info text-dark"><a href="<?php echo SERVERURL.'clientes/' ?>" target="_blank" >Registrar Nuevo Paciente</a></span>
                        <?php 
                            }
                        ?>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div id="alertaCita" class="text-center"></div>
                            
                            
                            <?php 
                            include "./vistas/inc/form-user.php"; 
                            ?>
                            <div class="content">
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-12 " >
                                        <div class="card-content">
                                            <div class="calendar" >
                                                <div class="calendar-header">
                                                    <span class="month-picker" id="month-picker">February</span>
                                                    <div class="year-picker">
                                                        <span class="year-change" id="prev-year">
                                                            <pre><</pre>
                                                        </span>
                                                        <span id="year">2021</span>
                                                        <span class="year-change" id="next-year">
                                                            <pre>></pre>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="calendar-body">
                                                    <div class="calendar-week-day">
                                                        <div>Dom</div>
                                                        <div>Lun</div>
                                                        <div>Mar</div>
                                                        <div>Mie</div>
                                                        <div>Jue</div>
                                                        <div>Vie</div>
                                                        <div>Sab</div>
                                                    </div>
                                                    <div class="calendar-days"></div>
                                                </div>
                                                <!-- <div class="calendar-footer">
                                                    <div class="toggle">
                                                        <span>Dark Mode</span>
                                                        <div class="dark-mode-switch">
                                                            <div class="dark-mode-switch-ident"></div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="month-list"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-12 " id="limpiarCita" >
                                        <div id="fechaCita" class="fecha-cita">

                                        </div>
                                        <div class="text-center tipo-cita" >
                                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group" id="tipocitaSelect">
                                                
                                            </div>
                                        </div>
                                        <div id="spinner" class="text-center">
                                            
                                        </div>
                                        <div class="container btn-group" id="horasDisponibles" role="group" aria-label="Basic radio toggle button group">  
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <label>SELECCIONE SERVICIO: </label>
                            <fieldset class="form-group">
                                <select class="form-select" id="select-servc">
                                    <option value="0">SIN SERVICIOS</option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Cancelar</span>
                        </button>
                        <button type="button" class="btn btn-primary ml-1 "  onclick="validarCita()">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Guardar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *********** -->
    <div class="card">
        <?php if($_SESSION['tipo']==1 || in_array(3, $_SESSION['permisos']) ){ ?><!-- ADMIN o CAJERO -->
            <div class="card-header">
                <h4>Historial de citas</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <!-- <th>Servicio</th> -->
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="listAppointment"  data-typeUser="false">
                        
                        <?php 
                            echo $inst->reedListAppointment()
                        
                        ?>
                        
                        
                    </tbody>
                </table>
            </div>
        <?php } ?><!-- ADMIN o CAJERO -->
        <?php if($_SESSION['tipo']==4 ){ ?> <!-- PACIENTES -->
            <div class="card-header">
                <h4>Mi Historial de citas</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Correo</th>
                            <th>Celular</th> 
                            <!-- <th>Servicio</th> -->
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="listAppointment" data-typeUser="true">
                        <?php 
                            echo $inst->reedListAppointment(true)
                        
                        ?>

                        
                        
                    </tbody>
                </table>
            </div>
        <?php } ?>PACIENTES
    </div>
</section>
<!-- data-bs-toggle="modal" data-bs-target="#info" -->
<div class="modal fade text-left" id="info" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel130" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="tituloModal"> Info Modal </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- 
                    detalles
                    numero operacion
                    banco
                    total
                -->
                <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="numb_pay" class="form-control font-bold" placeholder="Numero de operación">
                    </div>
                    
                </div>
                <!-- <div id="spinnerTemp"> -->
                    
                <!-- </div> -->
                <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="name_appoint" class="form-control font-bold" placeholder="Nombre de banco" autocomplete="false">
                    </div>
                    
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="last_appoint" class="form-control font-bold" placeholder="Monto transferido" autocomplete="false">
                    </div>
                </div>
                <!-- <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="celphone_appoint" class="form-control font-bold" placeholder="Nombres (opcional)" autocomplete="false">
                    </div>
                    
                </div> -->
            </div>
            <div class="modal-footer">
                <?php 
                    if($_SESSION['tipo']==4){
                ?>
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <div id="estadoPay">
                    <!-- <button type="button" class="btn btn-info ml-1" onclick="mandarDatosPago()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Mandar Datos</span>
                    </button> -->
                </div>
                
                <?php 
                    }elseif($_SESSION['tipo']==1){
                ?>
                check de validar
                <?php 
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script src=" <?php echo SERVERURL ?>vistas/assets/js/citas.js"></script>