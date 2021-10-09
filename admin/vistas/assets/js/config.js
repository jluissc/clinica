citasAtencion = []
citasSelected = []

diasAtencion = []
diasSelected = []

listConfig = []
listServicss = []

users_permisos = []
permisos = []
permisosTempo = []
fechaSelecionada = ''
myModalss = new bootstrap.Modal(document.getElementById('xlarge')) 

leerHorasAtencion()

function leerHorasAtencion(){
    DATOS = new FormData()
    DATOS.append('horaAten', 'horaAten')
    fetch(URL+'ajax/configAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {        
        citasAtencion = r.tipoAtencion
        diasAtencion = r.diasAtencion
        filtrarConfig(r.listConfig)
        permisos = r.permisos
        listServicss = r.listServics
        filtrarUsers(r.users)
        listarServiciosss(r.listServics)
        
    })
}
function filtrarConfig(datos){
    datos.forEach(confg => {        
        if (listConfig.find(conf => conf.id == confg.config_id)) {            
            const confgList = listConfig.map( conff => {
                if( conff.id == confg.config_id ) {
                    conff.lista.push({
                        'id' : confg.id,
                        'dias' : confg.dias_id,
                        'tipo' : confg.tipo_cita_id,
                    })
                    return conff;
                } 
                else return conff;
            })
            listConfig = [...confgList];
        } else {
            listConfig.push({
                'id' : confg.config_id,
                'horainicio' : confg.horainicio,
                'horafin' : confg.horafin,
                'nombre' : confg.nombre,
                'lista' : [{
                    'id' : confg.id,
                    'dias' : confg.dias_id,
                    'tipo' : confg.tipo_cita_id,
                }]
            })
        }
    });
    HtmlListConfig()
}
function HtmlListConfig(){
    li = `<a class="" style="cursor:pointer" onclick="verConfig(0,1)" class="btn btn-outline-warning" data-bs-toggle="modal"
    data-bs-target="#xlarge">Crear Fechas de atención</a>`
    listConfig.forEach((confId,i) => {
        li+=`<a class="" style="cursor:pointer" onclick="verConfig(${confId.id},2)" class="btn btn-outline-warning" data-bs-toggle="modal"
        data-bs-target="#xlarge">config ${i+1}  ${confId.nombre}</a>`
    });
    document.getElementById('listarConfig').innerHTML = li
    
}
function listarServiciosss(listServi){
    lir = '<div class="list-group">'
    listServi.forEach(servc => {
        // lir+=`<a class="" style="cursor:pointer"  class="btn btn-outline-warning" data-bs-toggle="modal"
        // data-bs-target="#xlarge"></a>`
        lir+=`<a class="list-group-item list-group-item-action">${servc.nombre}  <button class="btn btn-info"><i class="fas fa-edit"></i></button><button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></a>`
    });
    lir+=`</div>`
    document.getElementById('listServcsss').innerHTML = lir
}
function verConfig(id,tipo){
    if(tipo == 1){
        mostrarDias()
        mostrarCrudCitas()
        document.getElementById('showBTNConfig').innerHTML = '<input type="button" class="btn btn-success" value="Guardar Config" onclick="validarConfig()">'
    }else if(tipo == 2){
        mostrarDias(id)
        mostrarCrudCitas(id)
        document.getElementById('showBTNConfig').innerHTML = ''
    }
}
function updateDia(id, idInp){
    if(diasSelected.find(dia=>dia.diaId == id)) diasSelected = diasSelected.filter(dia => dia.diaId != id)
    else diasSelected.push({'diaId' : id })
}
function updateCita(id, idInp){
    if(citasSelected.find(cita=>cita.citaId == id)) citasSelected = citasSelected.filter(cita => cita.citaId != id)
    else citasSelected.push({'citaId' : id })
    console.log(citasSelected);
}
function validarConfig(){
    if(diasSelected.length>0 ){
        if(citasSelected.length>0) guardarConfig()
        else alertaToastify('Seleccione al menos 1 tipo de cita')
    }
    else alertaToastify('Seleccione al menos 1 dia')
}
function guardarConfig(){
    nameConf =document.getElementById('nameConf').value
    horaInicio =document.getElementById('horaInicio').value
    horaFin =document.getElementById('horaFin').value
    if(horaInicio != '' && horaFin != ''){
        DATOS = new FormData()
        DATOS.append('saveConfig', 'saveConfig')
        DATOS.append('nameConf', nameConf)
        DATOS.append('horaInicio', horaInicio)
        DATOS.append('horaFin', horaFin)
        DATOS.append('diaSelect', JSON.stringify(diasSelected))
        DATOS.append('tipoSelect', JSON.stringify(citasSelected))
        fetch(URL+'ajax/configAjax.php',{
            method : 'post',
            body : DATOS
        })
        .then( r => r.text())
        .then( r => {
            mostrarCrudCitas()
            mostrarDias()
            citasSelected = []
            diasSelected = []
            alertaToastify('Se guardo configuración', 'green')
            leerHorasAtencion()
            myModalss.hide()
    
        })
    }else alertaToastify('Falta las horas')
    
}
function mostrarDias(id=0){
    diasConfir =[]
    div = ''
    if(id == 0){
        diasAtencion.forEach((dia,index) => {
            // estado = cita.estado == 1 ? 'checked' : '' 
            div +=`<li class="list-group-item">
            <input class="form-check-input me-1"  type="checkbox" id="diaId_${index}" onchange="updateDia(${dia.id},this.id)" aria-label="...">
            ${dia.nombre}
            </li>`
        });
    }else{
        listConfig.forEach(conff => {
            if(conff.id == id){
                conff.lista.forEach(day => {
                    if(diasConfir.find(dii => dii.id == day.dias)){
                        /* no hacer nada */
                    }else{
                        diasConfir.push({
                            'id' : day.dias
                        })
                    }
                });
                /* MOSTRAR LAS HORAS */
                a = document.getElementById('horaInicio')
                a.value = conff.horainicio
                a.disabled = true
                b = document.getElementById('horaFin')
                b.value = conff.horafin
                b.disabled = true
                /* MOSTRAR LAS HORAS */

            }
        });
        diasAtencion.forEach((dia,index) => {
            estado = diasConfir.find(di => di.id == dia.id) ? 'checked' : '' 
            div +=`<li class="list-group-item">
            <input class="form-check-input me-1" ${estado} disabled type="checkbox" id="diaId_${index}" onchange="updateDia(${dia.id},this.id)" aria-label="...">
            ${dia.nombre}
            </li>`
        });
    }
    document.getElementById('listarDiasA').innerHTML = div
        
}
function mostrarCrudCitas(id=0,idSelect='listaCitaCrud'){    
    tipoConfir =[]
    div = ''
    if(id == 0){
        citasAtencion.forEach((cita,index) => {
            div +=`<li class="list-group-item">
                    <input class="form-check-input me-1" type="checkbox" id="citaId_${index}" onchange="updateCita(${cita.id},this.id)" aria-label="...">
                    ${cita.nombre}
                </li>`
        });
    }else{
        listConfig.forEach(conff => {
            if(conff.id == id){
                conff.lista.forEach(type => {
                    if(tipoConfir.find(typ => typ.id == type.tipo)){
                        /* no hacer nada */
                    }else{
                        tipoConfir.push({
                            'id' : type.tipo
                        })
                    }
                });
            }
        });
        citasAtencion.forEach((cita,index) => {
            estado = tipoConfir.find(di => di.id == cita.id) ? 'checked' : '' 
            div +=`<li class="list-group-item">
                    <input class="form-check-input me-1" ${estado} disabled type="checkbox" id="citaId_${index}" onchange="updateCita(${cita.id},this.id)" aria-label="...">
                    ${cita.nombre}
                </li>`
        });
    }


    document.getElementById(idSelect).innerHTML = div
    // document.getElementById('listaCitaCrudT').innerHTML = div

}
function mostrarTipoC(){
    mostrarCrudCitas(0,'listaCitaCrudT')
}
function filtrarUsers(users){
    users.forEach(user => {
        if(users_permisos.some( userInt => userInt.persona_id == user.persona_id)){
            const usersInt = users_permisos.map( userInt => {
                if( userInt.persona_id == user.persona_id ) {
                    userInt.permisos.push({ 
                        'idp': user.id, 
                        'permisos_id': user.permisos_id, 
                    })
                    return userInt;
                } 
                else return userInt;
            })
            users_permisos = [...usersInt];
        }else{
            users_permisos.push({
                'persona_id': user.persona_id, 
                'nombre': user.nombre, 
                'correo': user.correo,                     
                'tipo_user_id': user.tipo_user_id,                     
                'permisos' : [{ 
                    'idp': user.id, 
                    'permisos_id': user.permisos_id, 
                }]
            }, 
            );
        }
    }); 
    mostrarListaColaboradores()
}
function mostrarListaColaboradores(){
    div = ''
    users_permisos.forEach(user => {
        div+= `<div class="recent-message d-flex px-4 py-3 colaborador" onclick="listaPermiso(${user.persona_id})"id="jjdjdj" >
                <div class="avatar avatar-lg">
                    <img src="${URL}vistas/assets/images/faces/4.jpg">
                </div>
                <div class="name ms-4">
                    <h5 class="mb-1">${user.nombre}</h5>
                    <h6 class="text-muted mb-0">${user.correo}</h6>
                </div>
            </div>`
    });
    document.getElementById('listaColabor').innerHTML = div
}
function listaPermiso(user_id){
    user = users_permisos.find( userInt => userInt.persona_id == user_id)
    div = ''
    permisos.forEach(permiso => {
        estado = user.permisos.some( permisoInt => permisoInt.permisos_id == permiso.id) ? 'checked' : ''
        div += `<li class="list-group-item" >
            <input class="form-check-input me-1" ${estado}  type="checkbox" 
                id="${permiso.id}" onchange="updatePermisUser(this.id,${user.persona_id})" aria-label="...">
            ${permiso.nombre}
        </li>`
    });
    document.getElementById('permisosUser').innerHTML = div
}
function updatePermisUser(idInput, user_id){
    DATOS = new FormData()
    DATOS.append('tipoPerm', idInput)
    DATOS.append('user_idPerm', user_id)
    fetch(URL+'ajax/configAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        users_permisos = []
        leerHorasAtencion()
    })
}
function selectPermis(id){
    if(document.getElementById(`permi_${id}`).checked){
    }
    if (permisosTempo.find(perTem => perTem.id == id )) {
        permisosTempo = permisosTempo.filter(perT => perT.id != id)
    } else {
       permisosTempo.push({
           'id' : id
       }) 
    }
}

 
function horaEnSegundos(q){
    return q * 60 * 60;
}
 
