<ul>
    <!-- <li> -->
        <a class="nav-link" href="javascript:void(0)">
            <form>
                <div class="customize-input">
                    <input class="form-control custom-shadow custom-radius border-0 bg-white" type="search" placeholder="Buscar alguna categoria" aria-label="Search">
                </div>                
            </form>
        </a>
    <!-- </li> -->
</ul>
<div class="row">
    <div class="col-12 mt-4">
        <h4 class="mb-0">Todas las categorias disponibles</h4>
        <br>
        <!-- <p class="text-muted mt-0 font-12">Yosu can quickly change the text alignment<code>.text-center .text-right</code>.</p> -->
    </div>
    <?php 
        require_once './controladores/categoryControlador.php';
        $listaCategory = new categoryControlador();            
        echo $listaCategory -> lista_category_C();
    ?> 
</div> 
 
 

<!-- **************************Modal agregar Categoria************************** -->
<div id="newCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Nueva Categoria</h4>
                <button type="button" class="close" data-dismiss="modal"
                aria-hidden="true">×</button>
            </div>
            <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/categoryAjax.php" method="POST" data-form="save" autocomplete="off">

                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Nombre Categoria</h4>                                                       
                            <div class="form-group">
                                <input type="text" class="form-control" name="categoria_name_reg" aria-describedby="name"
                                placeholder="Nombre Categoria">

                            </div>
                            <br>

                           <!--  <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="rr" name="rr">
                                <label class="custom-control-label" for="rr">Estado Categoria</label>
                            </div> -->



                        <!--  </div>

                       <div class="card-body"> -->

                            <h4 class="card-title">Estado Categoria</h4>
                            <div class="input-group mb-3">  
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" checked class="custom-control-input" id="rr" name="rr">
                                    <label class="custom-control-label" for="rr"></label>
                                </div>
                            </div>
                                
                                <!-- <select class="custom-select" name="categoria_status_reg">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select> -->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Categoria</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!-- *******************************Modal editar Categoria******************************* -->
<div id="editCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Categoria</h4>
                <button type="button" class="close" data-dismiss="modal"
                aria-hidden="true">×</button>
            </div>
            <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/categoryAjax.php" method="POST" data-form="update" autocomplete="off">

                <div class="modal-body">
                    <div class="card" id="datosCat">
                        <!-- se autocompleta con el CategoryControlador -->
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

