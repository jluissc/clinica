LhorasAtencion = []
LcitasAtencion = []
Lservicios = []

leerCondicionesAtencion()

function leerCondicionesAtencion(){
    url = '../ajax/configAjax.php'
    DATOS = new FormData()
    DATOS.append('horaAten', 'horaAten')
    fetch(url,{
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

// ***********
// idUser = 0
// document.getElementById('nombre').disabled = true
// document.getElementById('apellido').disabled = true
// document.getElementById('celular').disabled = true
// document.getElementById('correo').disabled = true

// horasAtencion = []

function cargarModalCita(){
    mostrarListaServicios(Lservicios)
}

function mostrarListaServicios(lista){
    list = '<option value="0">SELECCIONE</option>'
    lista.forEach(servic => {
        list +=`<option value="${servic.id}">${servic.nombre}</option>`
    });
    document.getElementById('select-servc').innerHTML = list
}

function verificarFecha(dia, mes, anio){
    dia = ('0' +dia).slice(-2)
    fecha = `${anio}-${monthNumber(mes)}-${dia}`;
    // document.getElementById('fechaSelec').innerHTML = `${anio}-${monthNumber(mes)}-${dia}`
    // fechaSelecionada = fecha
    // buscarHorasDisponiblesDia(fecha)
    console.log(fecha);
    buscarFechaDisponible(fecha)
}

function buscarFechaDisponible(fecha){
    url = '../ajax/citaAjax.php'
    DATOS = new FormData()
    DATOS.append('fechaCita', fecha)
    fetch(url,{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {        
        horaNoDisponibles = [...r.horaNoAten,...r.horaOcupadasCita]
        filtrarFechasDisponibles(r.citaNoAten, horaNoDisponibles)
    })
}

function filtrarFechasDisponibles(citaNoDisponibles,horaNoDisponibles){
    
    list = ''
    citaDispo = 0
    citaDisp2o = 0
    LcitasAtencion.forEach((tipo,index) => {
        if(citaNoDisponibles != 0){
            if(!citaNoDisponibles.some( citaN => citaN.tipo_cita_id == tipo.id) && tipo.estado == 1){
                citaDispo +=1
                list +=`<input type="radio" class="btn-check" name="tipoCitaUs" id="${tipo.nombre}" value="${tipo.id}" autocomplete="off">
                <label class="btn btn-outline-primary" for="${tipo.nombre}">${tipo.nombre}</label>`
            }            
        }else {
            if(tipo.estado == 1){
                citaDisp2o +=1
                list +=`<input type="radio" class="btn-check" name="tipoCitaUs" id="${tipo.nombre}" value="${tipo.id}" autocomplete="off">
                <label class="btn btn-outline-primary" for="${tipo.nombre}">${tipo.nombre}</label>`
            }
        }
    });

    if(citaDispo>0){
        document.getElementById('tipocitaSelect').innerHTML = list
        tb = '<div class="row text-center ">'
            LhorasAtencion.forEach((hora,index) => {
                if(horaNoDisponibles != 0){
                    if(hora.estado == 1 && !horaNoDisponibles.some( horaN => horaN.horas_id == hora.id)){
                        tb +=`<div class="col-4">
                                <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hora.id}" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="${index}">${hora.hora}</label>
                            </div>`
                    }
                }else{
                    if(hora.estado == 1){
                        tb +=`<div class="col-4">
                                <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hora.id}" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="${index}">${hora.hora}</label>
                            </div>`
                    }
                }                
            });
            tb += '</div>'
            document.getElementById('horasDisponibles').innerHTML = tb 
    }else{
        if(citaDisp2o>0){
            document.getElementById('tipocitaSelect').innerHTML = list
            tb = '<div class="row text-center ">'
            LhorasAtencion.forEach((hora,index) => {
                if(horaNoDisponibles != 0){
                    if(hora.estado == 1 && !horaNoDisponibles.some( horaN => horaN.horas_id == hora.id)){
                        tb +=`<div class="col-4">
                                <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hora.id}" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="${index}">${hora.hora}</label>
                            </div>`
                    }
                }else{
                    if(hora.estado == 1){
                        tb +=`<div class="col-4">
                                <input type="radio" class="btn-check" name="horaAtenUs" id="${index}" value="${hora.id}" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="${index}">${hora.hora}</label>
                            </div>`
                    }
                }                
            });
            tb += '</div>'
            document.getElementById('horasDisponibles').innerHTML = tb                
        }else{
            document.getElementById('tipocitaSelect').innerHTML = ''
            document.getElementById('horasDisponibles').innerHTML = ''
            alertaHTML('danger','Dia no disponible por favor seleccione otra fecha','alertaCita')
        }        
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




// calendario
let calendar = document.querySelector('.calendar')

const month_names = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Deciembre']

isLeapYear = (year) => {
    return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) || (year % 100 === 0 && year % 400 ===0)
}

getFebDays = (year) => {
    return isLeapYear(year) ? 29 : 28
}

generateCalendar = (month, year) => {

    let calendar_days = calendar.querySelector('.calendar-days')
    let calendar_header_year = calendar.querySelector('#year')

    let days_of_month = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

    calendar_days.innerHTML = ''

    let currDate = new Date()
    if (!month) month = currDate.getMonth()
    if (!year) year = currDate.getFullYear()

    let curr_month = `${month_names[month]}`
    month_picker.innerHTML = curr_month
    calendar_header_year.innerHTML = year

    // get first day of month
    
    let first_day = new Date(year, month, 1)

    for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
        let day = document.createElement('div')
        if (i >= first_day.getDay()) {
            // data-bs-toggle="modal"
    // data-bs-target="#large"
            day.classList.add('calendar-day-hover')
            day.innerHTML = i - first_day.getDay() + 1
            day.setAttribute("onclick", `verificarFecha(${i - first_day.getDay() + 1},'${curr_month}',${year})`);
            day.setAttribute("data-bs-toggle", 'modal');
            day.setAttribute("data-bs-target", '#large');
            day.innerHTML += `<span></span>
                            <span></span>
                            <span></span>
                            <span></span>`
            if (i - first_day.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month === currDate.getMonth()) {
                day.classList.add('curr-date')
            }
        }
        calendar_days.appendChild(day)
    }
}



const monthNumber = mes => {
        // 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Deciembre'
    switch (mes) {
        case 'Enero':
            numero = '01';
            break;
        case 'Febrero':
            numero = '02';
            break;
        case 'Marzo':
            numero = '03';
            break;
        case 'Abril':
            numero = '04';
            break;
        case 'Mayo':
            numero = '05';
            break;
        case 'Junio':
            numero = '06';
            break;
        case 'Julio':
            numero = '07';
            break;
        case 'Agosto':
            numero = '08';
            break;
        case 'Septiembre':
            numero = '09';
            break;
        case 'Octubre':
            numero = '10';
            break;
        case 'Noviembre':
            numero = '11';
            break;
        case 'Deciembre':
            numero = '12';
            break;            
        default:
            break;
    }
    return numero;
}

let month_list = calendar.querySelector('.month-list')

month_names.forEach((e, index) => {
    let month = document.createElement('div')
    month.innerHTML = `<div data-month="${index}">${e}</div>`
    month.querySelector('div').onclick = () => {
        month_list.classList.remove('show')
        curr_month.value = index
        generateCalendar(index, curr_year.value)
    }
    month_list.appendChild(month)
})

let month_picker = calendar.querySelector('#month-picker')

month_picker.onclick = () => {
    month_list.classList.add('show')
}

let currDate = new Date()

let curr_month = {value: currDate.getMonth()}
let curr_year = {value: currDate.getFullYear()}

generateCalendar(curr_month.value, curr_year.value)

document.querySelector('#prev-year').onclick = () => {
    --curr_year.value
    generateCalendar(curr_month.value, curr_year.value)
}

document.querySelector('#next-year').onclick = () => {
    ++curr_year.value
    generateCalendar(curr_month.value, curr_year.value)
}

let dark_mode_toggle = document.querySelector('.dark-mode-switch')

dark_mode_toggle.onclick = () => {
    document.querySelector('body').classList.toggle('light')
    document.querySelector('body').classList.toggle('dark')
}
