
<div class="me-1 mb-1 d-inline-block">
                                <!-- Button trigger for large size modal -->
    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
        data-bs-target="#large" onclick="cargarModalCita()">
        Agregar
    </button>
    
    <!--large size Modal -->
    <div class="modal fade text-left" id="large" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
            role="document">
            <div class="modal-content" id="showServc">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Crear Cita</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div id="alertaCita" class="text-center"></div>
                        <span class="badge bg-info text-dark"><a href="<?php echo SERVERURL.'pacientes/' ?>" target="_blank" >Registrar Nuevo Paciente</a></span>
                        
                        <?php 
                           include "./vistas/inc/form-user.php"; 
                        ?>
                        <div class="card-content">
                            <div class="calendar" style="background-color: wheat;">
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
                                <div class="calendar-footer">
                                    <div class="toggle">
                                        <span>Dark Mode</span>
                                        <div class="dark-mode-switch">
                                            <div class="dark-mode-switch-ident"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="month-list"></div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group" id="tipocitaSelect">
                                
                            </div>
                        </div>
                        <div class="container btn-group" id="horasDisponibles" role="group" aria-label="Basic radio toggle button group">  
                        
                        </div>
                        <label>SELECCIONE SERVICIO: </label>
                        <fieldset class="form-group">
                            <select class="form-select" id="select-servc">
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
                    <button type="button" class="btn btn-primary ml-1"
                        onclick="guardarServicio()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="row">
    <div class="col-12 col-lg-12">
        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon purple">
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Profile Lucho</h6>
                                <h6 class="font-extrabold mb-0">112.000</h6>
                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalCenter">
                                    Launch Modal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon blue">
                                    <i class="iconly-boldProfile"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Followers</h6>
                                <h6 class="font-extrabold mb-0">183.000</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon green">
                                    <i class="iconly-boldAdd-User"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Following</h6>
                                <h6 class="font-extrabold mb-0">80.000</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon red">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Saved Post</h6>
                                <h6 class="font-extrabold mb-0">112</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon red">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Saved Post</h6>
                                <h6 class="font-extrabold mb-0">112</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src=" <?php echo SERVERURL ?>vistas/assets/js/citas.js"></script>
