// const URLD = "http://127.0.0.1/clinica/admin/";

Lservicios = []
pacienteId = 0 /* 0 si es nuevo / otro si ya existe */
datosPacienteNuevo = []
listConfig = [] /* DIA,HORA, TIPO configurados por el admin */
listCitasReserv = [] /* CITAS YA RESERVADAS */
const days = [7, 1 , 2, 3, 4, 5, 6]
servicSelect =0;

LhorasAtencion = []
LcitasAtencion = []
seleccionFecha = false
fechaSelecionada = ''
idAppoint=0 /* Id Cita seleccionado */

leerCondicionesAtencion()

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
// function filtrarConfig(datos){
//     datos.forEach(confg => {        
//         if (listConfig.find(conf => conf.diaId == confg.dias_id)) {            
//             const confgList = listConfig.map( conff => {
//                 if( conff.diaId == confg.dias_id ) {
//                     conff.config.push({
//                         'tipoId' : confg.tipo_cita_id,
//                     })
//                     return conff;
//                 } 
//                 else return conff;
//             })
//             listConfig = [...confgList];
//         } else {
//             listConfig.push({
//                 'diaId' : confg.dias_id,
//                 'horaI' : confg.horainicio,
//                 'horaF' : confg.horafin,
//                 'config' : [{
//                     'tipoId' : confg.tipo_cita_id,
                    
//                 }]
//             })
//         }
//     });
//     console.log(listConfig);
// }
function statusCampos(estado){
    document.getElementById('nombre').disabled = estado
    document.getElementById('apellido').disabled = estado
    document.getElementById('celular').disabled = estado
    document.getElementById('correo').disabled = estado

}
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
            document.getElementById('nombre').value = r.nombre
            document.getElementById('apellido').value = r.apellidos
            document.getElementById('celular').value = r.celular
            document.getElementById('correo').value = r.correo
            pacienteId = r.id
            datosPacienteNuevo = []
            statusCampos(true)
        }else{      
            leerDni(dni)
            pacienteId = 0
            statusCampos(false)   
            alertaToastify('Paciente nuevo, registrelo ','info',1500)
        }
    })
}
function leerDni(dni){
    urlApi=`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Impsc2MuaGNvOTZAZ21haWwuY29tIn0.ysxMDCaGlMQRJen3msmMcniIx_Q-nuhjXjQ4RNkP31o`;
    fetch(urlApi)
    .then(r => r.json())
    .then(r => {
        datosPacienteNuevo = {
            dni : r.dni,
            nombre : r.nombres,
            apellidos : r.apellidoPaterno+ ' ' +r.apellidoMaterno,
        }
        document.getElementById('nombre').value = datosPacienteNuevo.nombre
        document.getElementById('apellido').value = datosPacienteNuevo.apellidos
        document.getElementById('celular').value = ''
        document.getElementById('correo').value = ''
        
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
    horas.forEach((hour,index) => {
        if(hour.hora >= inicio && hour.hora < fin){
            tb +=`<div class="col-6 hora-cita">
                    <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hour.id}" >
                    <label class="btn btn-outline-success" for="${index}">${hour.hora}</label>
                </div>`
                
        }
    });
    tb += '</div>'
    document.getElementById('horasDisponibles').innerHTML = tb
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
    console.log(idAppoint);
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
        console.log(result)
        document.getElementById('aasda').value = result.detalles
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
    console.log(idAppointPay);
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
        console.log(result)
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
        confirmButtonText: 'Look up',
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
                console.log(result)
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
    numb_pay = document.getElementById('aasda').value
    name_bank = document.getElementById('name_bank').value
    total_pay = document.getElementById('total_pay').value
    if(numb_pay != ''){
        if(name_bank != ''){
            if (total_pay != '') {
                console.log(idAppoint);
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
                    console.log(result)
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





function payAppoint(idAppoint){
console.log(idAppoint);
}










