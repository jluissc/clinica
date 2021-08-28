<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Yugo</h3>
                <p class="text-subtitle text-muted">The default layout </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Layout Default</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
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
                        <h4 class="modal-title" id="myModalLabel17">Large Modal</h4>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <label>Email: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Nombre"
                                    class="form-control" id="nombre">
                            </div>
                            <label>Password: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Descripción"
                                    class="form-control"  id="descrip">
                            </div>
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
    <section class="section">
        <div class="card">
            <div class="card-header">
                Simple Datatable
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Prod/Serv</th>
                            <th>Descripción</th>
                            <th>Precio venta</th>
                            <th>Precio normal</th>
                            <th>Tipo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="listaServicios">

                       <!-- <tr>
                            <td>Graiden</td>
                            <td>vehicula.aliquet@semconsequat.co.uk</td>
                            <td>076 4820 8838</td>
                            <td>Offenburg</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                        </tr>-->
                        
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Simple Datatable
    listarServs()
    function listarServs(){
        console.log('kennnu');
        url = './ajax/servicioAjax.php'
        DATOS = new FormData()
        DATOS.append('listaS','listaS')
        fetch(url,{            
            method:'post',
            body : DATOS,
        })
        .then(r => r.json())
        .then(r => mostrarServicios(r))

    }

    function mostrarServicios(datos){
        tb = ''
        datos.forEach((servicio) =>{
            tb += `<tr>
                <td>${servicio.nombre}</td>
                <td>vehicula.aliquet@semconsequat.co.uk</td>
                <td>076 4820 8838</td>
                <td>Offenburg</td>
                <td>
                    <span class="badge bg-success">Active</span>
                </td>
                <td><button type="button" onclick="servicio_show(${servicio.id})" class="btn btn-outline-success" data-bs-toggle="modal"
            data-bs-target="#large">
            Editar</button>
            <button type="button"  onclick="servicio_delete(${servicio.id})" class="btn btn-outline-info">
            Eliminar</button>
            </tr>` 
        })
        document.getElementById('listaServicios').innerHTML = tb
    }
     function guardarServicio(){
        nombre = document.getElementById('nombre').value
        descrip = document.getElementById('descrip').value
        if(nombre != '' || descrip != ''){
            url = './ajax/servicioAjax.php'
            DATOS = new FormData()
            DATOS.append('nombre_r',nombre)
            DATOS.append('descrip_r',descrip)
            fetch(url,{            
                method:'post',
                body : DATOS,
            })
            .then(r => r.json())
            .then(r => {
                r == 0 ? console.log('error') : mostrarServicios(r)
            })
        }
        else
            console.log('vacio');
     }

    function servicio_show(idServicio){
        url = './ajax/servicioAjax.php'
        DATOS = new FormData()
        DATOS.append('idServ_Edit',idServicio)
        fetch(url,{            
            method:'post',
            body : DATOS,
        })
        .then(r => r.json())
        .then(r => {
            mostrarServicioId(r);
        })
    }

    function mostrarServicioId(dato){
        tb = `<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">EDITAR SERVICIO</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <label>Email: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Nombre"
                            class="form-control" id="nombre_e" value="${dato.nombre}">
                    </div>
                    <label>Password: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Descripción"
                            class="form-control"  id="descrip_e" value="${dato.descripcion}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="button" class="btn btn-primary ml-1"
                    data-bs-dismiss="modal" onclick="updateServicio(${dato.id})">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Guardar</span>
                </button>
            </div>`
        document.getElementById('showServc').innerHTML = tb
    }

    function updateServicio(idServ){
        nombre = document.getElementById('nombre_e').value
        descrip = document.getElementById('descrip_e').value
        url = './ajax/servicioAjax.php'
        DATOS = new FormData()
        DATOS.append('id',idServ)
        DATOS.append('nombre_e',nombre)
        DATOS.append('descrip_e',descrip)
        fetch(url,{            
            method:'post',
            body : DATOS,
        })
        .then(r => r.json())
        .then(r => {
            mostrarServicios(r);
        })
    }

    function servicio_delete(idServ){
        Swal.fire({
            title: '¿ELIMINAR?',
            text: "LOS DATOS SE BORRARAN DEFINITAMENTE",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'Cancelar'
            })
        .then((result) => {
            if (result.isConfirmed) {
                url = './ajax/servicioAjax.php'
                DATOS = new FormData()
                DATOS.append('id_d',idServ)
                fetch(url,{            
                    method:'post',
                    body : DATOS,
                })
                .then(r => r.json())
                .then(r => {
                    mostrarServicios(r);
                })
            }
        })
        /*url = './ajax/servicioAjax.php'
        DATOS = new FormData()
        DATOS.append('id_d',idServ)
        fetch(url,{            
            method:'post',
            body : DATOS,
        })
        .then(r => r.json())
        .then(r => {
            mostrarServicios(r);
        })*/
    }
</script>
