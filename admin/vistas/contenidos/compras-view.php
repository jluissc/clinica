<?php if($_SESSION['tipo']==1 || $_SESSION['tipo']==5 || in_array(2, $_SESSION['permisos']) ){  // ADMIN   
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?>
<button class="btn btn-outline-primary" onclick="modalCompras(0)">Nueva Compra</button>
    <br>
    <br>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4>LISTA DE COMPRAS</h4>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="tableCompras" with="100%">
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
                            <label for="prec_com">Precio</label>
                            <input type="number" id="prec_com" class="form-control font-bold" placeholder="Precio" autocomplete="false">
                        </div>   
                    </div>
                    <div class="form-group">
                        <div class="col-12">
                            <label for="prec_com">Cantidad  </label>
                            <input type="number" id="cant_com" class="form-control font-bold" placeholder="Cantidad" autocomplete="false">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="btn_compras">
                    <?php if($_SESSION['tipo'] != 5){?>
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <span class="">Cancelar</span>
                        </button>
                        <button type="button" class="btn btn-primary ml-1 "  onclick="verificarComp()">
                            <span class="">Guardar</span>
                        </button>
                <?php }else{ ?>
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <span class="">Cancelar</span>
                        </button>
                        <button type="button" class="btn btn-primary ml-1 "  onclick="modoView()">
                            <span class="">Guardar</span>
                        </button>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>

<link rel="stylesheet" href="<?php echo SERVERURL ?>vistas/assets/vendors/choices.js/choices.min.css" />

<script src="<?php echo SERVERURL ?>vistas/assets/vendors/choices.js/choices.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/pages/form-element-select.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/compras.js"></script>

<?php } else{ echo '<h2>Upps!!!.. nada que mostrar</h2>'; }?>