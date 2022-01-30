<?php if ($_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 5 || in_array(1, $_SESSION['permisos'])) {  // ADMIN   
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?>

    <section>
        <input type="button" value="Nuevo Pago" class="btn btn-outline-primary" onclick="modalPagos(0)">
        <br><br>
        <div class="row ">
            <div class="col-12 col-sm-12 col-lg-6">
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lista de usuarios</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered dt-responsive nowrap" id="tablepagos" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nombres</th>
                                        <th>DNI</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- con ajax -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 py-2">
                <ul class="list-group" id="listPagos">
                </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 py-2">
                <ul class="list-group" id="detallePago">
                </ul>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade text-left" id="pagosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel17">Crear Usuario y permisos</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <?php
                            include "./vistas/inc/form-user.php";
                            ?>
                            <div class="col-12 col-lg-6 col-md-6 form-group">
                                <label> Concepto de pago:</label>
                                <input type="text" placeholder="Concepto Pago" class="form-control" id="concetPay">
                            </div>
                            <div class="col-12 col-lg-6 col-md-6 form-group">
                                <label> Primer monto</label>
                                <input type="number" placeholder="Primer monto" class="form-control" id="firstPay">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="btns_pagos">
                        <?php if ($_SESSION['tipo'] != 5) { ?>
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <!-- <i class="bx bx-x d-block d-sm-none"></i> -->
                                <span class="">Cancelar</span>
                            </button>
                            <button type="button" class="btn btn-primary ml-1 " onclick="verificarPag()">
                                <!-- <i class="bx bx-check d-block d-sm-none"></i> -->
                                <span class="">Guardar</span>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <!-- <i class="bx bx-x d-block d-sm-none"></i> -->
                                <span class="">Cancelar</span>
                            </button>
                            <button type="button" class="btn btn-primary ml-1 " onclick="modoView()">
                                <!-- <i class="bx bx-check d-block d-sm-none"></i> -->
                                <span class="">Guardar</span>
                            </button>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo SERVERURL ?>vistas/assets/js/pagos.js"></script>


<?php } else {
    echo '<h2>Upps!!!.. nada que mostrar</h2>';
} ?>