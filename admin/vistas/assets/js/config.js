horasAtencion = []
citasAtencion = []
fechaSelecionada = ''
leerHorasAtencion()

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
        citasAtencion = r.tipoAtencion
        horasAtencion = r.horaAtencion
        mostrarCrudHoras()
        mostrarCrudCitas()
    })
}

function mostrarCrudHoras(){
    div = ''
    horasAtencion.forEach((hora,index) => {
        estado = hora.estado == 1 ? 'checked' : '' 
        div +=`<li class="list-group-item">
                <input class="form-check-input me-1" ${estado} type="checkbox" id="horaId_${index}" onchange="updateHora(${hora.id},this.id)" aria-label="...">
                ${hora.hora}
            </li>`
    });
    document.getElementById('listaHoraCrud').innerHTML = div
}

function updateHora(id, idInp){
    estado = document.getElementById(`${idInp}`).checked ? 1: 0
    url = '../ajax/configAjax.php'
    DATOS = new FormData()
    DATOS.append('estadoHoraC', estado)
    DATOS.append('hora_idHoraC', id)
    fetch(url,{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        citasAtencion = r.tipoAtencion
        horasAtencion = r.horaAtencion
        mostrarCrudHoras()
        mostrarCrudCitas()
    })
}

function updateCita(id, idInp){
    estado = document.getElementById(`${idInp}`).checked ? 1: 0
    url = '../ajax/configAjax.php'
    DATOS = new FormData()
    DATOS.append('estadoCitaC', estado)
    DATOS.append('cita_idCitaC', id)
    fetch(url,{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        citasAtencion = r.tipoAtencion
        horasAtencion = r.horaAtencion
        mostrarCrudHoras()
        mostrarCrudCitas()
    })
}

function mostrarCrudCitas(){
    div = ''
    citasAtencion.forEach((cita,index) => {
        estado = cita.estado == 1 ? 'checked' : '' 
        div +=`<li class="list-group-item">
                <input class="form-check-input me-1" ${estado} type="checkbox" id="citaId_${index}" onchange="updateCita(${cita.id},this.id)" aria-label="...">
                ${cita.nombre}
            </li>`
    });
    document.getElementById('listaCitaCrud').innerHTML = div

}

function runCommand(dia,mes, anio){
    dia = ('0' +dia).slice(-2)
    fecha = `${anio}-${monthNumber(mes)}-${dia}`;
    document.getElementById('fechaSelec').innerHTML = `${anio}-${monthNumber(mes)}-${dia}`
    fechaSelecionada = fecha
    buscarHorasDisponiblesDia(fecha)

}

function buscarHorasDisponiblesDia(fecha){
    document.getElementById('listaHoraAten').innerHTML = ''
    document.getElementById('listaTipoAtenc').innerHTML = ''
    url = '../ajax/configAjax.php'
    DATOS = new FormData()
    DATOS.append('fecha', fecha)
    fetch(url,{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        mostrarHorasAtencion(r.horas);
        mostrarCitasAtencion(r.citas);
    })
}

function mostrarHorasAtencion(horasNoAtencion){
    console.log(horasNoAtencion);
    console.log(horasAtencion);
    div = ''
    horasAtencion.forEach((hora,index) => {
        if(hora.estado != 0 ){
            atender = horasNoAtencion.some( h => h.horas_id == hora.id) ? '' : 'checked' 
            console.log(horasNoAtencion.some( h => h.horas_id == hora.id));
            console.log(hora.id);
            div +=`<li class="list-group-item">
                    <input class="form-check-input me-1" ${atender}  type="checkbox" 
                        id="horaId_${index}" onchange="estadoHora(${hora.id},this.id)" aria-label="...">
                    ${hora.hora}
                </li>`
        }
        
    });
    document.getElementById('listaHoraAten').innerHTML = div
}

function mostrarCitasAtencion(citasNoAtencion){
    div = ''
    citasAtencion.forEach((cita,index) => {
        if(cita.estado != 0 ){
            estado = citasNoAtencion.some( h => h.tipo_cita_id == cita.id) ? '' : 'checked' 
            div +=`<li class="list-group-item">
                    <input class="form-check-input me-1" ${estado} type="checkbox" id="citaId_${index}" onchange="estadoCita(${cita.id},this.id)" aria-label="...">
                    ${cita.nombre}
                </li>`
        }
    });
    document.getElementById('listaTipoAtenc').innerHTML = div
}

function estadoCita(id,idInp){
    estado = document.getElementById(`${idInp}`).checked ? 1: 0
    url = '../ajax/configAjax.php'
    DATOS = new FormData()
    DATOS.append('estadoCita', estado)
    DATOS.append('fechaCita', fechaSelecionada)
    DATOS.append('cita_idCita', id)
    DATOS.append('sedeC', 1)
    fetch(url,{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        console.log(r);
    })
}

function estadoHora(id,idInp){
    estado = document.getElementById(`${idInp}`).checked ? 1: 0
    url = '../ajax/configAjax.php'
    DATOS = new FormData()
    DATOS.append('estadoSelec', estado)
    DATOS.append('fechaSelec', fechaSelecionada)
    DATOS.append('hora_idSelec', id)
    DATOS.append('sede', 1)
    fetch(url,{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        console.log(r);
    })
}


// CALENDARIO JS

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
            day.setAttribute("onclick", `runCommand(${i - first_day.getDay() + 1},'${curr_month}',${year})`);
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
