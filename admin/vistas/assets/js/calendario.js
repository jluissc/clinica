
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
