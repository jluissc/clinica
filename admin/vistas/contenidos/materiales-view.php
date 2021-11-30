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
                <table class="table table-striped" id="table1" style="width: 100%;"  >
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>DESCRIPCION</th>
                            <th>ACCIONES</th>
                            <th>Celulnes</th>
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
                    <h5 class="modal-title white" id="tituloModal"> Info Modal </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="dni_appoint" class="form-control font-bold" placeholder="DNI" onchange="leerDni(1)">
                        </div>                            
                    </div>

                    <div id="spinnerTemp"></div>

                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="name_appoint" class="form-control font-bold" placeholder="Nombres" autocomplete="false">
                        </div>   
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="last_appoint" class="form-control font-bold" placeholder="Apellidos" autocomplete="false">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="celphone_appoint" class="form-control font-bold" placeholder="Celular (Whatsapp)" autocomplete="false">
                        </div>                            
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="email_appoint" class="form-control font-bold" placeholder="Correo" autocomplete="false">
                        </div>                            
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <input type="text" id="addres_appoint" class="form-control font-bold" placeholder="Dirección" autocomplete="false">
                        </div>                            
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancelar</span>
                    </button>
                    <button type="button" class="btn btn-info ml-1" id="btnsss">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block" id="btn_titulo">Editar</span>
                    </button> -->
                </div>
            </div>
        </div>
    </div>
    
    <script src="<?php echo SERVERURL ?>vistas/assets/js/material.js"></script>
<?php 
    }else{
        echo '<h2>UPS!!!... PARECE QUE NO HAY NADA QUE MOSTRAR</h2>';
    }
?>