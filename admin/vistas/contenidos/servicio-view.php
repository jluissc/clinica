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
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel17">Large Modal</h4>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form action="#">
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
                        
                    </form>
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
</script>