function minutosEnSegundos(q=60){
    return q * 60;
}
horasSeleccionadas =[{'id':1,'hora':'08:00:00'}]
function hhhhhh(inicio, fin, tiempo,cont,initt){
    var hora = 3600;
    var horaInicio = horaEnSegundos(inicio);
    var horaFin = horaEnSegundos(fin);
    var progresion = minutosEnSegundos(tiempo);
    horasSeleccionadas.push(initt)
    cant = cont;
    while(horaInicio < horaFin){
        horaInicio = horaInicio + progresion;
    
        var hora = parseInt( horaInicio / 3600 ) % 24;
        var minutos = parseInt( horaInicio / 60 ) % 60;
        var segundos = horaInicio % 60;
    
        var resultado = (hora < 10 ? "0" + hora : hora) + ":" + (minutos < 10 ? "0" + minutos : minutos) + ":" + (segundos  < 10 ? "0" + segundos : segundos);
        horasSeleccionadas.push({'id':cant,'hora':resultado})
        cant ++
    }
}
function filtrarHours(){
    horasSeleccionadas = []
    tiempo = parseInt(document.getElementById('prectiemserv').value)
    hhhhhh(8, 13, tiempo, 2,{'id':1,'hora':'08:00:00'})
    hhhhhh(15, 20, tiempo, 31,{'id':30,'hora':'15:00:00'})
    
    horasSeleccionadas = horasSeleccionadas.filter(hour => hour.hora >='08:00:00' && hour.hora < '19:00:00')
    console.log(horasSeleccionadas);
    li = ''
    horasSeleccionadas.forEach(hora => {
        li += `<li class="list-group-item">
        <input class="form-check-input me-1" checked  type="checkbox" id="horaId_${hora.id}" onchange="quitarHoraAtenc(${hora.id},'${hora.hora}')" aria-label="...">
        ${hora.hora}
        </li>`
    });
    document.getElementById('listHoursDisp').innerHTML = li
}
function quitarHoraAtenc(id, hora){
    if(horasSeleccionadas.find(hour => hour.id == id)){
        horasSeleccionadas = horasSeleccionadas.filter(hour => hour.id != id)
    }else{
        horasSeleccionadas.push({'id':id,'hora':hora})        
    }
    console.log(horasSeleccionadas);
}
 

