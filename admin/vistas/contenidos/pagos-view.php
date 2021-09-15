<?php if($_SESSION['tipo']==1 || in_array(3, $_SESSION['permisos']) ){  // ADMIN   
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?>
adas
<?php } else{ echo '<h2>Upps!!!.. nada que mostrar</h2>'; }?>