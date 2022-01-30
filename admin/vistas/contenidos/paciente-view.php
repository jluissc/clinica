<?php
if ($_SESSION['tipo'] == 1 ||  $_SESSION['tipo'] == 5 || in_array(3, $_SESSION['permisos'])) {
    require_once './controladores/clientesControlador.php';
    $inst = new clienteControlador();
?>
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#info" onclick="cambioModal(1)">
        Nuevo paciente
    </button>
    <br>
    <br>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4>LISTA DE PACIENTES</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="table1" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>DNI</th>
                            <th>Email</th>
                            <th>Celular</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>

        <!--info theme Modal -->
        <div class="modal fade text-left" id="info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title white" id="tituloModal"> Info Modal </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        include "./vistas/inc/form-user.php";
                        ?>
                    </div>
                    <div class="modal-footer">
                        <?php if ($_SESSION['tipo'] != 5) { ?>
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <!-- <i class="bx bx-x d-block d-sm-none"></i> -->
                                <span class="">Cancelar</span>
                            </button>
                            <button type="button" class="btn btn-info ml-1" id="btnsss">
                                <!-- <i class="bx bx-check d-block d-sm-none"></i> -->
                                <span class="" id="btn_titulo">Editar</span>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <!-- <i class="bx bx-x d-block d-sm-none"></i> -->
                                <span class="">Cancelar</span>
                            </button>
                            <button type="button" class="btn btn-info ml-1" id="btnsss">
                                <!-- <i class="bx bx-check d-block d-sm-none"></i> -->
                                <span class="" onclick="modoView()">Editar</span>
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo SERVERURL ?>vistas/assets/js/clientes.js"></script>

<?php
} else {
    echo '<h2>UPS!!!... PARECE QUE NO HAY NADA QUE MOSTRAR</h2>';
}
?>