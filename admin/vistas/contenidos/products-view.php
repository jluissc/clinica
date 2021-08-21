<div id="productosss">
    <div class="row"> 
        <div class="col-12">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="card-title text-left">Nuestros Productos </h4>

                    <div class="table-responsive">
                        <div class="form-group">
                            <input type="button" name="newProduc" class="btn btn-success" value="Nuevo Producto" data-toggle="modal" data-target="#newProductos" @click="listarCategorias()">
                        </div>
                        <table id="multi_col_order" class="table table-striped table-bordered display no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                    <!-- <th>Estado</th> -->

                                </tr>
                            </thead>
                            <tbody id="listaProd">
                                <?php 
                                require_once './controladores/productsControlador.php';
                                $listaProducts = new productsControlador();            
                                echo $listaProducts -> lista_products_C();
                                ?>  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    



    <!-- **************************Modal agregar Producto************************** -->

    <div class="modal fade" id="newProductos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title te" id="myModalLabel">Nuevo Producto</h4>
                    <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">×</button>
                </div>

                <form class="form-neon FormularioAjax dropzone" action="<?php echo SERVERURL; ?>ajax/productsAjax.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                
                    <div class="modal-body">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title"><label for="producto_name_reg">Nombre</label></h4>
                                    
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="producto_name_reg" 
                                        id="categoria_name_edit" placeholder="Nombre Producto" >

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="card-title"><label for="producto_marca_reg">Marca</label></h4>
                                    
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="producto_marca_reg" 
                                        id="categoria_marca_edit" placeholder="Marca Producto" >

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="card-title"><label for="producto_modelo_reg">Modelo</label></h4>
                                    
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="producto_modelo_reg" 
                                        id="categoria_modelo_edit" placeholder="Modelo Producto" >

                                    </div>
                                </div>                                
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <h4 class="card-title">Precio</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="producto_price_reg" 
                                        id="" placeholder="Precio Producto" >

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="card-title">Descuento</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="producto_descuento_reg" 
                                        id="" placeholder="Descuento Producto" >

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="card-title">Fecha</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="producto_fecha_reg" 
                                        id="" placeholder="Fecha Vencimiento Descuento" >

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <h4 class="card-title">Stock</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="producto_stock_reg" 
                                        id="" placeholder="Stock Producto" >

                                    </div>
                                </div>
                            
                                <div class="col-md-4">
                                    <h4 class="card-title">Categoria</h4>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Categoria</label>
                                        </div>
                                        <select  class="custom-select" name="producto_cat_reg" id="categorias">

                                            <!-- *****************Se completa automaticamete las categorias***************** -->

                                        </select>
                                    </div>                           
                                </div>
                                <div class="col-md-6">
                                    <h4 class="card-title"><label for="producto_tags_reg">Tags</label></h4>
                                    
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="producto_tags_reg" 
                                        id="categoria_tags_edit" placeholder="Otras categorias que llevaria este producto" >

                                    </div>
                                </div>   
                                                        
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="card-title">Especificaciones del producto </h4>
                                    <div class="form-floating">
                                        <textarea class="form-control" rows="15" placeholder="Detalles del producto " name="especif" style="height: 100px"></textarea>
                                        <!-- <label for="floatingTextarea2">Comments</label> -->
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>       
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- *******************************Modal editar Producto******************************* -->

    <div class="modal fade" id="editProductos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">×</button>
                </div>
                <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productsAjax.php" method="POST" data-form="update" autocomplete="off">
                    <div class="modal-body">
                        <div class="card" id="datosProd">

                            <!-- se autocompleta con el productosControlador -->

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProductos_det" tabindex="-1" role="dialog"
                                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">×</button>
                </div>
                <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productsAjax.php" method="POST" data-form="update" autocomplete="off">

                    <div class="modal-body">
                        <div class="card" id="datosProd_det">
                            <!-- se autocompleta con el productosControlador -->

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

    <div class="modal fade" id="editProductos_fot" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">×</button>
                </div>
                <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productsAjax.php" method="POST" data-form="update" autocomplete="off">

                    <div class="modal-body">
                        <div class="card" id="datosProd_fotos">
                            
                            <!-- se autocompleta con el productosControlador -->

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
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script>
    const app = new Vue({
        el:"#productosss",
        //data empleada en la aplicación
        data() {
            return {
                idgg:0,
                url: "../ajax/productsAjax.php",
                categorias:[],
                total :0,
                idPedido:0,
                estado:0,
                mensaje: 'Hola como estas',
                
            }
        },

        //propiedades computadas (se guarda en cache, por lo que no se repite)
        computed: {
            revertirMensaje(){
                return this.mensaje.split('').reverse().join('');
            },
        },

        // los metodos realizan la operacion cada vez que se llaman.
        methods: {
            /* MOSTRAR LAS CATEGORIAS DISPONIBLES  */
            listarCategorias(){
                let datos = new FormData();
                datos.append('category','category');
                fetch(this.url,{
                    method : 'POST',
                    body : datos,
                })
                .then(respuesta => respuesta.json())
                .then(respuesta => {
                    let option = '';
                    respuesta.forEach( categ => option += `<option  value="${categ.id_cat}">${categ.cat_nombre}</option>`);
                    document.getElementById('categorias').innerHTML = option;
                })
            },


        }
    })
</script>