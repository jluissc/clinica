const URL = 'http://127.0.0.1:84/clinica/admin/';
const days = [7, 1 , 2, 3, 4, 5, 6]

Lservicios = []
pacienteId = 0 /* 0 si es nuevo / otro si ya existe */
datosPacienteNuevo = []
listConfig = [] /* DIA,HORA, TIPO configurados por el admin */
listCitasReserv = [] /* CITAS YA RESERVADAS */
servicSelect =0;

LhorasAtencion = []
LcitasAtencion = []
seleccionFecha = false
fechaSelecionada = ''
idAppoint=0 /* Id Cita seleccionado */

leerCondicionesAtencion()
buscarHistCitas()
leerListaTratamientos()
leerListaHistorial()
// table.destroy();
function leerListaTratamientos(){
    tablaUsuarios = $('#table1').DataTable({  
        "ajax":{            
            "url": URL+'ajax/citaAjax.php', 
            "method": 'POST', //usamos el metodo POST
            "data":{tipoUserH:tipoUser == 4 ? true : false}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        
        "columns":[
            {"data": "nombre"},
            {"data": "dni"},
            {"data": "correo"},
            {"data": "celular"},
            {"data": "fecha"},
            {"data": "hora"},
            {"data": "monto"},
            {"data": "total"},
            {"data": "pago"},
            {"data": "acciones"}
        ]
    });     
}
function leerListaHistorial(){
    // console.log(tipoUser == 4 ? true : false);
    tablaUsuarios2 = $('#table2').DataTable({  
        "ajax":{            
            "url": URL+'ajax/citaAjax.php', 
            "method": 'POST', //usamos el metodo POST
            "data":{tipoUserHist:tipoUser == 4 ? true : false}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },        
        "columns":[
            {"data": "nombre"},
            {"data": "dni"},
            {"data": "correo"},
            {"data": "celular"},
            {"data": "name"},
            {"data": "code"},
            {"data": "acciones"},
        ],
    });   
}

function showHistorial(idHistorial){
    DATOS = new FormData()
    DATOS.append('idHistorial', idHistorial)
    fetch(URL+'ajax/citaAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        HTMLHistorial(r)
        // console.log(r);        
    })
}
function HTMLHistorial(datos){
    // lista = ''
    // datos.forEach(tratam => {
    //     lista+=`<li>
    //             <div>
    //                 <time>${tratam.fecha} ${tratam.hora}</time> 
    //                 <hr><p>SERVICIO : ${tratam.nombre}</p>
    //                 <hr><p>DESCRIPCIÓN : ${tratam.descripcion }</p>
    //             </div>
    //         </li>`
    // });
    document.getElementById('historialPacient').innerHTML = datos 
}

