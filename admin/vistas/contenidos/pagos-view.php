<?php if($_SESSION['tipo']==1 || in_array(7, $_SESSION['permisos']) ){  // ADMIN   
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?>

<div class="container">
    <div class="row text-center">
        <div class="col-6">
            <div class="card-body">
                <table class="table table-striped" id="tablepagos" with="100%">
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/pagos.js"></script>


<?php } else{ echo '<h2>Upps!!!.. nada que mostrar</h2>'; }?>