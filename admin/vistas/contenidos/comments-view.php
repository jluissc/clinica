<div class="row"> 
    <div class="col-12">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-left">Comentarios Productos</h4>
                    <div class="table-responsive">
                       <!--  <div class="form-group">
                            <input type="button" name="newProduc" class="btn btn-success" value="Nuevo Producto" data-toggle="modal" data-target="#newProductos" onclick="traerDatos(10001)">
                        </div> -->
                        <table id="multi_col_order"
                        class="table table-striped table-bordered display no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Producto</th>
                                <th>Comentario</th>
                                <th>Acciones</th>
                                <!-- <th>Estado</th> -->

                            </tr>
                        </thead>
                        <tbody id="listaProd">


                            <?php 
                            require_once './controladores/commentsControlador.php';
                            $listaProducts = new commentsControlador();            
                            echo $listaProducts -> c_comentariosProductos();
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


 