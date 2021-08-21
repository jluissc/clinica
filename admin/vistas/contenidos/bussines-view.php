<?php 
    require_once './controladores/bussinesControlador.php';
    $inst = new businessControlador();
    $datos = $inst -> showBusinnes_C();    
?>
<strong>Si desea cambiar datos, comuniquese con soporte por favor</strong>
<div class="row">
    <div class="col-12">
        <div class="card card-body">
            <h4 class="card-title text-center">Tienda Comercial "<?php echo $datos->neg_nombre; ?>"</h4>
            <form action="#">
                <div class="form-body">
                    <label>Descripcionx </label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value=" <?php echo $datos->neg_descripcion; ?> " readonly>
                                <small id="name" class="form-text text-muted">Descripcion del negocio</small>
                            </div>                                    
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" value=" <?php echo $datos->neg_dirección; ?> " readonly>
                                <small id="name" class="form-text text-muted">Direccion</small>
                            </div>                                    
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" value=" <?php echo $datos->neg_rubro; ?> " readonly>
                                <small id="name" class="form-text text-muted">Rubro</small>
                            </div>                                    
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control" value=" <?php echo $datos->neg_telefono; ?> " readonly>
                                <small id="name" class="form-text text-muted">Telefono</small>
                            </div>                                    
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control" value=" <?php echo $datos->neg_telefono; ?> " readonly>
                                <small id="name" class="form-text text-muted">Url Messenger</small>
                            </div>                                    
                        </div>                                
                    </div>                            
                </div>                        
            </form>
        </div>
    </div>
</div>
 