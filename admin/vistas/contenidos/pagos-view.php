<?php if($_SESSION['tipo']==1 || in_array(7, $_SESSION['permisos']) ){  // ADMIN   
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?>

<input type="button" value="Nuevo Pago" class="btn btn-outline-primary" onclick="modalPagos(0)">
        <br><br>
    <div class="container">
        <div class="row ">
            <div class="col-6">
            <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4>Lista de usuarios</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tablepagos" style="width: 100%;" >
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>DNI</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody >
                            <!-- con ajax -->
                        </tbody>
                    </table>
                </div>
                </div>
            </section> 
            </div>
            <div class="col-3">
                <ul class="list-group" id="listPagos">
                </ul>
            </div>
            <div class="col-3">
                <ul class="list-group" id="detallePago">
                </ul>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade text-left" id="pagosModal" tabindex="-1" role="dialog"
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
                                <label> Concepto de pago:</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Concepto Pago" class="form-control" id="concetPay" >
                                </div>
                                <label> Primer monto</label>
                                <div class="form-group">
                                    <input type="number" placeholder="Primer monto" class="form-control" id="firstPay" >
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
                    <button type="button" class="btn btn-primary ml-1 "  onclick="verificarPag()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/pagos.js"></script>


<?php } else{ echo '<h2>Upps!!!.. nada que mostrar</h2>'; }?> 