function leerCondicionesAtencion(){
    DATOS = new FormData()
    DATOS.append('horaAten', 'horaAten')
    fetch(URL+'ajax/configAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        LcitasAtencion = r.tipoAtencion
        LhorasAtencion = r.horaAtencion
        Lservicios = r.servicios
        // filtrarConfig(r.listConfig)
        mostrarListaServicios()
        
    })
}
function statusCampos(estado){
    document.getElementById('nombre').disabled = estado
    document.getElementById('apellido').disabled = estado
    document.getElementById('celular').disabled = estado
    document.getElementById('correo').disabled = estado

}
listHist =[]
function validarDni(){
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
            console.log(r);
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
/*  */
function leerDni(dni){
    // console.log(dni);
    // urlApi=`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Impsc2MuaGNvOTZAZ21haWwuY29tIn0.ysxMDCaGlMQRJen3msmMcniIx_Q-nuhjXjQ4RNkP31o`;
    urlApi=`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InBlcGJvdC5wZUBnbWFpbC5jb20ifQ.8dxeu7zAz1x7u3S29WytfSuybE9fdPg_T8-kW087Mqw`;
    fetch(urlApi)
    .then(r => r.json())
    .then(r => {
        // console.log(r);
        if(r.nombres != null){            
            document.getElementById('nombre').value = r.nombres
            document.getElementById('apellido').value = r.apellidoPaterno + ' ' +r.apellidoMaterno
        }else{
            document.getElementById('nombre').value = ''
            document.getElementById('apellido').value = ''

        }
        
    })
    .catch(r => console.log(r))
    
    // *****************
        // ,{    
        //     mode: 'no-cors', // no-cors, *cors, same-origin
        //     headers: {
        //     'Content-Type': 'application/json',
        //     'Access-Control-Allow-Origin': '*'
        //     },
        // }
    // *****************

    // var formData = new FormData();
    // formData.append("token", "YccQhVMLEMGTxZC6cybJLSjoKUuLNiSssf9yvUOtdOZgwcJdzK9R6YOJBPcq");
    // formData.append("dni",'48540264');

    // var request = new XMLHttpRequest();

    // request.open("POST", "https://api.migo.pe/api/v1/dni");
    // request.setRequestHeader("Accept", "application/json");

    // request.send(formData);
    // request.onload = function() {
    // var data = JSON.parse(this.response);
    // console.log(data);
    // };  
    
}
function mostrarListaServicios(){

    listS = '<option value="0" >SELECCIONE</option>'
    Lservicios.forEach(servic => {
        listS +=`<option value="${servic.id}" >${servic.nombre}</option>`
    }); 
    document.getElementById('select-servc').innerHTML = listS
}
function cambioServicio(servSelect){
    
    servicSelect = document.getElementById(servSelect).value
    // console.log(servicSelect);
    if(servicSelect == 17){/* DEPENDE QUE ID TIENE EL CONSULTAS */
        div = `<div class="form-group">
            <label for="nameHist">Dale un nombre a tu consulta</label>
            <input type="text" placeholder="Nombre(opcional)" id="nameHist" class="form-control">
        </div>`
        document.getElementById('historialNew').innerHTML = div
    }else if(servicSelect == 0)
        document.getElementById('historialNew').innerHTML = ''
    else{
        if(listHist != 0){

            div ='<div class="container btn-group"  aria-label="Basic radio toggle button group">'
            listHist.forEach(h => {
                div +=`<input type="radio" class="btn-check" id="${h.id}" value="${h.id}" name="listHHHH">
                <label class="btn btn-outline-success" for="${h.id}" >${h.code}-${h.nombre}</label>`
            });
            div +='</div>'
        }else{
            div  = 'No tiene servicio anterior'
        }
        document.getElementById('historialNew').innerHTML = div
    } 
}
function buscarHistCitas(){
    dat = new FormData()
    dat.append('searcHistUser','user')
    fetch(URL+'ajax/citaAjax.php',{
        method : 'post',
        body : dat
    })
    .then( r => r.json())
    .then( r => {
        listHist =r
        // console.log(listHist);
    })
}
function verificarFecha(dia, mes, anio){
    if(servicSelect != 0){    
        dia = ('0' +dia).slice(-2)
        fecha = `${monthNumber(mes)}-${dia}-${anio}`;
        fechaB = `${anio}-${monthNumber(mes)}-${dia}`;
        document.getElementById('tipocitaSelect').innerHTML = ''
        document.getElementById('fechaCita').innerHTML = fecha
        document.getElementById('horasDisponibles').innerHTML = ''
        // document.getElementById('spinner').innerHTML = `<div class="spinner-grow text-success" role="status">
        //         <span class="sr-only"></span>
        //     </div>` 
        // seleccionFecha = true
        // fechaSelecionada = fecha    
        diaSelect = days[new Date(fecha).getDay()]
        document.getElementById('tipocitaSelect').innerHTML = ''
        document.getElementById('horasDisponibles').innerHTML = ''
        fechaSelecionada = fechaB
        buscarCitasReservadas(fechaB,diaSelect)
    }else{
        alertaToastify('Escoge tipo de servicio');
    }
    
}
function buscarCitasReservadas(dia,diaSelect){
    DATOS = new FormData()
    DATOS.append('fechaCita', dia)
    DATOS.append('diaSelectsss', diaSelect)
    DATOS.append('tipoServf', servicSelect)
    
    fetch(URL+'ajax/citaAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {   
        if(r.dias != 0){

            if(r.citas == 0){
                listCitasReserv = []
            }else{
                listCitasReserv = r.citas 
            }
            filtrarFechasHorasDispo(diaSelect,r.tipoCita,r.dias,r.horas)/*dia en numero / tipo disponibles para esta servicio,  */
        }else{
            alertaToastify('Dia no disponibles, escoge otro dia por favor')
        }
        
    })
}
function filtrarFechasHorasDispo(diaSelect,citaDispo,diass,horas){
    aaaa = []
    dispon = citaDispo.length > diass.length ? citaDispo : diass
    statuss = citaDispo.length > diass.length ? diass : citaDispo
    dispon.forEach(element => {
        if(statuss.find(ff => ff.tipo_cita_id == element.tipo_cita_id)){
            aaaa.push(diass.find(ff => ff.tipo_cita_id == element.tipo_cita_id)) 
        }
    });
    if(aaaa.length>0){
        inicio = aaaa[0].horainicio;
        fin = aaaa[0].horafin;
        list =''
        LcitasAtencion.forEach((tipo,index) => {
            if(aaaa.find(type => type.tipo_cita_id == tipo.id)){
                list +=`<input type="radio" class="btn-check" name="tipoCitaUs" id="${tipo.nombre}" value="${tipo.id}">
                <label class="btn btn-outline-success" for="${tipo.nombre}">${tipo.nombre}</label>`
            }
        });
        document.getElementById('tipocitaSelect').innerHTML = list
        tb = '<div class="row text-center ">'
        horas.forEach(hour => {
            if(listCitasReserv.find(cita=> cita.horas_id == hour.id)){
                horas = horas.filter(hou => hou.id != hour.id)
            }
        });  
        horas.forEach((hour,index) => {
            if(hour.hora >= inicio && hour.hora < fin){
                tb +=`<div class="col-6 col-md-6 col-lg-4 hora-cita">
                        <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hour.id}" >
                        <label class="btn btn-outline-success" for="${index}">${hour.hora}</label>
                    </div>`
                    
            }
        });
        tb += '</div>'
        document.getElementById('horasDisponibles').innerHTML = tb
    }else{
        alertaToastify('Fecha no disponible')
    }
    
}

