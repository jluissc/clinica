<!-- 
1 PAGOS
2 GASTOS
3 CITAS
4 SERVICIOS
5 MATERIALES

 -->
<?php 
    require_once './controladores/homeControlador.php';
    $inst = new homeControlador();
?>
<section class="row">    
    <div class="col-12 col-lg-12">
        <?php if($_SESSION['tipo']==1 || $_SESSION['tipo']==2 ){ ?><!-- ADMIN o CAJERO -->
            <?php 
                $datos = $inst->dateQuantity();
            ?>            
            <h2>Resumen empresa</h2>
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
                                    <h6 class="text-muted font-semibold">Total Pacientes</h6>
                                    <h6 class="font-extrabold mb-0" id="cant-pacient">
                                        <?php 
                                            echo $datos['patients'];
                                        ?>
                                    </h6>
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
                                    <h6 class="text-muted font-semibold">Cita totales</h6>
                                    <h6 class="font-extrabold mb-0" id="cant-citas">
                                        <?php 
                                            echo $datos['appoints'];
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(in_array(1, $_SESSION['permisos'])){ ?>
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
                                    <h6 class="text-muted font-semibold">Entrada</h6>
                                    <h6 class="font-extrabold mb-0" id="pay-serv">
                                        <?php 
                                            echo 'S/. '.  ($datos['pay'] ? $datos['pay'] : 0);
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if(in_array(2, $_SESSION['permisos'])){ ?>    
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
                                    <h6 class="text-muted font-semibold">Salida</h6>
                                    <h6 class="font-extrabold mb-0" id="pay-gastos">
                                        <?php 
                                            echo 'S/. '.  ($datos['payOut'] ? $datos['payOut'] : 0);
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if(in_array(3, $_SESSION['permisos'])){ ?><!-- PERMISO DE CITAS -->
            <h3>Citas del dia</h3>
            <div class="row">
                <?php  echo $inst -> readAppointmentToday()?>
            </div>    
        <?php } ?>
        
        <?php  if($_SESSION['tipo']==4  ){ ?> <!-- SOLO PACIENTES -->
            <h2>Hola <?php echo $_SESSION['nombre'].' '.$_SESSION['apellido'] ?></h2>
            <section id="groups">
                <div class="row match-height">
                    <div class="col-12 mt-3 mb-1">
                        <h4 class="section-title text-uppercase" >Datos <a class="" style="text-decoration: underline; cursor: pointer" onclick="showDatos()" >Editar datos</a></h4>
                    </div>
                </div>
                <div class="row match-height">
                    <div class="col-12 text-center">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-content">
                                    <img class="card-img-top img-fluid" src="<?php echo SERVERURL ?>vistas/assets/images/samples/5.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">TALLA</h4>
                                        <!-- <p class="card-text">
                                            This card has supporting text below as a natural lead-in to additional
                                            content.</p> -->
                                            <h2>1.87 cm</h2>
                                        <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <img class="card-img-top img-fluid" src="<?php echo SERVERURL ?>vistas/assets/images/samples/6.png"
                                        alt="Card image cap" />
                                    <div class="card-body">
                                        <h4 class="card-title">PESO</h4>
                                        <!-- <p class="card-text">
                                            This card has supporting text below as a natural lead-in to additional
                                            content.
                                        </p> -->
                                        <h2>65.00 Kg</h2>
                                        <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <img class="card-img-top img-fluid" src="<?php echo SERVERURL ?>vistas/assets/images/samples/3.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">EDAD</h4>
                                        <!-- <p class="card-text">
                                            This card has supporting text below as a natural lead-in to additional
                                            content.
                                        </p> -->
                                        <h2>24 años</h2>
                                        <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <img class="card-img-top img-fluid" src="<?php echo SERVERURL ?>vistas/assets/images/samples/4.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">TIPO SANGRE</h4>
                                        <!-- <p class="card-text">
                                            This card has supporting text below as a natural lead-in to additional
                                            content.
                                        </p> -->
                                        <h2>O+</h2>
                                        <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <h3>Citas proximas</h3>
            <div class="row">
                <?php  echo $inst -> readAppointmentNexts()?>
            </div>  
        <?php } ?>
        
    </div>
    <!-- MODAL SHOW APPOINTMENT -->
    <div class="modal fade text-left" id="info" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel130" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content" id="show-appointm">
                <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="myModalLabel130">Detalle Cita  </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Tart lemon drops macaroon oat cake chocolate toffee chocolate
                    bar icing. Pudding jelly beans
                    carrot cake pastry gummies cheesecake lollipop. I love cookie
                    lollipop cake I love sweet
                    gummi bears cupcake dessert.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-info ml-1"
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Accept</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- MODAL DETALLES CITA -->
<div class="modal fade text-left" id="large3" tabindex="-1" role="dialog"
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
                            <div class="card">
                                <div class="form-group">
                                    <label for="descripDet">Detalle de la cita/tratamientos</label>
                                    <textarea type="text" class="form-control" placeholder="Detalle de la cita/tratamientos" id="descripDet" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="recetDet">Recetas / Tratamientos</label>
                                    <textarea type="number" class="form-control" placeholder="Recetas / Tratamientos" id="recetDet" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="otroDet">Otros detalles</label>
                                    <input type="text" class="form-control" placeholder="Otros detalles" id="otroDet">
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
                <button type="button" class="btn btn-primary ml-1 "  onclick="saveDetalle()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo SERVERURL ?>vistas/assets/js/home.js"></script>
 