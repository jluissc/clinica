<?php 
    require_once './controladores/citaControlador.php';
    $inst = new citaControlador();
?>
<section class="">    
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                aria-controls="home" aria-selected="true">Citas</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                aria-controls="profile" aria-selected="false">Crear Cita</a>
        </li>
        <!-- <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                aria-controls="contact" aria-selected="false">Contact</a>
        </li> -->
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- LISTAR CITAS -->
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <?php if($_SESSION['tipo']==1 || in_array(3, $_SESSION['permisos']) ){ ?><!-- ADMIN o CAJERO -->
                <div class="card-header">
                    <h4>Historial de citas</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <!-- <th>Servicio</th> -->
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Monto</th>
                                <th>Estado Pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="listAppointment"  data-typeUser="false">
                            
                            <?php 
                                // echo $inst->reedListAppointment()
                            
                            ?>
                            
                            
                        </tbody>
                    </table>
                </div>
            <?php } ?><!-- ADMIN o CAJERO -->
            <?php if($_SESSION['tipo']==4 ){ ?> <!-- PACIENTES -->
                <div class="card-header">
                    <h4>Mi Historial de citas</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Correo</th>
                                <th>Celular</th> 
                                <!-- <th>Servicio</th> -->
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Monto</th>
                                <th>Estado Pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="listAppointment" data-typeUser="true">
                            <?php 
                                echo $inst->reedListAppointment(true)
                            
                            ?>

                            
                            
                        </tbody>
                    </table>
                </div>
            <?php } ?>                                

        </div>
        <!-- CREAR CITA  -->
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="modal-body">
                <div id="alertaCita" class="text-center"></div>
                
                <div class="row">
                    <div class="col-6 col-lg-6 col-md-6" >
                        <?php 
                            include "./vistas/inc/form-user.php"; 
                        ?>
                        <label>SELECCIONE SERVICIO: </label>
                        <fieldset class="form-group">
                            <select class="form-select" id="select-servc" onchange="cambioServicio(this.id)">
                                <option value="0">SIN SERVICIOS</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6" >
                        <!-- ************* -->
                        <div class="content">
                            <div class="row">
                                <div class="col-12 col-lg-6 col-md-12 " >
                                    <div class="card-content">
                                        <div class="calendar" >
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
                                <div class="col-12 col-lg-6 col-md-12 " id="limpiarCita" >
                                    <div id="fechaCita" class="fecha-cita">

                                    </div>
                                    <div class="text-center tipo-cita" >
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group" id="tipocitaSelect">
                                            
                                        </div>
                                    </div>
                                    <div id="spinner" class="text-center">
                                        
                                    </div>
                                    <div class="container btn-group" id="horasDisponibles" role="group" aria-label="Basic radio toggle button group">  
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ************* -->
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary ml-1 "  onclick="validarCita()">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Guardar</span>
            </button>
        </div>
        <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <p class="mt-2">Duis ultrices purus non eros fermentum hendrerit. Aenean ornare interdum
                viverra. Sed ut odio velit. Aenean eu diam
                dictum nibh rhoncus mattis quis ac risus. Vivamus eu congue ipsum. Maecenas id
                sollicitudin ex. Cras in ex vestibulum,
                posuere orci at, sollicitudin purus. Morbi mollis elementum enim, in cursus sem
                placerat ut.</p>
        </div> -->
    </div>
</section>

<!-- data-bs-toggle="modal" data-bs-target="#info" -->
<div class="modal fade text-left" id="info" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel130" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="tituloModal"> Datos de transferencia </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- 
                    detalles
                    numero operacion
                    banco
                    total
                -->
                <?php 
                    if($_SESSION['tipo']==4){
                ?>
                <div>
                    <h5>Num. Cuenta : 1931903910931029301</h5>
                    <h5>CCI : 005459854145421212</h5>
                </div>
                <?php 
                  }
                ?>
                 <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="aasda" class="form-control font-bold" placeholder="Nombre de banco" autocomplete="false">
                    </div>
                    
                </div>
                <!-- <div id="spinnerTemp"> -->
                    
                <!-- </div> -->
                <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="name_bank" class="form-control font-bold" placeholder="Nombre de banco" autocomplete="false">
                    </div>
                    
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="total_pay" class="form-control font-bold" placeholder="Monto transferido" autocomplete="false">
                    </div>
                </div>
                <!-- <div class="form-group">
                    <div class="col-12">
                        <input type="text" id="celphone_appoint" class="form-control font-bold" placeholder="Nombres (opcional)" autocomplete="false">
                    </div>
                    
                </div> -->
            </div>
            <div class="modal-footer">
                <?php 
                    if($_SESSION['tipo']==4){
                ?>
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <div id="estadoPay"> </div>
                
                <?php 
                    }elseif($_SESSION['tipo']==1){
                ?>
                <div class="form-check" id="validarTransfer">
                   
                </div>
                <?php 
                    }
                ?>
            </div>
        </div>
    </div>
</div>


<script>
    // / calendario
    let calendar = document.querySelector('.calendar')

    const month_names = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']

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
                
                day.innerHTML = i - first_day.getDay() + 1
                if(diasActuales(i - first_day.getDay() + 1,curr_month,year)){
                    day.classList.add('calendar-day-hover')
                    day.setAttribute("onclick", `verificarFecha(${i - first_day.getDay() + 1},'${curr_month}',${year})`);
                }else{
                    day.setAttribute("onclick", 'limpiarCampos()');
                    day.classList.add('day-inhabil')
                }
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
            case 'Diciembre':
                numero = '12';
                break;            
            default:
                break;
        }
        return numero;
    }
    const diasActuales = (dia, mes, anio) =>{
        mes = monthNumber(mes)
        fecha = `${anio}-${mes}-${dia}`
        diaActual= new Date()
        esteDia = new Date(fecha)
        return (diaActual.getTime() <=esteDia.getTime()+60*60*24*1000);
        
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