<div class="col-12 mt-4">
	<h4 class="mb-0">Usuarios del Sistema</h4>
	<h5 class="text-muted mt-0 font-12">Puedes <span class="activeee">Agregar</span>, <span class="activeee">Editar</span> o <span class="activeee">Eliminar</span> a tus usuarios</code></h5>
</div>
<div class="row">
	<?php 
		require_once './controladores/usuarioControlador.php';
		$listaUser = new usuarioControlador();            
		echo $listaUser -> listar_user_C();
	?>

	
</div>

 

 <div id="editUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal"
                aria-hidden="true">×</button>
            </div>
            <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/userAjax.php" method="POST" data-form="update" autocomplete="off">

                <div class="modal-body">
                    <div class="card" id="datosUser">

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



<!-- <div class="row mt-4">
	<div class="col-md-6">
		<div class="card text-white bg-primary">
			<div class="card-header">
				<h4 class="mb-0 text-white">Card Title</h4>
			</div>
			<div class="card-body">
				<h3 class="card-title text-white">Special title treatment</h3>
				<p class="card-text">With supporting text below as a natural lead-in to
					additional
				content.</p>
				<a href="javascript:void(0)" class="btn btn-dark">Go somewhere</a>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card text-white bg-danger">
			<div class="card-header">
				<h4 class="mb-0 text-white">Card Title</h4>
			</div>
			<div class="card-body">
				<h3 class="card-title text-white">Special title treatment</h3>
				<p class="card-text">With supporting text below as a natural lead-in to
					additional
				content.</p>
				<a href="javascript:void(0)" class="btn btn-dark">Go somewhere</a>
			</div>
		</div>
	</div> 
</div>
<div class="row mt-4">
	<div class="col-md-6">
		<div class="card text-white bg-warning">
			<div class="card-header">
				<h4 class="mb-0 text-white">Card Title</h4>
			</div>
			<div class="card-body">
				<h3 class="card-title text-white">Special title treatment</h3>
				<p class="card-text">With supporting text below as a natural lead-in to
					additional
				content.</p>
				<a href="javascript:void(0)" class="btn btn-dark">Go somewhere</a>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card text-white bg-success">
			<div class="card-header">
				<h4 class="mb-0 text-white">Card Title</h4>
			</div>
			<div class="card-body">
				<h3 class="card-title text-white">Special title treatment</h3>
				<p class="card-text">With supporting text below as a natural lead-in to
					additional
				content.</p>
				<a href="javascript:void(0)" class="btn btn-dark">Go somewhere</a>
			</div>
		</div>
	</div>
</div> -->