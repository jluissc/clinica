<!-- 
1 PAGOS
2 GASTOS
3 CITAS
4 SERVICIOS
5 MATERIALES

 -->
<?php 
    require_once './controladores/homeControlador.php';
    $inst = new homeControlador();
    // echo $inst -> iniciar_sesion_C();
?>
<section class="row">
    <!-- <?php echo var_dump($_SESSION['permisos']) ?> -->
    <div class="col-12 col-lg-12">
        <?php if($_SESSION['tipo']==1 || $_SESSION['tipo']==2 ){ ?><!-- ADMIN o CAJERO -->
            <?php 
                $datos = $inst->dateQuantity();
            ?>
            
            <h2>Resumen empresa</h2>
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total Pacientes</h6>
                                    <h6 class="font-extrabold mb-0" id="cant-pacient">
                                        <?php 
                                            echo $datos['patients'];
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Cita totales</h6>
                                    <h6 class="font-extrabold mb-0" id="cant-citas">
                                        <?php 
                                            echo $datos['appoints'];
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(in_array(1, $_SESSION['permisos'])){ ?>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Entrada</h6>
                                    <h6 class="font-extrabold mb-0" id="pay-serv">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if(in_array(2, $_SESSION['permisos'])){ ?>    
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Salida</h6>
                                    <h6 class="font-extrabold mb-0" id="pay-gastos">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if(in_array(3, $_SESSION['permisos'])){ ?><!-- PERMISO DE CITAS -->
            <h3>Citas del dia</h3>
            <div class="row">
                <?php  echo $inst -> readAppointmentToday()?>
            </div>    
        <?php } ?>
        
        <?php  if($_SESSION['tipo']==4  ){ ?> SOLO PACIENTES
            <h2>Hola <?php echo $_SESSION['nombre'].' '.$_SESSION['apellido'] ?></h2>
            <h3>Citas proximas</h3>
            <div class="row">
                <?php  echo $inst -> readAppointmentNexts()?>
            </div>  
        <?php } ?>
        
    </div>
    <!-- MODAL SHOW APPOINTMENT -->
    <div class="modal fade text-left" id="info" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel130" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content" id="show-appointm">
                <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="myModalLabel130">Detalle Cita  </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Tart lemon drops macaroon oat cake chocolate toffee chocolate
                    bar icing. Pudding jelly beans
                    carrot cake pastry gummies cheesecake lollipop. I love cookie
                    lollipop cake I love sweet
                    gummi bears cupcake dessert.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-info ml-1"
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Accept</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    const urlPrincipal = '<?php echo SERVERURL?>';
    // var el = document.getElementById("showDetailAppoint");   
    // el.addEventListener("click", modifyText);   

    // function modifyText(){
    //     console.log('diste click pendejo');        
    // }

    function showDetailAppoint(idAppoint){
        url = urlPrincipal+'ajax/homeAjax.php'
        // let datos = {
        //     idAppoint : idAppoint,
        //     url : url,
        // }
        data = new FormData()
        data.append('idAppoint' , idAppoint)

        fetch(url, {
            method : 'POST',
            body : data
        })
        .then( result => result.json())
        .then( result => appointmentHTML(result))
    }

    function appointmentHTML(appointDate){
        console.log(appointDate);
        statusMessage = !!appointDate.mensaje ? 'Mensaje' : 'Mandarle un mensaje'
        message = !!appointDate.mensaje ? appointDate.mensaje : ''
        html = `<div class="modal-header bg-info">
                <h5 class="modal-title white" id="myModalLabel130">${appointDate.nombre} ${appointDate.apellidos}</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <h6>${statusMessage}</h6>
                    <input class="form-control" type="text" placeholder="Enviarle un mensaje " value="${message}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button type="button" class="btn btn-info ml-1"
                    data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Enviarle</span>
                </button>
            </div>`
        document.getElementById('show-appointm').innerHTML = html
    }


</script>