function saveServicio(){
    myModallarge3 = new bootstrap.Modal(document.getElementById('large3'))
    datos = new FormData()
    datos.append('nameserv',document.getElementById('nameserv').value)
    datos.append('descripserv',document.getElementById('descripserv').value)
    datos.append('precNserv',document.getElementById('precNserv').value)
    datos.append('precOserv',document.getElementById('precOserv').value)
    datos.append('prectiemserv',document.getElementById('prectiemserv').value)
    datos.append('citaSelectt',JSON.stringify(citasSelected))
    datos.append('horasSelect',JSON.stringify(horasSeleccionadas))

    /*  */
    /*  */

    fetch(URL+'ajax/configAjax.php',{
        method : 'POST',
        body : datos
    })
    .then( r => r.json())
    .then( r => {
        console.log(r);
        // if(r == 1){
        alertaToastify('Se guardo servicio','green',1500)
        document.getElementById('nameserv').value = ''
        document.getElementById('descripserv').value = ''
        document.getElementById('precNserv').value = ''
        document.getElementById('precOserv').value = ''
        document.getElementById('prectiemserv').value = ''
        leerHorasAtencion()
        document.getElementById('citaId_0').checked = false            
        document.getElementById('citaId_1').checked = false            
        document.getElementById('citaId_2').checked = false
        citasSelected = []
        horasSeleccionadas.forEach(hora => {
            document.getElementById(`horaId_${hora.id}`).checked = false
        });
        citasAtencion.forEach((hora,index) => {
            document.getElementById(`citaId_${index}`).checked = false
        });
        horasSeleccionadas = []
        // setTimeout(() => {
            myModallarge3.hide()
        // }, 1500);

        // }
    })
    .catch(e => alertaToastify('Comunicate con soporte','red',1500))

    
}
function saveUsuario(){
    myModallarge2 = new bootstrap.Modal(document.getElementById('large2'))
    datos = new FormData()
    datos.append('dni_appoint',document.getElementById('dni').value)
    datos.append('name_appoint',document.getElementById('nombre').value)
    datos.append('last_appoint',document.getElementById('apellido').value)
    datos.append('celphone_appoint',document.getElementById('celular').value)
    datos.append('email_appoint',document.getElementById('correo').value)
    datos.append('permisosTemp',JSON.stringify(permisosTempo))

    fetch(URL+'ajax/configAjax.php',{
        method : 'POST',
        body : datos
    })
    .then( r => r.json())
    .then( r => {
        console.log(r);
        // if(r == 1){
        alertaToastify('Se guardo usuario','green',1500)
        document.getElementById('dni').value = ''
        document.getElementById('nombre').value = ''
        document.getElementById('apellido').value = ''
        document.getElementById('celular').value = ''
        document.getElementById('correo').value = ''
        permisosTempo.forEach(element => {
            document.getElementById(`permi_${element.id}`).checked = false
        });
        leerHorasAtencion()
        permisosTempo = []
        setTimeout(() => {
            myModallarge2.hide()
        }, 1500);

        // }
    })
    .catch(e => alertaToastify('Probablemente tu dni ya existe en nuestros datos','red',1500))

    
}



/* ******************************************** */



