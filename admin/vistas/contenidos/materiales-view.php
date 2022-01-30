<?php 
    if($_SESSION['tipo']==1 || $_SESSION['tipo'] == 5 || in_array(5, $_SESSION['permisos']) ){
        require_once './controladores/clientesControlador.php';
        $inst = new clienteControlador();
?>
    <button type="button" class="btn btn-outline-success" onclick="cambModalMat(1, 0)" >
        Nuevo Material
    </button>
    <br>
    <br>
    <section class="section">
        <div class="card">
            <div class="card-header">
            <h4>LISTA DE MATERIALES</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="tableMateriales" style="width: 100%;"  >
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>DESCRIPCION</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody >                        
                        <?php 
                            // echo $inst->reedListCustomers();
                        ?>                        
                    </tbody>
                </table>
            </div>
        </div> 
    </section>

    <!-- Modal -->
    <div class="modal fade text-left" id="materialModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel130" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="tituloModal"> Material </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body"> 
                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="name_mat" class="form-control font-bold" placeholder="Nombre material" autocomplete="false">
                        </div>   
                    </div>
                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="descr_mat" class="form-control font-bold" placeholder="Descripción material" autocomplete="false">
                        </div>
                    </div>
                </div>
                <?php if($_SESSION['tipo'] != 5) {?>
                    <div class="modal-footer" id="btn_materiales">
                        <!-- BTN OPTIONS -->
                    </div>
                <?php }else{ ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <!-- <i class="bx bx-x d-block d-sm-none"></i> -->
                            <span class="">Cancelar</span>
                        </button>
                        <button type="button" class="btn btn-primary ml-1 "  onclick="modoView()">
                            <!-- <i class="bx bx-check d-block d-sm-none"></i> -->
                            <span class="">Guardar</span>
                        </button>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> -->
    <script src="<?php echo SERVERURL ?>vistas/assets/js/material.js"></script>
<?php 
    }else{
        echo '<h2>UPS!!!... PARECE QUE NO HAY NADA QUE MOSTRAR</h2>';
    }
?>