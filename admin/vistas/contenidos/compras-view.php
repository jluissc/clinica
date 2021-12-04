<?php if($_SESSION['tipo']==1 || in_array(2, $_SESSION['permisos']) ){  // ADMIN   
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?>
    <section class="section">
        <div class="card">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12">
                        <div class="card-body">
                            <button class="btn btn-outline-primary" onclick="modalCompras(0)">Nueva Compra</button>
                            <table class="table table-striped" id="tableCompras" with="100%">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Fecha</th>
                                        <th>Subtotal</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <!-- con ajax -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <div class="col-4">
                        <ul class="list-group" id="listPagos">
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade text-left" id="comprasModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel130" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="tituloModal"> Compras </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body"> 
                    <div class="form-group" id="selectMat">
                    </div> <br><br>
                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="name_mat" class="form-control font-bold" placeholder="Precio" autocomplete="false">
                        </div>   
                    </div><br><br>
                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="descr_mat" class="form-control font-bold" placeholder="Cantidad" autocomplete="false">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="btn_materiales">
                    <!-- BTN OPTIONS -->
                </div>
            </div>
        </div>
    </div>

<link rel="stylesheet" href="<?php echo SERVERURL ?>vistas/assets/vendors/choices.js/choices.min.css" />

<script src="<?php echo SERVERURL ?>vistas/assets/vendors/choices.js/choices.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/pages/form-element-select.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/compras.js"></script>

<?php } else{ echo '<h2>Upps!!!.. nada que mostrar</h2>'; }?>