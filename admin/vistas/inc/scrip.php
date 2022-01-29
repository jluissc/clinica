<script>
    // VARIABLES GLOBALES
    const URL = '<?php echo SERVERURL ?>';
    const tipoUsuario = '<?php echo $_SESSION['tipo'] ?>';
    
    //alerta general 
    function alertaToastify(mensaje, color = 'red', tiempo=1000){
        Toastify({
            text: mensaje,
            duration: tiempo,
            backgroundColor: color,
        }).showToast();
    }

    function modoView(){
        Toastify({
            text: 'Modo Vista',
            duration: 1000,
            backgroundColor: 'red',
        }).showToast();
    }
    
</script>
<script src="<?php echo SERVERURL ?>vistas/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/bootstrap.bundle.min.js"></script>
