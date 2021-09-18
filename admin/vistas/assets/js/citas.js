// const URLD = "http://127.0.0.1/clinica/admin/";

LhorasAtencion = []
LcitasAtencion = []
Lservicios = []
seleccionFecha = false
fechaSelecionada = ''
pacienteId = 0
idAppoint=0 /* Id Cita seleccionado */
document.getElementById('nombre').disabled = true
document.getElementById('apellido').disabled = true
document.getElementById('celular').disabled = true
document.getElementById('correo').disabled = true

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
        
    })
}
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

function mostrarListaServicios(lista){
    listS = '<option value="0">SELECCIONE</option>'
    lista.forEach(servic => {
        listS +=`<option value="${servic.id}">${servic.nombre}</option>`
    }); 
    document.getElementById('select-servc').innerHTML = listS
}

function verificarFecha(dia, mes, anio){
    dia = ('0' +dia).slice(-2)
    fecha = `${anio}-${monthNumber(mes)}-${dia}`;
    document.getElementById('tipocitaSelect').innerHTML = ''
    document.getElementById('fechaCita').innerHTML = fecha
    document.getElementById('horasDisponibles').innerHTML = ''
    document.getElementById('spinner').innerHTML = `<div class="spinner-grow text-success" role="status">
            <span class="sr-only"></span>
        </div>` 
    seleccionFecha = true
    fechaSelecionada = fecha
    console.log(fecha);
    buscarFechaDisponible(fecha)
}

function buscarFechaDisponible(dia){
    console.log(dia);
    url = '../ajax/citaAjax.php'
    DATOS = new FormData()
    DATOS.append('fechaCita', dia)
    fetch(URL+'ajax/citaAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {   
        console.log(r);     
        horaNoDisponibles = [...r.horaNoAten,...r.horaOcupadasCita]
        horaDisp = LhorasAtencion.filter(horasDispo=>{
            let res = horaNoDisponibles.find((horaNDis)=>{
                return horaNDis.horas_id == horasDispo.id;
            });
            return res == undefined;
          });
        fechaActual = new Date()
        
        horasActivas = horaDisp.filter(horaD => horaD.estado == 1)
        horaMenor = horasActivas.filter( horaD =>{
            fecha = `${dia} ${horaD.hora}`
            fechaDis = new Date(fecha)
            return fechaActual.getTime() < fechaDis.getTime()  
        })
        
        filtrarFechasDisponibles(r.citaNoAten, horaNoDisponibles,horaMenor)
        

    })
}

function filtrarFechasDisponibles(citaNoDisponibles,horaNoDisponibles,horaMenor){
    console.log(citaNoDisponibles);
    console.log(horaNoDisponibles);
    console.log(horaMenor);
    list = ''
    citaDispo = 0
    citaDisp2o = 0
    LcitasAtencion.forEach((tipo,index) => {
        if(citaNoDisponibles != 0){
            if(!citaNoDisponibles.some( citaN => citaN.tipo_cita_id == tipo.id) && tipo.estado == 1){
                citaDispo +=1
                list +=`<input type="radio" class="btn-check" name="tipoCitaUs" id="${tipo.nombre}" value="${tipo.id}" autocomplete="off">
                <label class="btn btn-outline-success" for="${tipo.nombre}">${tipo.nombre}</label>`
            }            
        }else {
            if(tipo.estado == 1){
                citaDisp2o +=1
                list +=`<input type="radio" class="btn-check" name="tipoCitaUs" id="${tipo.nombre}" value="${tipo.id}" autocomplete="off">
                <label class="btn btn-outline-success" for="${tipo.nombre}">${tipo.nombre}</label>`
            }
        }
    });

    if(citaDispo>0){
        
        tb = '<div class="row text-center ">'
        
        LhorasAtencion.forEach((hora,index) => {
            console.log('aa');
            if(horaNoDisponibles != 0){
                if(hora.estado == 1 && !horaNoDisponibles.some( horaN => horaN.horas_id == hora.id)){
                    tb +=`<div class="col-6 hora-cita">
                            <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hora.id}" autocomplete="off" >
                            <label class="btn btn-outline-success" for="${index}">${hora.hora}</label>
                        </div>`
                }
            }else{
                if(hora.estado == 1){
                    tb +=`<div class="col-6 hora-cita">
                            <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hora.id}" autocomplete="off" >
                            <label class="btn btn-outline-success" for="${index}">${hora.hora}</label>
                        </div>`
                }
            }                
        });
        tb += '</div>'
        setTimeout(() => {
            document.getElementById('tipocitaSelect').innerHTML = list
            document.getElementById('spinner').innerHTML = ''
            document.getElementById('horasDisponibles').innerHTML = tb  
            mostrarListaServicios(Lservicios)
        }, 1000);
    }else{
        if(citaDisp2o>0){
            // document.getElementById('tipocitaSelect').innerHTML = list
            setTimeout(() => {
                document.getElementById('tipocitaSelect').innerHTML = list    
                document.getElementById('spinner').innerHTML = '' 
                mostrarListaServicios(Lservicios)   
            }, 1000); 
            tb = '<div class="row text-center ">'
            horaMenor.forEach((hora,index) => {
                tb +=`<div class="col-6 hora-cita">
                        <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hora.id}" autocomplete="off" >
                        <label class="btn btn-outline-success" for="${index}">${hora.hora}</label>
                    </div>`
            });
            tb += '</div>'

            setTimeout(() => {
                document.getElementById('spinner').innerHTML = ''
                document.getElementById('horasDisponibles').innerHTML = tb  
                mostrarListaServicios(Lservicios)
            }, 1000);        
        }else{
            document.getElementById('tipocitaSelect').innerHTML = ''
            document.getElementById('horasDisponibles').innerHTML = ''
            document.getElementById('spinner').innerHTML =''
            document.getElementById('select-servc').innerHTML = '<option value="0">SIN SERVICIOS</option>'
            alertaToastify('Dia no disponible por favor seleccione otra fechas')
        }        
    }    
}

