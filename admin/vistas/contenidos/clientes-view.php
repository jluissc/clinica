<?php 
    if($_SESSION['tipo']==1 || in_array(3, $_SESSION['permisos']) ){
        require_once './controladores/clientesControlador.php';
        $inst = new clienteControlador();
?>
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#info" onclick="cambioModal(1)" >
        Nuevo Cliente
    </button>
    <br>
    <br>
    <h4 class="modal-title" id="myModalLabel17">LISTA DE CLIENTES</h4>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <!-- Simple Datatable -->
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1" style="width: 100%;"  >
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>DNI</th>
                            <th>Email</th>
                            <th>Celular</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody >
                        
                        <?php 
                            // echo $inst->reedListCustomers();
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div> 

        <!--info theme Modal -->
        <div class="modal fade text-left" id="info" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel130" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title white" id="tituloModal"> Info Modal </h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-12">
                                <input type="text" id="dni_appoint" class="form-control font-bold" placeholder="DNI" onchange="leerDni(1)">
                            </div>
                            
                        </div>
                        <div id="spinnerTemp">
                            
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <input type="text" id="name_appoint" class="form-control font-bold" placeholder="Nombres" autocomplete="false">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <input type="text" id="last_appoint" class="form-control font-bold" placeholder="Apellidos" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <input type="text" id="celphone_appoint" class="form-control font-bold" placeholder="Celular (Whatsapp)" autocomplete="false">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <input type="text" id="email_appoint" class="form-control font-bold" placeholder="Correo" autocomplete="false">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <input type="text" id="addres_appoint" class="form-control font-bold" placeholder="Dirección" autocomplete="false">
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Cancelar</span>
                        </button>
                        <button type="button" class="btn btn-info ml-1" id="btnsss">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block" id="btn_titulo">Editar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        const url= '<?php echo SERVERURL?>'+'ajax/clienteAjax.php';
        leerListaTratamientos()
        function leerListaTratamientos(){
            console.log('jjjjjjjjjjjjjjj');
            tablaUsuarios2 = $('#table1').DataTable({  
                "ajax":{            
                    "url": url, 
                    "method": 'POST', //usamos el metodo POST
                    "data":{listsCustomers:'listsCustomers'}, //enviamos opcion 4 para que haga un SELECT
                    "dataSrc":""
                },
                
                "columns":[
                    {"data": "nombre"},
                    {"data": "dni"},
                    {"data": "correo"},
                    {"data": "celular"},
                    {"data": "acciones"},
                ]
            });     
        }
        
        function showCustomer(idCustomer,estadoModal){ /* idCustomer = idPaciente, tipo =(1 new paciente, 2 update paciente) */
            datos = new FormData()
            datos.append('idCustomer',idCustomer)
            fetch(url,{
                method : 'POST',
                body : datos,
            })
            .then(r => r.json())
            .then(r => cambioModal(estadoModal, r,idCustomer))            
        }

        function cambioModal(estadoModal = 0,datos,idCustomer = 0){
            document.getElementById('tituloModal').innerHTML = estadoModal == 1 ? 'Nuevo Paciente' : 'Editar Paciente'
            document.getElementById('btn_titulo').innerHTML = estadoModal == 1 ? 'Guardar' : 'Editar'
            
            // document.getElementById('btnsss').setAttribute("onclick", guardarCambios(estadoModal) );
            document.getElementById('btnsss').setAttribute("onclick", `guardarCambios(${estadoModal},${idCustomer})`);
            mandarCampos(estadoModal,datos)
        }

        function guardarCambios(estadoModal, idAppoint=0){
            datos = {
                dni_appoint :document.getElementById('dni_appoint').value,
                name_appoint : document.getElementById('name_appoint').value,
                last_appoint : document.getElementById('last_appoint').value,
                celphone_appoint : document.getElementById('celphone_appoint').value,
                email_appoint : document.getElementById('email_appoint').value,
                addres_appoint : document.getElementById('addres_appoint').value,
                addres_appoint : document.getElementById('addres_appoint').value,
                idAppoint : idAppoint,
            }
            validarDatos(datos)
        }
        function validarDatos(datos){
            if(datos.dni_appoint != ''){
                if(datos.name_appoint!= ''){
                    if(datos.last_appoint!= ''){
                        if (datos.celphone_appoint!= '') {
                            dat = new FormData()
                            dat.append('dni_appoint',datos.dni_appoint)
                            dat.append('name_appoint',datos.name_appoint)
                            dat.append('last_appoint',datos.last_appoint)
                            dat.append('celphone_appoint',datos.celphone_appoint)
                            dat.append('email_appoint',datos.email_appoint)
                            dat.append('addres_appoint',datos.addres_appoint)
                            dat.append('idAppoint',datos.idAppoint)
                            fetch(url,{
                                method : 'POST',
                                body : dat
                            })
                            .then(result => result.json())
                            .then(result => {
                                if(result){
                                    alertaToastify('Datos Cambiados','green')
                                    setTimeout(() => {
                                        location.reload()
                                    }, 1500);
                                }else alertaToastify('Intentalo nuevamente')
                                
                            })
                        } 
                        else alertaToastify('Celular obligatorio')
                    }
                    else alertaToastify('Apellidos obligatorio')
                }
                else alertaToastify('Nombres obligatorios')                
            }
            else alertaToastify('Dni obligatorio')
        }
        function mandarCampos(estadoModal,datos= []){
            if(estadoModal == 2 || estadoModal == 3){
                document.getElementById('dni_appoint').disabled = estadoModal == 2 ? true : false
                document.getElementById('dni_appoint').value = datos.dni
                document.getElementById('name_appoint').value = datos.nombre
                document.getElementById('last_appoint').value = datos.apellidos
                document.getElementById('celphone_appoint').value = datos.celular
                document.getElementById('email_appoint').value = datos.correo
                document.getElementById('addres_appoint').value = datos.direccion

            }else{
                document.getElementById('dni_appoint').value = ''
                document.getElementById('dni_appoint').disabled = false
                document.getElementById('name_appoint').value = ''
                document.getElementById('last_appoint').value = ''
                document.getElementById('celphone_appoint').value = ''
                document.getElementById('email_appoint').value = ''
                document.getElementById('addres_appoint').value = ''
            }
        }

        function deleteCustomer(idCustomer){
            
            Swal.fire({
                title: '¿Seguro de eliminar?',
                text: "Se eliminará definitivamente al paciente!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteDefinity(idCustomer)
                }else{
                    Toastify({
                        text: "Se cancelo la eliminación",
                        duration: 2000,
                        backgroundColor: "#12d3dc",
                    }).showToast();
                }
            })
        }

        function deleteDefinity(idCustomer){
            datos = new FormData()
            datos.append('idDelete',idCustomer)
            fetch(url, {
                method: 'POST', 
                body: datos
            })
            .then(r => r.json())
            .then(r => r == 1 ? location.reload() : console.log('no se elimino') )
            .catch(e => console.log(e))
        }

        function leerDni(estadoModal){
            dni = document.getElementById('dni_appoint').value
            if(dni.length == 8 && estadoModal == 1){
                document.getElementById('spinnerTemp').innerHTML = `<div class="spinner-grow text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>`
                // const url="https://api.apis.net.pe/v1/dni?numero=60691536";
                // const url="https://api.apis.net.pe/v1/dni?numero=60691536";
                urlApi=`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Impsc2MuaGNvOTZAZ21haWwuY29tIn0.ysxMDCaGlMQRJen3msmMcniIx_Q-nuhjXjQ4RNkP31o`;
                // ,{    
                //     mode: 'no-cors', // no-cors, *cors, same-origin
                //     headers: {
                //     'Content-Type': 'application/json',
                //     'Access-Control-Allow-Origin': '*'
                //     },
                // }
                fetch(urlApi)
                // .then(r => r.statusText)
                .then(r => r.json())
                .then(r => {
                    // setTimeout(() => {
                        datos = {
                            dni : r.dni,
                            nombre : r.nombres,
                            apellidos : r.apellidoPaterno+ ' ' +r.apellidoMaterno,
                            celular : '',
                            correo : '',
                            direccion : '',
                        }
                        document.getElementById('spinnerTemp').innerHTML = ''
                        mandarCampos(3,datos)
                    // }, 500);

                })
                .catch(r => console.log(r))
            }else{
                console.log('mal');
            }
            
            
        }
    </script>
<?php 
    }else{
        echo '<h2>UPS!!!... PARECE QUE NO HAY NADA QUE MOSTRAR</h2>';
    }
?>