function validarCita(){   
    
    dni = tipoUser == '4' ? 12345678 :parseInt(document.getElementById('dni').value)
    nombre = tipoUser == 4 ? 'login' :document.getElementById('nombre').value
    apellido = tipoUser == 4 ? 'login' :document.getElementById('apellido').value
    celular = tipoUser == 4 ? 'login' :document.getElementById('celular').value
    correo = tipoUser == 4 ? 'login' :document.getElementById('correo').value
    nameHist = servicSelect == 17 ? document.getElementById('nameHist').value : ''
    cita = document.querySelector('input[name="tipoCitaUs"]:checked')
    listHistt = servicSelect != 17 ? document.querySelector('input[name="listHHHH"]:checked') : 0
    hora = document.querySelector('input[name="horaAtenUs"]:checked')
    
    
    // b = document.querySelector('input[name="horaAtenUs"]:checked').value
    // console.log(a);
    // console.log(b);
    // console.log(dni.length > 1);
    // console.log(dni);
    if(dni != ''){
        if(nombre != '' && apellido != ''){
            if (celular != '') {
                if(cita) {
                    if(hora) {
                        datosPacienteNuevo = {
                            tipoUse : tipoUser,
                            idUPaci : idUPaci,
                            dni : dni,
                            nombre : nombre,
                            apellidos :apellido,
                            celular :celular,
                            correo :correo,
                            cita :cita.value,
                            hora :hora.value,
                            iduser : tipoUser == 4 ? idUPaci : pacienteId,
                            fecha : fechaSelecionada,
                            servicSelect : servicSelect,
                            nameHist : nameHist,
                            listHistt : listHistt.value,
                        }
                        guardarCita(datosPacienteNuevo)
                        // console.log(listHistt);
                    }
                    else  alertaToastify('Escoge la hora de atención')
                }else alertaToastify('Escoge el tipo de atención')
            } else alertaToastify('Rellene celular')
        }else alertaToastify('Completa nombre del paciente')
    }else alertaToastify('Dni incompleto ')
}

function guardarCita(user){

    // console.log(fechaSelecionada);
    dat = new FormData()
    dat.append('guardCitaUs',JSON.stringify(user))
    fetch(URL+'ajax/citaAjax.php',{
        method : 'post',
        body : dat
    })
    .then( r => r.json())
    .then( r => {  
        if(r == 1){
            alertaToastify('Se grabo tu reserva','green',1500) 
            // console.log(r);
            datosPacienteNuevo = []
            if(tipoUser != 4){
                document.getElementById('dni').value = ''
                document.getElementById('nombre').value = ''
                document.getElementById('apellido').value = ''
                document.getElementById('celular').value = ''
                document.getElementById('correo').value = ''
            }
            document.getElementById('fechaCita').innerHTML = ''
            document.getElementById('tipocitaSelect').innerHTML = ''
            document.getElementById('horasDisponibles').innerHTML = ''
            document.getElementById('historialNew').innerHTML = ''
            fechaSelecionada = ''
            setTimeout(() => {
                location.reload()
            }, 2000);
        }else alertaToastify('Error al grabar la reserva')
    })
}

