
<div class="me-1 mb-1 d-inline-block">
                                <!-- Button trigger for large size modal -->
    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
        data-bs-target="#large" onclick="cargarModalCita()">
        Agregar
    </button>
    <!--large size Modal -->
    <div class="modal fade text-left" id="large" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
            role="document">
            <div class="modal-content" id="showServc">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Crear Cita</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <span class="badge bg-info text-dark"><a href="<?php echo SERVERURL.'pacientes/' ?>" target="_blank" >Registrar Nuevo Paciente</a></span>
                        <br>
                        <br>
                        <div id="camposRelleno">

                        </div>
                        <div id="alertaCita" class="text-center">
                            
                        </div>
                        <div class="text-center">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group" id="tipocitaSelect">
                                
                            </div>
                        </div>
                        <?php 
                           include "./vistas/inc/form-user.php"; 
                        ?>
                        <label>SELECCIONE SERVICIO: </label>
                        <fieldset class="form-group">
                            <select class="form-select" id="select-servc" onchange="validarServicio()">
                            </select>
                        </fieldset>
                        <div id="horasServic"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancelar</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1"
                        onclick="guardarServicio()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="row">
    <div class="col-12 col-lg-12">
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
                                <h6 class="text-muted font-semibold">Profile Lucho</h6>
                                <h6 class="font-extrabold mb-0">112.000</h6>
                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalCenter">
                                    Launch Modal
                                </button>
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
                                <h6 class="text-muted font-semibold">Followers</h6>
                                <h6 class="font-extrabold mb-0">183.000</h6>
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
                                <div class="stats-icon green">
                                    <i class="iconly-boldAdd-User"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Following</h6>
                                <h6 class="font-extrabold mb-0">80.000</h6>
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
                                <div class="stats-icon red">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Saved Post</h6>
                                <h6 class="font-extrabold mb-0">112</h6>
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
                                <div class="stats-icon red">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Saved Post</h6>
                                <h6 class="font-extrabold mb-0">112</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- MODAL -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Vertically Centered
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Croissant jelly-o halvah chocolate sesame snaps. Brownie caramels candy
                    canes chocolate cake
                    marshmallow icing lollipop I love. Gummies macaroon donut caramels
                    biscuit topping danish.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" referrerpolicy="no-referrer"></script>
