<?php 
    if($_SESSION['tipo']==1 || in_array(5, $_SESSION['permisos']) ){
        require_once './controladores/clientesControlador.php';
        $inst = new clienteControlador();
?>
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#info" onclick="cambioModalM(1,0)" >
        Nuevo Material
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

        <!-- Modal -->
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

                        <div id="spinnerTemp"></div>

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
                        <!-- <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Cancelar</span>
                        </button>
                        <button type="button" class="btn btn-info ml-1" id="btnsss">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block" id="btn_titulo">Editar</span>
                        </button> -->
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
    <script>
        const url= '<?php echo SERVERURL?>'+'ajax/clienteAjax.php';
        // leerListaTratamientos()
        // function leerListaTratamientos(){
        //     console.log('jjjjjjjjjjjjjjj');
        //     tablaUsuarios2 = $('#table1').DataTable({  
        //         "ajax":{            
        //             "url": url, 
        //             "method": 'POST', //usamos el metodo POST
        //             "data":{listsCustomers:'listsCustomers'}, //enviamos opcion 4 para que haga un SELECT
        //             "dataSrc":""
        //         },
                
        //         "columns":[
        //             {"data": "nombre"},
        //             {"data": "dni"},
        //             {"data": "correo"},
        //             {"data": "celular"},
        //             {"data": "acciones"},
        //         ]
        //     });     
        // }

        // function cambioModalM(tipo,idDato){/* tipo (1 new, 2 edit), IdDato(0 new, !=0 datos a mostrar) */
            
        //     // document.getElementById('btnsss').setAttribute("onclick", guardarCambios(estadoModal) );
        //     document.getElementById('btnsss').setAttribute("onclick", `guardarCambios(${tipo},${idDato})`);
            
        //     document.getElementById('tituloModal').innerHTML = tipo == 1 ? 'Nuevo Material' : 'Editar Material'
        //     document.getElementById('btn_titulo').innerHTML = tipo == 1 ? 'Guardar' : 'Editar'
        //     if (idDato !=0) {
        //         mandarCampos(estadoModal,datos)
        //     } 
        // }
        
        // function showCustomer(idCustomer,estadoModal){ /* idCustomer = idPaciente, tipo =(1 new paciente, 2 update paciente) */
        //     datos = new FormData()
        //     datos.append('idCustomer',idCustomer)
        //     fetch(url,{
        //         method : 'POST',
        //         body : datos,
        //     })
        //     .then(r => r.json())
        //     .then(r => cambioModal(estadoModal, r,idCustomer))            
        // }

        

        // function mandarCampos(estadoModal,datos= []){
        //     if(estadoModal == 2 || estadoModal == 3){
        //         document.getElementById('dni').disabled = estadoModal == 2 ? true : false
        //         document.getElementById('dni').value = datos.dni
        //         document.getElementById('nombre').value = datos.nombre
        //         document.getElementById('apellido').value = datos.apellidos
        //         document.getElementById('celular').value = datos.celular
        //         document.getElementById('correo').value = datos.correo
        //         // document.getElementById('addres_appoint').value = datos.direccion

        //     }else{
        //         document.getElementById('dni').value = ''
        //         document.getElementById('dni').disabled = false
        //         document.getElementById('nombre').value = ''
        //         document.getElementById('apellido').value = ''
        //         document.getElementById('celular').value = ''
        //         document.getElementById('correo').value = ''
        //         // document.getElementById('addres_appoint').value = ''
        //     }
        // }

    </script>
<?php 
    }else{
        echo '<h2>UPS!!!... PARECE QUE NO HAY NADA QUE MOSTRAR</h2>';
    }
?>