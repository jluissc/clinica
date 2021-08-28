<!-- <script type="text/javascript">
	let btn_salir = document.querySelector(".btn-exit-system");

	btn_salir.addEventListener("click", function(e){
		e.preventDefault();
		Swal.fire({
			title: '¿Deseas cerrar tu session ?',
			text: "La session se cerrara",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si',
			cancelButtonText: 'no'
		}).then((result) => {
			if (result.value) {
				let url =' <?php echo SERVERURL ?>ajax/loginAjax.php ';
				let token = ' <?php echo $inst -> encryption($_SESSION['token']) ?> ';
				let usuario = ' <?php echo $inst -> encryption($_SESSION['nombre']) ?> ';

				let datos = new FormData();
				datos.append("token" , token);
				datos.append("usuario" , usuario);

				fetch(url,{
					method:'POST',
					body:datos
				})
				.then((respuesta) => respuesta.json())
				.then((respuesta) => {
					return alertas_ajax(respuesta);
				});
			}
		});
	});
</script>  -->