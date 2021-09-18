<?php if($_SESSION['tipo']==1){ ?><!-- ADMIN o CAJERO -->
    <section class="row">
        <div class="page-heading">
            <h3>CONFIGURACIÓN GENERAL DE CITAS, PERMISO, EMPRESA, </h3>
        </div>
        <div class="col-12 col-lg-12">
            <div class="row">
                <hr>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 " >
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">SELECCIONAR LAS HORAS DE ATENCIÓN</h4>
                            </div>
                            <div class="card-content">
                                <div class="calendar" style="width: 100%;">
                                    <div class="calendar-header">
                                        <span class="month-picker" id="month-picker">February</span>
                                        <div class="year-picker">
                                            <span class="year-change" id="prev-year">
                                                <pre><</pre>
                                            </span>
                                            <span id="year">2021</span>
                                            <span class="year-change" id="next-year">
                                                <pre>></pre>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="calendar-body">
                                        <div class="calendar-week-day">
                                            <div>Dom</div>
                                            <div>Lun</div>
                                            <div>Mar</div>
                                            <div>Mie</div>
                                            <div>Jue</div>
                                            <div>Vie</div>
                                            <div>Sab</div>
                                        </div>
                                        <div class="calendar-days"></div>
                                    </div>
                                    <!-- <div class="calendar-footer">
                                        <div class="toggle">
                                            <span>Dark Mode</span>
                                            <div class="dark-mode-switch">
                                                <div class="dark-mode-switch-ident"></div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="month-list"></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 " >
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">SELECCIONAR LAS HORAS DE ATENCIÓN</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- <p>
                                        Place checkboxes and radios within list group items and customize as needed
                                    </p> -->
                                    <ul class="list-group" id="listaHoraCrud">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 " >
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">SELECCIONAR LOS TIPOS DE CITA DISPONIBLES</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- <p>
                                        Place checkboxes and radios within list group items and customize as needed
                                    </p> -->
                                    <ul class="list-group" id="listaCitaCrud">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <hr>
                <!-- Editar permisos de usuarios -->
                <div class="col-6 col-lg-6 col-md-6" >
                    <div class="card">
                        <div class="card-header">
                            <h4>Permisos Colaboradores</h4>
                        </div>
                        <div class="row">
                            <div class="col-6 col-lg-6 col-md-6">
                                <div class="card-content pb-4" id="listaColabor">
                                
                                </div>
                            </div>
                            <div class="col-6 col-lg-6 col-md-6">
                                <h5>Seleccionar los permisos </h5>
                                <ul class="list-group" id="permisosUser">
                                    
                                </ul>
                            </div>

                        </div>
                        
                        
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </section>

    <!-- MODAL -->
    <div class="modal fade text-left" id="large" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
            role="document">
            <div class="modal-content" id="showServc">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">CONFIGURACIÓN DE CITAS POR DÍA <div id="fechaSelec"></div></h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-6 col-lg-6 col-md-6 " >
                                <ul class="list-group" id="listaHoraAten">
                                        
                                </ul>
                            </div>
                            <div class="col-6 col-lg-6 col-md-6 " >
                                <ul class="list-group" id="listaTipoAtenc">
                                        
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">Cerrar
                    </button>
                    <!-- <button type="button" class="btn btn-primary ml-1"
                        onclick="guardarServicio()">Guardar
                    </button> -->
                </div>
            </div>
        </div>
    </div>
    <script>
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

// dark_mode_toggle.onclick = () => {
//     document.querySelector('body').classList.toggle('light')
//     document.querySelector('body').classList.toggle('dark')
// }

    </script>
<?php } ?>