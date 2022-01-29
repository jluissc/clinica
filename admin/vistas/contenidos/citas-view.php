<?php 
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?> 
<section class="">    
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                aria-controls="home" aria-selected="true">Citas</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                aria-controls="profile" aria-selected="false">Crear Cita</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                aria-controls="contact" aria-selected="false">Historial</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- LISTAR CITAS -->
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <section class="section">
                <div class="card">                
                    <div class="card-header">
                        <h4>Lista de citas</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="tbl_tratam" style="width: 100%;"  >
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Dni</th>
                                    <!-- <th>Correo</th> -->
                                    <th>Celular</th> 
                                    <th>Servicio</th> 
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Monto</th>
                                    <th>Total</th>
                                    <th>Estado Pago</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="listAppointment" >                           
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>                            

        </div>
        <!-- CREAR CITA  -->
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="modal-body">
                <div id="alertaCita" class="text-center"></div>
                
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4" >
                        <?php 
                            if($_SESSION['tipo'] == 1 || in_array(3, $_SESSION['permisos']) ){
                                include "./vistas/inc/form-user.php"; 
                            }
                        ?>
                        <label>SELECCIONE SERVICIO: </label>
                        <fieldset class="form-group">
                            <select class="form-select" id="select-servc" onchange="cambioServicio(this.value)">
                                <option value="0">SIN SERVICIOS</option>
                            </select>
                        </fieldset>
                        <div id="categ_customer">
                        </div>
                        <div id="historialNew">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4" >
                        <!-- ************* -->
                        <div class="content">
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
                                    <div class="month-list"></div>
                                </div>
                            </div>
                        </div>
                        <!-- ************* -->
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 " id="limpiarCita" >
                        <div class="content">
                            <div class="card-content">
                                <div id="fechaCita" class="fecha-cita">

                                </div>
                                <div class="text-center tipo-cita" >
                                    <div class="row">
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group" id="tipocitaSelect">

                                        </div>

                                    </div>
                                </div>
                                <div id="spinner" class="text-center">
                                    
                                </div>
                                <div class="container btn-group" id="horasDisponibles" role="group" aria-label="Basic radio toggle button group">  
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary ml-1 "  onclick="validarCita()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    Guardar Reserva
                </button>
            </div>
            
        </div>
        <!-- HISTORIAL DE CITAS -->
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="row">
                <div class="col-8">
                <section class="section">
                <div class="card">
                <div class="card-header">
                    <h4>Historial de citas</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table2" style="width:100%">
                        <thead>
                            <tr>
                                <th class="col-sm-3">Nombres</th>
                                <th  class="col-sm-1">DNI</th>
                                <th  class="col-sm-1">Correo</th>
                                <th  class="col-sm-2">Celular</th> 
                                <th  class="col-sm-2">Cita Nombre</th> 
                                <!-- <th  class="col-sm-1">Cita Codigo</th>  -->
                                <th  class="col-sm-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="DDD">
                        </tbody>
                    </table>
                </div>
                </div>
                </section>
                </div>
                <div class="col-4">
                    <h3 class="text-center">Historial de un paciente</h3>
                    <section class="timeline">
                        <ul id="historialPacient">
                            <li>
                                <div>
                                    <time>FECHA ::</time> DESCRIPCIÓN 
                                </div>
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- data-bs-toggle="modal" data-bs-target="#info" -->
<div class="modal fade text-left" id="info" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel130" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="tituloModal"> Datos de transferencia </h5>
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
                <?php 
                    if($_SESSION['tipo']==4 || $_SESSION['tipo']==2 ){
                ?>
                <div>
                    <h5>Num. Cuenta : 1931903910931029301</h5>
                    <h5>CCI : 005459854145421212</h5>
                </div>
                <?php 
                  }
                ?>
                 <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="numbTrans" class="form-control font-bold" placeholder="Número de transacción" autocomplete="false">
                    </div>
                    
                </div>
                <!-- <div id="spinnerTemp"> -->
                    
                <!-- </div> -->
                <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="name_bank" class="form-control font-bold" placeholder="Nombre de banco" autocomplete="false">
                    </div>
                    
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="total_pay" class="form-control font-bold" placeholder="Monto transferido" autocomplete="false">
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
                    if($_SESSION['tipo']==4 || $_SESSION['tipo']==2 ){
                ?>
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <div id="estadoPay"> </div>
                
                <?php 
                    }elseif($_SESSION['tipo']==1){
                ?>
                <div class="form-check" id="validarTransfer">
                   
                </div>
                <?php 
                    }
                ?>
            </div>
        </div>
    </div>
</div>


<style>
    .timeline ul li {
        list-style-type: none;
        position: relative;
        width: 6px;
        margin: 0 auto;
        padding-top: 10px;
        background: #2be345;
    }

    .timeline ul li::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: inherit;
    }

    .timeline ul li div {
        position: relative;
        bottom: 0;
        width: 200px;
        padding: 1px;
        background: #5bf4cc;
    }

    .timeline ul li div::before {
        content: '';
        position: absolute;
        bottom: 7px;
        width: 0;
        height: 0;
        border-style: solid;
    }

    .timeline ul li:nth-child(odd) div {
        left: 45px;
    }

    .timeline ul li:nth-child(odd) div::before {
        left: -15px;
        border-width: 8px 16px 8px 0;
        border-color: transparent #5bf4cc transparent transparent;
    }

    .timeline ul li:nth-child(even) div {
        left: -230px;
    }

    .timeline ul li:nth-child(even) div::before {
        right: -15px;
        border-width: 8px 0 8px 16px;
        border-color: transparent transparent transparent #5bf4cc;
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/calendario.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/citas.js"></script>
