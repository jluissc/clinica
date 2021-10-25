<script>
    // VARIABLES GLOBALES
    // const URL = '<?php echo SERVERURL ?>';

    function alertaToastify(mensaje, color = 'red', tiempo=1000){
        Toastify({
            text: mensaje,
            duration: tiempo,
            backgroundColor: color,
        }).showToast();
    }
    
</script>
<script src="<?php echo SERVERURL ?>vistas/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/bootstrap.bundle.min.js"></script>
    
<!-- <script src="<?php echo SERVERURL ?>vistas/assets/vendors/apexcharts/apexcharts.js"></script> -->
<script src="<?php echo SERVERURL ?>vistas/assets/js/pages/dashboard.js"></script>

<script src="<?php echo SERVERURL ?>vistas/assets/js/main.js"></script>


<script src="<?php echo SERVERURL ?>vistas/assets/vendors/toastify/toastify.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/pages/horizontal-layout.js"></script>
<script src="<?php echo SERVERURL ?>vistas/assets/js/config.js"></script>