<script>

    idUser = 0
    document.getElementById('nombre').disabled = true
    document.getElementById('apellido').disabled = true
    document.getElementById('celular').disabled = true
    document.getElementById('correo').disabled = true
    
    horasAtencion = []

    function cargarModalCita(){
        url = '../ajax/citaAjax.php'
        DATOS = new FormData()
        DATOS.append('listaServ', 'listaServ')
        fetch(url,{
            method : 'post',
            body : DATOS
        })
        .then( r => r.json())
        .then( r => {
            mostrarListaServicios(r.listaServ)
            mostrarTipoCita(r.listaTipoCit)
        })
    }

    function mostrarTipoCita(lista){
        list = ''
        lista.forEach((tipo,index) => {
            list +=`<input type="radio" class="btn-check" name="tipoCitaUs" id="${tipo.nombre}" value="${tipo.id}" autocomplete="off">
                                <label class="btn btn-outline-primary" for="${tipo.nombre}">${tipo.nombre}</label>`
        });
        document.getElementById('tipocitaSelect').innerHTML = list
    }

    function mostrarListaServicios(lista){
        list = '<option value="0">SELECCIONE</option>'
        lista.forEach(servic => {
            list +=`<option value="${servic.id}">${servic.nombre}</option>`
        });
        document.getElementById('select-servc').innerHTML = list
    }


    function validarServicio(){
        idServ = document.getElementById('select-servc').value
        if(idServ != 0){
            horasServic = `<label>FECHA: </label>
                        <div class="form-group">
                            <input type="date" placeholder="Fecha" class="form-control" id="fecha" onchange="validarFecha()">
                        </div>
                        <div class="container btn-group" id="horasDisponibles" role="group" aria-label="Basic radio toggle button group">  
                            
                        </div>`
            document.getElementById('horasServic').innerHTML = horasServic
        }else{
            document.getElementById('horasServic').innerHTML = ''

        }
    }

    function validarDni(){
        dni = document.getElementById('dni').value
        // apiConsulta(dni)
        url = '../ajax/citaAjax.php'
        DATOS = new FormData()
        DATOS.append('dni', dni)
        fetch(url,{
            method : 'post',
            body : DATOS
        })
        .then( r => r.json())
        .then( r => {
            if(r != 0){
                document.getElementById('nombre').value = r.nombre
                document.getElementById('nombre').disabled = true
                document.getElementById('apellido').value = r.apellidos
                document.getElementById('apellido').disabled = true
                document.getElementById('celular').value = r.celular
                document.getElementById('celular').disabled = true
                document.getElementById('correo').value = r.correo
                document.getElementById('correo').disabled = true
                idUser = r.id 
            }else{
                idUser = 0
                document.getElementById('nombre').value = ''
                document.getElementById('apellido').value = ''
                document.getElementById('celular').value = ''
                document.getElementById('correo').value = ''
                alertaHTML('warning','Paciente nuevo, registrelo primero, en el link de arriba','alertaCita')
            }
        })
    }

    function guardarServicio(){
        horaAtenUsEstado = document.querySelector('input[name=horaAtenUs]:checked')
        tipoCitaUs = document.querySelector('input[name=tipoCitaUs]:checked')
        console.log();
        nombre = document.getElementById('nombre').value
        apellido = document.getElementById('apellido').value
        celular = document.getElementById('celular').value
        correo= document.getElementById('correo').value
        dni = document.getElementById('dni').value
        servic = document.getElementById('select-servc').value
        fecha = document.getElementById('fecha').value
        if(horaAtenUsEstado && nombre != '' && apellido != '' && dni.length== 8 ){
            url = '../ajax/citaAjax.php'
            DATOS = new FormData()
            if(idUser != 0){
                DATOS.append('idUser', idUser)
                DATOS.append('idServic', servic)
                DATOS.append('idHora', horaAtenUsEstado.value)
                DATOS.append('fechaf', fecha)
                DATOS.append('tipoCita', tipoCitaUs.value)
                fetch(url,{
                    method : 'post',
                    body : DATOS
                })
                .then( r => r.json())
                .then( r => {
                    if(r == 1){
                        document.getElementById('horasServic').innerHTML = ''
                        document.getElementById('select-servc').value = 0
                        document.getElementById('nombre').value = ''
                        document.getElementById('apellido').value = ''
                        document.getElementById('celular').value = ''
                        document.getElementById('correo').value = ''
                        document.getElementById('dni').value = ''
                        alertaHTML('success','Se guardo la cita correctamente','alertaCita')
                    }else{
                        alertaHTML('danger','Ocurrio algun error','alertaCita')

                    }
                })
            }            
        }else{
            alertaHTML('danger','Falta seleccionar la hora de cita!','alertaCita')
        }
    }

    function alertaHTML(tipo, mensaje, idAlerta){
        alerta = `<div class="alert alert-${tipo}" role="alert">
                ${mensaje}
            </div>`
        document.getElementById(`${idAlerta}`).innerHTML = alerta
        setTimeout(() => {
            document.getElementById(`${idAlerta}`).innerHTML = ''            
        }, 3000);
    }

    function apiConsulta(dni){

        url2 = `https://consulta.api-peru.com/api/dni/${dni}`
        
        fetch(url2)
        .then(response => response.json())
        .then(json => console.log(json))
        .catch(error => console.log('Authorization failed : ' + error.message));
    }

    function guardarUser(){
        nombre = document.getElementById('nombre').value
        apellido = document.getElementById('apellido').value
        dni = document.getElementById('dni').value
        url = '../ajax/citaAjax.php'
        DATOS = new FormData()
        DATOS.append('nombre', nombre)
        DATOS.append('apellido', apellido)
        DATOS.append('dni', dni)
        fetch(url,{
            method : 'post',
            body : DATOS
        })
        .then( r => r.json())
    }

    function validarFecha(){
        leerHorasAtencion()
        fecha = document.getElementById('fecha').value
        url = '../ajax/citaAjax.php'
        DATOS = new FormData()
        DATOS.append('fecha', fecha)
        fetch(url,{
            method : 'post',
            body : DATOS
        })
        .then( r => r.json())
        .then( r => {
            if(r.length > 0)
                filtrarHoraAtencion(r)
            else{
                filtrarHoraAtencion([])
                // alertaHTML('warning','Horas no disponibles, escoge otra fecha por favor','alertaCita')
                // document.getElementById('horasDisponibles').innerHTML = ''
            }
        })
    }

    function filtrarHoraAtencion(horaOcupadas=[]){
        horasOcupad = []
        horaOcupadas.forEach(horaO => {
            horasOcupad = [parseInt(horaO.horas_id), ...horasOcupad]
        });
        tb = '<div class="row text-center ">'
        horasAtencion.forEach((hora, index) => {
            if(hora.estado == 1){
                // if(horasOcupad == []){
                //     tb +=`<div class="col-4">

                //             <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hora.id}" autocomplete="off" >
                //             <label class="btn btn-outline-primary" for="${index}">${hora.hora}</label></div>
                //             `
                // }else{
                    if(!horasOcupad.includes(parseInt(hora.id))){
                        tb +=`<div class="col-4">

                            <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hora.id}" autocomplete="off" >
                            <label class="btn btn-outline-primary" for="${index}">${hora.hora}</label></div>
                            `
                    }
                // }
                               
            }
        });
        tb += '</div>'
        document.getElementById('horasDisponibles').innerHTML = tb
    }
    
    function leerHorasAtencion(){
        url = '../ajax/configAjax.php'
        DATOS = new FormData()
        DATOS.append('horaAten', 'horaAten')
        fetch(url,{
            method : 'post',
            body : DATOS
        })
        .then( r => r.json())
        .then( r => {
            horasAtencion = r
        })
    }
</script>

<script>
    const cronometro = tiempo_final => {
        let now = new Date(),
            remainTime = (new Date(tiempo_final) - now + 1000) / 1000,
            remainSeconds = ('0' + Math.floor(remainTime % 60)).slice(-2),
            remainMinutes = ('0' + Math.floor(remainTime / 60 % 60)).slice(-2),
            remainHours = ('0' + Math.floor(remainTime / 3660 % 24)).slice(-2);
        
        return {
            remainTime,
            remainSeconds,
            remainMinutes,
            remainHours,
        }

    }

    function countDown (tiempo_final, elemt,  finallMensaje)  {
        el = document.getElementById(elemt)
        const timerUpdate = setInterval(() => {
            t = cronometro(tiempo_final)
            console.log(t.remainHours,t.remainMinutes,t.remainSeconds);
            if(t.remainTime <= 1){
                clearInterval(timerUpdate)
                location.reload();
            }   
        }, 1000);
        
    }
</script>