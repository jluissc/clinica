        // const URL = 'http://127.0.0.1/clinica/admin/';
        console.log('ddd');
        // const url= URL+'ajax/clienteAjax.php';
        leerListaTratamientos()
        listHist =[]
        function validarDni(){
            console.log('aau');
            dni = document.getElementById('dni').value
            DATOS = new FormData()
            DATOS.append('dni', dni)
            fetch(URL+'ajax/citaAjax.php',{
                method : 'post',
                body : DATOS
            })
            .then( r => r.json())
            .then( r => {        
                if(r != 0){
                    document.getElementById('nombre').value = r.user.nombre
                    document.getElementById('apellido').value = r.user.apellidos
                    document.getElementById('celular').value = r.user.celular
                    document.getElementById('correo').value = r.user.correo
                    pacienteId = r.user.id
                    datosPacienteNuevo = []
                    listHist = r.listHist
                    statusCampos(true)
                }else{      
                    leerDni(dni)            
                    statusCampos(false)   
                    alertaToastify('Paciente nuevo, rellene sus datos  ','info',1500)
                }
            })
        }

        function leerDni(dni){
            dni = document.getElementById('dni').value
            if(dni.length == 8){
                // document.getElementById('spinnerTemp').innerHTML = `<div class="spinner-grow text-primary" role="status">
                //                 <span class="visually-hidden">Loading...</span>
                //             </div>`
                urlApi=`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Impsc2MuaGNvOTZAZ21haWwuY29tIn0.ysxMDCaGlMQRJen3msmMcniIx_Q-nuhjXjQ4RNkP31o`;
               
                fetch(urlApi)
                .then(r => r.json())
                .then(r => {
                    datos = {
                        dni : r.dni,
                        nombre : r.nombres,
                        apellidos : r.apellidoPaterno+ ' ' +r.apellidoMaterno,
                        celular : '',
                        correo : '',
                        direccion : '',
                    }
                    // document.getElementById('spinnerTemp').innerHTML = ''
                    mandarCampos(3,datos)

                })
                .catch(r => console.log(r))
            }else{
                console.log('mal');
            }
            
            
        }

        function statusCampos(estado){
            document.getElementById('nombre').disabled = estado
            document.getElementById('apellido').disabled = estado
            document.getElementById('celular').disabled = estado
            document.getElementById('correo').disabled = estado
        
        }


        function leerListaTratamientos(){
            console.log('jjjjjjjjjjjjjjj');
            tablaUsuarios2 = $('#table1').DataTable({  
                "ajax":{            
                    "url": URL+'ajax/clienteAjax.php', 
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
            fetch(URL+'ajax/clienteAjax.php',{
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
                dni_appoint :document.getElementById('dni').value,
                name_appoint : document.getElementById('nombre').value,
                last_appoint : document.getElementById('apellido').value,
                celphone_appoint : document.getElementById('celular').value,
                email_appoint : document.getElementById('correo').value,
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
                            fetch(URL+'ajax/clienteAjax.php',{
                                method : 'POST',
                                body : dat
                            })
                            .then(result => result.json())
                            .then(result => {
                                if(result){
                                    alertaToastify('Datos Cambiados','green')
                                    setTimeout(() => {
                                        location.reload()
                                        // leerListaTratamientos()
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
                document.getElementById('dni').disabled = estadoModal == 2 ? true : false
                document.getElementById('dni').value = datos.dni
                document.getElementById('nombre').value = datos.nombre
                document.getElementById('apellido').value = datos.apellidos
                document.getElementById('celular').value = datos.celular
                document.getElementById('correo').value = datos.correo
                // document.getElementById('addres_appoint').value = datos.direccion

            }else{
                document.getElementById('dni').value = ''
                document.getElementById('dni').disabled = false
                document.getElementById('nombre').value = ''
                document.getElementById('apellido').value = ''
                document.getElementById('celular').value = ''
                document.getElementById('correo').value = ''
                // document.getElementById('addres_appoint').value = ''
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
            fetch(URL+'ajax/clienteAjax.php', {
                method: 'POST', 
                body: datos
            })
            .then(r => r.json())
            .then(r => r == 1 ? location.reload() : console.log('no se elimino') )
            .catch(e => console.log(e))
        }

        
    