function limpiarCampos(){
    document.getElementById('tipocitaSelect').innerHTML = ''
    document.getElementById('horasDisponibles').innerHTML = ''
    document.getElementById('spinner').innerHTML =''
    document.getElementById('select-servc').innerHTML = '<option value="0">SIN SERVICIOS</option>'
    alertaToastify('Dia no disponible por favor seleccione otra fechas')
    document.getElementById('fechaCita').innerHTML = ''
}

function validarDni(){
    dni = document.getElementById('dni').value
    // apiConsulta(dni)
    // url = '../ajax/citaAjax.php'
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
            document.getElementById('nombre').disabled = true
            document.getElementById('apellido').value = r.apellidos
            document.getElementById('apellido').disabled = true
            document.getElementById('celular').value = r.celular
            document.getElementById('celular').disabled = true
            document.getElementById('correo').value = r.correo
            document.getElementById('correo').disabled = true
            pacienteId = r.id 
        }else{
            idUser = 0
            document.getElementById('nombre').value = ''
            document.getElementById('apellido').value = ''
            document.getElementById('celular').value = ''
            document.getElementById('correo').value = ''
            alertaToastify('Paciente nuevo, registrelo para continuar','info',1500)
        }
    })
}
function printListAppointments(datos=''){
    if(datos != '' || datos  != []){
        html = ''
        datos.forEach(appoint => {
            html += `<tr>
            <td>${appoint.nombre}${appoint.apellidos}</td>
            <td>${appoint.correo}</td>
            <td>${appoint.celular}</td>
            <td>${appoint.fecha}</td>
            <td>${appoint.hora}</td>
            <td>
            <span class="badge bg-success">Activo</span>
            </td>
            </tr>`
        });
        document.getElementById('listAppointment').innerHTML = html            
    }
    else
        document.getElementById('listAppointment').innerHTML = 'DATOS VACIOS'
}

function validarCita(){
    horaAtenUsEstado = document.querySelector('input[name=horaAtenUs]:checked')
    tipoCitaUs = document.querySelector('input[name=tipoCitaUs]:checked')
    // nombre = document.getElementById('nombre').value
    // apellido = document.getElementById('apellido').value
    // celular = document.getElementById('celular').value
    // correo= document.getElementById('correo').value
    dni = document.getElementById('dni').value
    servic = document.getElementById('select-servc').value
    if(dni != '' ){
        if(seleccionFecha){
            if (tipoCitaUs) {
                if (horaAtenUsEstado) {
                    if(servic != 0){
                        url = '../ajax/citaAjax.php'
                        DATOS = new FormData()
                        if(pacienteId != 0){
                            DATOS.append('idUser', pacienteId)
                            DATOS.append('idServic', servic)
                            DATOS.append('idHora', horaAtenUsEstado.value)
                            DATOS.append('fechaf', fechaSelecionada)
                            DATOS.append('tipoCita', tipoCitaUs.value)
                            fetch(URL+'ajax/citaAjax.php',{
                                method : 'post',
                                body : DATOS
                            })
                            .then( r => r.json())
                            .then( r => {
                                if(r == 1){
                                    alertaToastify('Se guardo la cita correctamente','green')
                                    document.getElementById('fechaCita').innerHTML = ''
                                    document.getElementById('tipocitaSelect').innerHTML = ''
                                    document.getElementById('horasDisponibles').innerHTML = ''
                                    document.getElementById('select-servc').value = 0
                                    document.getElementById('nombre').value = ''
                                    document.getElementById('apellido').value = ''
                                    document.getElementById('celular').value = ''
                                    document.getElementById('correo').value = ''
                                    document.getElementById('dni').value = ''
                                    // printListAppointments(r)
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                }
                                // console.log(r);
                            })
                        }
                    } else alertaToastify('Seleccione el servicio')                    
                } else alertaToastify('Seleccione la hora de cita','red',1500)                 
            } else alertaToastify('Seleccione su tipo de cita','red',1500)             
        } else alertaToastify('Seleccione el dia de cita','red',1500) 
    } else alertaToastify('Ingrese numero de DNI para validar su cita','red',1500) 
    
}

function apiConsulta(dni){

    url2 = `https://consulta.api-peru.com/api/dni/${dni}`
    
    fetch(url2)
    .then(response => response.json())
    .then(json => console.log(json))
    .catch(error => console.log('Authorization failed : ' + error.message));
}



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




