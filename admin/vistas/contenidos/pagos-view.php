<?php if($_SESSION['tipo']==1 || in_array(7, $_SESSION['permisos']) ){  // ADMIN   
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?>

<div class="container">
    <div class="row text-center">
        <div class="col-3">
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
                        <?php 
                            // echo $inst->reedListCustomers();
                        ?>                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-3">
            <ul class="list-group" id="listPagos">
                <!-- <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
                <li class="list-group-item">A fourth item</li>
                <li class="list-group-item">And a fifth one</li> -->
            </ul>
        </div>
        <div class="col-6">
            agregar un pago mas
            <input type="button" value="Pagar" class="btn btn-outline-primary"> <br> <br>
            <ul class="list-group" id="detallePago">
                <!-- <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
                <li class="list-group-item">A fourth item</li>
                <li class="list-group-item">And a fifth one</li> -->
            </ul>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/pagos.js"></script>


<?php } else{ echo '<h2>Upps!!!.. nada que mostrar</h2>'; }?>