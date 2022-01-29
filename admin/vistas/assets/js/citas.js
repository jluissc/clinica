
const days = [7, 1 , 2, 3, 4, 5, 6];
LcitasAtencion = [];
servSelecTempo = 0;
 catSelecTempo = 0;
 hisTrat = []
 hisTrat2 = []

Lservicios = [] /* listar los servicios generales activos */
Lcategorias = [] /* listar los servicios  */

idAppoint=0 /* Id Cita seleccionado */

// hacer citas o consultas
selectServGe =  document.getElementById('select-servc') /* Seleccionar select de servicio general */
pacienteId = 0 /* 0 si es nuevo / otro si ya existe */
listHist =[]  /* usuario temporal que busca cita */
inp_dni = document.getElementById('dni')
inp_nombre = document.getElementById('nombre')
inp_apellido = document.getElementById('apellido')
inp_celular = document.getElementById('celular')
inp_correo = document.getElementById('correo')
fechaSelecionada = ''
serviciosTemp = []
categTemp = []
histNew = true
tipoUsuario = 0
idUser = 0

leerCondicionesAtencion()
leerListaTratamientos()
leerListaHistorial()
// table.destroy();
function leerListaTratamientos(){
    tablaUsuarios = $('#tbl_tratam').DataTable({  
        "ajax":{            
            "url": URL+'ajax/citaAjax.php', 
            "method": 'POST', //usamos el metodo POST
            "data":{tipoUserH:'tippp'}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },        
        "columns":[
            {"data": "nombre"},
            {"data": "dni"},
            // {"data": "correo"},
            {"data": "celular"},
            {"data": "servicio"},
            {"data": "fecha"},
            {"data": "hora"},
            {"data": "monto"},
            {"data": "total"},
            {"data": "pago"},
            {"data": "acciones"}
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
    });     
}
function leerListaHistorial(){
    tablaUsuarios2 = $('#table2').DataTable({  
        "ajax":{            
            "url": URL+'ajax/citaAjax.php', 
            "method": 'POST', //usamos el metodo POST
            "data":{tipoUserHist:'tippp'}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },        
        "columns":[
            {"data": "nombre"},
            {"data": "dni"},
            {"data": "correo"},
            {"data": "celular"},
            {"data": "name"},
            // {"data": "code"},
            {"data": "acciones"},
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
    });   
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
        hisTrat = r.hisTrat
        hisTrat2 = r.hisTrat
        tipoUsuario = r.tipoUser
        
        idUser = r.idUser
        LcitasAtencion = r.tipoAtencion /* listar tipo de atencion  */
        filtrarServics(r.listServics)
    })
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
        document.getElementById('historialPacient').innerHTML = r     
    })
}
function filtrarServics(listServi){
    Lservicios = []
    listServi[0].forEach(cat => {
        if(cat.s_est == 1){
            Lcategorias.push(cat)
        }
    });
    listServi[1].forEach(serv => {
        if(serv.estado == 1){
            Lservicios.push(serv)
        }
    });
    mostrarListaServicios()
}
function mostrarListaServicios(){
    listS = '<option value="0" >SELECCIONE</option>'
    Lservicios.forEach(servic => {
        listS +=`<option value="${servic.id}" >${servic.nombre}</option>`
    }); 
    selectServGe.innerHTML = listS
}
function cambioServicio(servSelect){
    serviciosTemp = []
    servSelecTempo = servSelect
    if(servSelect != 0){
        li = `<label>SELECCIONE CATEGORIA: </label>
            <fieldset class="form-group">
            <select class="form-select" id="select-categ" onchange="cambioCategoria(this.value)">
                <option value="0">SELECCIONE</option> `
        Lcategorias.forEach(cat => {
            if(cat.servicio_general_id == servSelect){
                li +=`<option value="${cat.s_id}" >${cat.cat}</option>`
            }
        }); 
        li +=`</select>
            </fieldset>`
        document.getElementById('categ_customer').innerHTML = li
    }else{
        document.getElementById('categ_customer').innerHTML = ''
    }
}
function cambioCategoria(id){
    categTemp = Lcategorias.filter( cat => cat.s_id == id)
    if(categTemp.find(serv => serv.consulta == 1)){
        inp = `<input class="form-control" placeholder="Ingrese nombre para la cita" id="nameHistNew">`
        document.getElementById('historialNew').innerHTML = inp
    } 
    else {
        histNew=false
        historialTratamiento()
    }
    catSelecTempo = id

}
function statusCampos(estado){
    inp_nombre.disabled = estado
    inp_apellido.disabled = estado
    inp_celular.disabled = estado
    inp_correo.disabled = estado

}
function validarDni(){
    dni = document.getElementById('dni').value
    if (dni.length == 8) {
        DATOS = new FormData()
        DATOS.append('dni', dni)
        fetch(URL+'ajax/citaAjax.php',{
            method : 'post',
            body : DATOS
        })
        .then( r => r.json())
        .then( r => {        
            if(r != 0){
                inp_nombre.value = r.user.nombre
                inp_apellido.value = r.user.apellidos
                inp_celular.value = r.user.celular
                inp_correo.value = r.user.correo
                pacienteId = r.user.id
                listHist = r.listHist
                statusCampos(true)
            }else{   
                pacienteId = 0   
                leerDniii(dni)            
                statusCampos(false)   
                alertaToastify('Paciente nuevo, rellene sus datos  ','info',1500)
            }
            historialTratamiento()
        })
    } else alertaToastify('Dni incompleto')
}
function historialTratamiento(){
    if(tipoUsuario == 4){
        div ='Escoge su codigo si continuara un tratamiento<div class="container btn-group"  aria-label="Basic radio toggle button group">'
            hisTrat2.forEach(hist => {
                div +=`<input type="radio" class="btn-check" id="hist_${hist.idHis}" value="${hist.idHis}" name="listHHHH">
                <label class="btn btn-outline-success" for="hist_${hist.idHis}" >${hist.code}-${hist.nameC}</label>`
            });
            div +='</div>'
    }else{

        if(listHist.length > 0 ){
            div ='Escoge su codigo si continuara un tratamiento<div class="container btn-group"  aria-label="Basic radio toggle button group">'
            listHist.forEach(hist => {
                div +=`<input type="radio" class="btn-check" id="hist_${hist.id}" value="${hist.id}" name="listHHHH">
                <label class="btn btn-outline-success" for="hist_${hist.id}" >${hist.code}-${hist.nombre}</label>`
            });
            div +='</div>'
        }
        else div = 'No tiene historial <input class="form-control" placeholder="Ingrese nombre para la cita" id="nameHistNew">'
    }
    document.getElementById('historialNew').innerHTML = div
}
function leerDniii(dni){
    // console.log(dni);
    // urlApi=`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Impsc2MuaGNvOTZAZ21haWwuY29tIn0.ysxMDCaGlMQRJen3msmMcniIx_Q-nuhjXjQ4RNkP31o`;
    urlApi=`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InBlcGJvdC5wZUBnbWFpbC5jb20ifQ.8dxeu7zAz1x7u3S29WytfSuybE9fdPg_T8-kW087Mqw`;
    fetch(urlApi)
    .then(r => r.json())
    .then(r => {
        // console.log(r);
        if(r.nombres != null){            
            inp_nombre.value = r.nombres
            inp_apellido.value = r.apellidoPaterno + ' ' +r.apellidoMaterno
        }else{
            inp_nombre.value = ''
            inp_apellido.value = ''
        }  
        listHist = []
        historialTratamiento()      

    })
    .catch(r => console.log(r))    
}
function limpiarCampos (){
    document.getElementById('fechaCita').innerHTML = ''
    document.getElementById('tipocitaSelect').innerHTML = ''
    document.getElementById('horasDisponibles').innerHTML = ''
    alertaToastify('Escoge una fecha actual');
}
function verificarFecha(dia, mes, anio){
    if(servSelecTempo != 0){ 
        if(catSelecTempo != 0){
            dia = ('0' +dia).slice(-2)
            fecha = `${monthNumber(mes)}-${dia}-${anio}`;
            fechaB = `${anio}-${monthNumber(mes)}-${dia}`;
            document.getElementById('fechaCita').innerHTML = fecha
            diaSelect = days[new Date(fecha).getDay()]
            document.getElementById('tipocitaSelect').innerHTML = ''
            document.getElementById('horasDisponibles').innerHTML = ''
            fechaSelecionada = fechaB
            buscarCitasReservadas(fechaB,diaSelect)
        }else alertaToastify('Escoge alguna categoria'); 
    }else alertaToastify('Escoge algun servicio'); 
    
}
function buscarCitasReservadas(dia,diaSelect){
    DATOS = new FormData()
    DATOS.append('fechaCita', dia)
    DATOS.append('diaSelectsss', diaSelect)
    DATOS.append('tipoCateg', catSelecTempo)
    DATOS.append('tipoServG', servSelecTempo)
    
    fetch(URL+'ajax/citaAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {   
        if(r.diaDisponi != 0){
            if(r.tipoCita != 0){
                a = []
                disponi = []
                r.tipoCita.forEach(type => {
                    if(r.diaDisponi.find(dia => dia.tipo_atencion == type.tipo_cita_id)) disponi.push(type)
                });
                if(disponi.length > 0){
                    list = ''
                    LcitasAtencion.forEach((tipo,index) => {                        
                        if(disponi.find(type => type.tipo_cita_id == tipo.id)){   
                            list +=`<input type="radio" class="btn-check" name="tipoCitaUs" id="${tipo.nombre}" value="${tipo.id}">
                            <label class="btn btn-outline-success" for="${tipo.nombre}">${tipo.nombre}</label>`
                        }
                    });
                    
                    document.getElementById('tipocitaSelect').innerHTML = list
                    horasFinal = r.horas                    
                    if (Lcategorias.find(cat => cat.s_id == catSelecTempo)) {
                        Lcategorias.forEach(categ => {
                            if(categ.s_id == catSelecTempo){
                                if (categ.cant_atenc == 1) {
                                    tb = '<div class="row text-center ">'
                                    horasFinal.forEach((hour,index) => {
                                        estado = r.citas ? (r.citas.find( cit => cit.horas_id == hour.id) ? 'disabled' : '') : ''
                                        tb +=`<div class="col-6 col-md-6 col-lg-4 hora-cita">
                                                <input type="radio" ${estado} class="btn-check" name="horaAtenUs" id="${index}" value="${hour.id}" >
                                                <label class="btn btn-outline-success" for="${index}">${hour.hora}</label>
                                            </div>`                        
                                    });
                                } 
                                else /* if(categTemp[0].cant_atenc == 3) */ {
                                    citas = []
                                    if (r.citas) {
                                        r.citas.forEach(cit => {
                                            if(citas.some(ct => ct.id == cit.horas_id)){
                                                const usersInt = citas.map( servInt => {
                                                    if( servInt.id == cit.horas_id ) {
                                                        servInt.cant++;
                                                        return servInt;
                                                    } 
                                                    else return servInt;
                                                })
                                                citas = [...usersInt];
                                            }else{
                                                citas.push({
                                                    id :cit.horas_id,
                                                    cant :1
                                                })
                                            }
                                        });
                                    }                                     
                                    tb = '<div class="row text-center ">'
                                    horasFinal.forEach((hour,index) => {
                                        estado = citas.find(cit => cit.id == hour.id && cit.cant == categ.cant_atenc) ? 'disabled' : ''
                                        tb +=`<div class="col-6 col-md-6 col-lg-4 hora-cita">
                                                <input type="radio" ${estado} class="btn-check" name="horaAtenUs" id="${index}" value="${hour.id}" >
                                                <label class="btn btn-outline-success" for="${index}">${hour.hora}</label>
                                            </div>`                        
                                    });
                                }
                            }                            
                        });
                    } 
                    tb += '</div>'
                    
                    document.getElementById('horasDisponibles').innerHTML = tb
                }else alertaToastify('error aaa')
            }else alertaToastify('Dia no disponibles, escoge otro dia por favor')
        }else alertaToastify('Dia no disponibles, escoge otro dia por favor')
        
    })
}
function validarCita(){   
    histSelecTempo = document.querySelector('input[name="listHHHH"]:checked')
    tipoAtSelecTemp = document.querySelector('input[name="tipoCitaUs"]:checked')
    horaAtSelecTemp = document.querySelector('input[name="horaAtenUs"]:checked')
    nameHistNew = document.getElementById('nameHistNew')
    usuario = tipoUsuario == 4 ? idUser : {
            dni : parseInt(inp_dni.value),
            nombre : inp_nombre.value,
            apellido : inp_apellido.value,
            celular : inp_celular.value,
            correo : inp_correo.value,
        }
    if(servSelecTempo){        
        if(catSelecTempo){             
            if(fechaSelecionada != ''){        
                if(tipoAtSelecTemp) {
                    if(horaAtSelecTemp) {
                        datos = {
                            histSelec : histSelecTempo ? histSelecTempo.value : nameHistNew.value,
                            histSelecE : histSelecTempo ? 'old' : 'new',
                            catSelec : catSelecTempo,
                            userSelec : pacienteId ? pacienteId : usuario,
                            userSelecE : pacienteId ? 'old' : (tipoUsuario == 4 ? 'old' : 'new'),
                            tipoAtSelec : tipoAtSelecTemp ? tipoAtSelecTemp.value : 0,
                            horaAtSelec : horaAtSelecTemp ? horaAtSelecTemp.value : 0,
                            fechaSelec : fechaSelecionada,
                        }
                        guardarCita(datos)
                        // console.log(datos); 
                    } else  alertaToastify('Escoge la hora de atención')
                } else alertaToastify('Escoge el tipo de atención')
            } else alertaToastify('Escoge un día habil')
        }else alertaToastify('Escoge la categoria')
    }else alertaToastify('Escoge el servicio')
}
function guardarCita(datos){
    dat = new FormData()
    dat.append('guardCitaUs',JSON.stringify(datos))
    fetch(URL+'ajax/citaAjax.php',{
        method : 'post',
        body : dat
    })
    .then( r => r.json())
    .then( r => {  
        if(r == 1){
            alertaToastify('Se grabo tu reserva','green',1500) 
            usuario = tipoUsuario == 2 || tipoUsuario == 4 ? 'ok' : limpiarInpTrat()            
            selectServGe.value = 0
            fechaSelecionada = ''
            document.getElementById('tipocitaSelect').innerHTML = ''
            document.getElementById('horasDisponibles').innerHTML = ''
            document.getElementById('historialNew').innerHTML = ''
            listHist = []
            $('#tbl_tratam').DataTable().destroy()
            leerListaTratamientos()
            $('#table2').DataTable().destroy()
            leerListaHistorial()

        }else alertaToastify('Error al grabar la reserva')
    })
}
function limpiarInpTrat(){
    inp_dni.value = ''
    inp_nombre.value = ''
    inp_apellido.value = ''
    inp_celular.value = ''
    inp_correo.value = ''
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
            $('#tbl_tratam').DataTable().destroy()
            leerListaTratamientos()
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
            if (result.value > 0) {
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
                    })
                    $('#tbl_tratam').DataTable().destroy()
                    leerListaTratamientos()
                }else{
                    console.log('mira aqui!!!');
                }
            })
            } else  alertaToastify('Debe ser un pago mayor a 0 soles')
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
                        $('#tbl_tratam').DataTable().destroy()
                        leerListaTratamientos()
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







