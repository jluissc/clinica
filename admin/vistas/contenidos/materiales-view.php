<?php 
    if($_SESSION['tipo']==1 || in_array(5, $_SESSION['permisos']) ){
        require_once './controladores/clientesControlador.php';
        $inst = new clienteControlador();
?>
    <button type="button" class="btn btn-outline-success" onclick="cambModalMat(1, 0)" >
        Nuevo Material
    </button>
    <br>
    <br>
    <h4 class="modal-title" id="myModalLabel17">LISTA DE MATERIALES</h4>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <!-- Simple Datatable -->
            </div>
            <div class="card-body">
                <table class="table table-striped" id="tableMateriales" style="width: 100%;"  >
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
                <div class="modal-footer" id="btn_materiales">
                    <!-- BTN OPTIONS -->
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
    <script src="<?php echo SERVERURL ?>vistas/assets/js/material.js"></script>
<?php 
    }else{
        echo '<h2>UPS!!!... PARECE QUE NO HAY NADA QUE MOSTRAR</h2>';
    }
?>