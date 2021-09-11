<?php if($_SESSION['tipo']==1){ ?><!-- ADMIN o CAJERO -->
<section class="row">
    <div class="page-heading">
        <h3>CONFIGURACIÓN GENERAL DE CITAS, PERMISO, EMPRESA, </h3>
    </div>
    <div class="col-12 col-lg-12">
        <div class="row">
            <hr>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 " >
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">SELECCIONAR LAS HORAS DE ATENCIÓN</h4>
                        </div>
                        <div class="card-content">
                            <div class="calendar" style="width: 100%;">
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
                    
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-3 " >
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">SELECCIONAR LAS HORAS DE ATENCIÓN</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- <p>
                                    Place checkboxes and radios within list group items and customize as needed
                                </p> -->
                                <ul class="list-group" id="listaHoraCrud">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-3 " >
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">SELECCIONAR LOS TIPOS DE CITA DISPONIBLES</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- <p>
                                    Place checkboxes and radios within list group items and customize as needed
                                </p> -->
                                <ul class="list-group" id="listaCitaCrud">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <hr>
            <!-- Editar permisos de usuarios -->
            <div class="col-6 col-lg-6 col-md-6" >
                <div class="card">
                    <div class="card-header">
                        <h4>Permisos Colaboradores</h4>
                    </div>
                    <div class="row">
                        <div class="col-6 col-lg-6 col-md-6">
                            <div class="card-content pb-4" id="listaColabor">
                            
                            </div>
                        </div>
                        <div class="col-6 col-lg-6 col-md-6">
                            <h5>Seleccionar los permisos </h5>
                            <ul class="list-group" id="permisosUser">
                                
                            </ul>
                        </div>

                    </div>
                    
                    
                </div>
            </div>
            <hr>
        </div>
    </div>
</section>

<!-- MODAL -->
<div class="modal fade text-left" id="large" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
        role="document">
        <div class="modal-content" id="showServc">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">CONFIGURACIÓN DE CITAS POR DÍA <div id="fechaSelec"></div></h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-6 col-lg-6 col-md-6 " >
                            <ul class="list-group" id="listaHoraAten">
                                    
                            </ul>
                        </div>
                        <div class="col-6 col-lg-6 col-md-6 " >
                            <ul class="list-group" id="listaTipoAtenc">
                                    
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">Cerrar
                </button>
                <!-- <button type="button" class="btn btn-primary ml-1"
                    onclick="guardarServicio()">Guardar
                </button> -->
            </div>
        </div>
    </div>
</div>
<script src=" <?php echo SERVERURL ?>vistas/assets/js/config.js"></script>
<?php } ?>