/* ****************HASTA AQUI EL NUEVO CODIGO******************* */

function datosTransf(idAppointd,showBtn){
    idAppoint = idAppointd
    if(showBtn){
        document.getElementById('estadoPay').innerHTML = `<button type="button" class="btn btn-info ml-1" onclick="mandarDatosPago()">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Mandar Datos</span>
            </button>`
    }else{
        document.getElementById('estadoPay').innerHTML = ''
    }
}

function validarTransf(idAppointd){
    datos = new FormData()
    datos.append('idAppointdV',idAppointd)
    fetch(URL+'ajax/citaAjax.php',{
        method : 'POST',
        body : datos,
    })
    .then( result => result.json())
    .then( result => {
        document.getElementById('numbTrans').value = result.detalles
        document.getElementById('name_bank').value = result.medio_pago
        document.getElementById('total_pay').value = result.total
        estado = result.estado == 1 ? 'checked disabled' : '' 
        document.getElementById('validarTransfer').innerHTML = ` <div class="custom-control custom-checkbox">
                <input type="checkbox" class="form-check-input form-check-success form-check-glow" ${estado} onchange="validarTRansfern(${result.id})" id="checkValidTransf">
                <label class="form-check-label" for="customColorCheck3">Validar Transferencia</label>
            </div>`

    })
}

function validarTRansfern(idAppointPay){
    document.getElementById('checkValidTransf').disabled = true
    estado = document.getElementById('checkValidTransf').checked
    datos = new FormData()
    datos.append('estadoTransf',estado)
    datos.append('idPayAppoint',idAppointPay)
    fetch(URL+'ajax/citaAjax.php',{
        method : 'POST',
        body : datos,
    })
    .then( result => result.json())
    .then( result => {
        if(result == 1){
            alertaToastify('Se verifico transferencia', 'green')
            setTimeout(() => {
                location.reload()
            }, 2000);
        }else{

        }
    })
}

function payDirect(idAppointPay){
    document.getElementById(`pagoDirecto_${idAppointPay}`).checked = false
    

    Swal.fire({
        title: 'Ingrese el monto de pago S/. ',
        input: 'text',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Pagar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`pagoDirecto_${idAppointPay}`).disabled = true
            document.getElementById(`pagoDirecto_${idAppointPay}`).checked = true
            datos = new FormData()
            datos.append('idPayDirect',idAppointPay)
            datos.append('montoPayDirect',parseInt(result.value))
            fetch(URL+'ajax/citaAjax.php',{
                method : 'POST',
                body : datos,
            })
            .then( result => result.json())
            .then( result => {
                if(result == 1){
                    alertaToastify('Se guardo el pago', 'green',2000)
                    Swal.fire({
                        title: `Se guardo el pago`,
                        // imageUrl: result.value.avatar_url
                        })
                        
                    setTimeout(() => {
                        location.reload()
                    }, 1000);
                }else{

                }
            })
        }
    })
    
    
}

function mandarDatosPago(){
    numb_pay = document.getElementById('numbTrans').value
    name_bank = document.getElementById('name_bank').value
    total_pay = document.getElementById('total_pay').value
    if(numb_pay != ''){
        if(name_bank != ''){
            if (total_pay != '') {
                datos = new FormData()
                datos.append('numb_pay',numb_pay)
                datos.append('name_bank',name_bank)
                datos.append('total_pay',total_pay)
                datos.append('idAppoint',idAppoint)
                fetch(URL+'ajax/citaAjax.php',{
                    method : 'POST',
                    body : datos
                })
                .then(result => result.json())
                .then(result => {
                    if(result){
                        alertaToastify('Se mando tus datos de transferencia','green')
                        setTimeout(() => {
                            location.reload()
                        }, 1500);
                    }
                    else alertaToastify('Intentalo nuevamente por favor','red') 
                })
                .catch(error => alertaToastify('Comuniquese con el area de soporte','red') )
            } 
            else alertaToastify('Monto necesario','red') 
        }
        else  alertaToastify('Nombre del banco necesario','red') 
    }
    else alertaToastify('Número de operación necesario','red')
}







