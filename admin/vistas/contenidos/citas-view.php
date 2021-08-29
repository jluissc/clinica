
<div class="me-1 mb-1 d-inline-block">
                                <!-- Button trigger for large size modal -->
    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
        data-bs-target="#large">
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
                        <div id="camposRelleno">

                        </div>
                        <label>DNI: </label>
                        <div class="form-group">
                            <input type="number" placeholder="DNI" 
                            class="form-control" id="dni" onchange="validarDni()" max="8">
                        </div>

                        <label> NOMBRES:</label>
                        <div class="form-group">
                            <input type="text" placeholder="Nombres" class="form-control" id="nombre" >
                        </div>
                        <label>APELLIDOS: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Apellidos" class="form-control" id="apellido" >
                        </div>
                        <label>FECHA: </label>
                        <div class="form-group">
                            <input type="date" placeholder="Fecha" class="form-control" id="fecha" onchange="validarFecha()">
                        </div>
                        <!-- <label>HORA </label>
                        <div class="form-group">
                            <input type="text" placeholder="Apellidos" class="form-control" id="apellido" >
                        </div> -->

                        <!-- ********************* -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1"
                        data-bs-dismiss="modal" onclick="guardarServicio()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="row">
    <div class="col-12 col-lg-9">
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

    idUser = 0;
    function validarDni(){
        dni = document.getElementById('dni').value
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

                document.getElementById('camposRelleno').innerHTML = ''
                document.getElementById('nombre').value = r.nombre
                document.getElementById('apellido').value = r.apellidos
                idUser = r
                console.log(idUser);
            }else{
                div = ` 
                    <button class="btn btn-success" onclick="guardarUser()" >Salvar Usuario </button>
                        `
                document.getElementById('camposRelleno').innerHTML = div
                document.getElementById('nombre').value = ''
                document.getElementById('apellido').value = ''
            }
        })
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

        fecha = document.getElementById('fecha').value
        console.log(fecha);
        url = '../ajax/citaAjax.php'
        DATOS = new FormData()
        DATOS.append('fecha', fecha)
        fetch(url,{
            method : 'post',
            body : DATOS
        })
        .then( r => r.json())
        .then( r => {
            console.log(r);

            // if(r != 0){
            //     console.log(idUser);
            // }else{
            //     div = `
            // }
        })
    }
</script>
