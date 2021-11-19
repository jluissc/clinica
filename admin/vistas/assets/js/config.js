citasAtencion = [] /* general tipo atencion */
diasAtencion = [] /* general dias atencion */
categorias = [] /* categorias existente */


// campos del modal servicio general
inp_name = document.getElementById('name_serv')
inp_status = document.getElementById('stat_serv')
servicGenrModal = new bootstrap.Modal(document.getElementById('servicGenr'))
listServicss = [] /* listar los servicios */
servSelec = [] /* servicio selecionado al momento de eliminar */

// campos del modal categorias
categModal = new bootstrap.Modal(document.getElementById('categModal')) 
inp_name_cat = document.getElementById('name_cat')
inp_descrip_cat = document.getElementById('descrip_cat')
inp_precN_cat = document.getElementById('precN_cat')
inp_precO_cat = document.getElementById('precO_cat')
inp_prectiem_cat = document.getElementById('prectiem_cat')
inp_status_cat = document.getElementById('stat_cat')
horasSeleccionadas = [] /* horas probables al crear un servicio */
tipAtencSeleccionadas = [] /* horas probables al crear un servicio */
diasSeleccionadas = [] /* dias probables al crear un servicio */
htmlULHorasDisp = document.getElementById('listHoursDisp')
btn_categ = document.getElementById('btn_categ')
catSelec = [] /* servicio selecionado al momento de eliminar */


citasSelected = []

diasSelected = []

listConfig = []

users_permisos = []
permisos = []
permisosTempo = []
fechaSelecionada = ''



 

// myModallarge3 = new bootstrap.Modal(document.getElementById('large3'))
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
        listarServiciosss(r.listServics)
        filtrarConfig(r.listConfig)
        citasAtencion = r.tipoAtencion
        diasAtencion = r.diasAtencion
        categorias = r.listCategs
        // permisos = r.permisos
        // listServicss = r.listServics
        // filtrarUsers(r.users)
        
    })
}
function filtrarConfig(datos){
    console.log(datos);
    datos.forEach(confg => {        
        if (listConfig.find(conf => conf.id == confg.c_id)) {            
            const confgList = listConfig.map( conff => {
                if( conff.id == confg.c_id ) {
                    conff.lista.push({
                        'id' : confg.dt_id,
                        'dias' : confg.dias_id,
                        'tipo' : confg.tipo_atencion,
                    })
                    return conff;
                } 
                else return conff;
            })
            listConfig = [...confgList];
        } else {
            listConfig.push({
                'id' : confg.c_id,
                'horainicio' : confg.horaInicio,
                'horafin' : confg.horaFin,
                'nombre' : confg.nombre,
                'codigo' : confg.codigo,
                'serv_id' : confg.s_id,
                'serv_nombre' : confg.servicio,
                'lista' : [{
                    'id' : confg.dt_id,
                    'dias' : confg.dias_id,
                    'tipo' : confg.tipo_atencion,
                }]
            })
        }
    });
    // HtmlListConfig()
    console.log(listConfig);
}
function listarServiciosss(listServi){
    listServicss = []
    listServi.forEach(servicio => {
        if(listServicss.some( servInt => servInt.id == servicio.sg_id)){
            const usersInt = listServicss.map( servInt => {
                if( servInt.id == servicio.sg_id ) {
                    servInt.categorias.push({ 
                        'id': servicio.s_id,  
                        'nombre': servicio.cat,  
                        'descripcion': servicio.descripcion,  
                        'precio_normal': servicio.precio_normal,  
                        'precio_venta': servicio.precio_venta,  
                        'estado': servicio.s_est,  
                        'tiempo': servicio.tiempo,  
                    })
                    return servInt;
                } 
                else return servInt;
            })
            listServicss = [...usersInt];
        }else{
            id_cat = servicio.s_id ? servicio.s_id : 0 /* si es no existe categorias del servicio */
            listServicss.push({
                'id': servicio.sg_id, 
                'nombre': servicio.serv, 
                'estado': servicio.sg_est,                     
                'categorias' : [{ 
                    'id': id_cat,  
                    'nombre': servicio.cat,  
                    'descripcion': servicio.descripcion,  
                    'precio_normal': servicio.precio_normal,  
                    'precio_venta': servicio.precio_venta,  
                    'estado': servicio.s_est,  
                    'tiempo': servicio.tiempo,  
                }]
            }, 
            );      
        }
    }); 
    HTMLServicios()
}
function HTMLServicios(){
    lir = '<div class="list-group">'
    listServicss.forEach(servc => {
        // lir+=`<a class="" style="cursor:pointer"  class="btn btn-outline-warning" data-bs-toggle="modal"
        // data-bs-target="#xlarge"></a>`
        lir+=`<a class="list-group-item list-group-item-action"  style="background-color: #1aefe1"> ${servc.nombre}  
            <button class="btn btn-info" onclick="tipoModalServc(${servc.id})"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" onclick="alertServicio(${servc.id},1)"><i class="fas fa-trash-alt"></i></button>
            <button class="btn btn-primary" onclick="tipoModalCateg(${servc.id},0)"><i class="fas fa-plus-square"></i></button></a>`
            servc.categorias.forEach((categoria, key) => {
                if(categoria.id != 0){
                    lir+=`<a class="list-group-item list-group-item-action" >${key+1} :  ${categoria.nombre}
                    <button class="btn btn-info" onclick="tipoModalCateg(${categoria.id},1)"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" onclick="alertServicio(${servc.id})"><i class="fas fa-trash-alt"></i></button></a> `
                }
            });
    });
    lir+=`</div>`
    document.getElementById('listServcsss').innerHTML = lir
}
function tipoModalServc(id){/* 0 abrir */
    if (id) { /* Editar servicio */
        listServicss.forEach(servi => {
            if(servi.id == id){
                servSelec = {
                    id : servi.id, 
                    name : servi.nombre,
                    status : servi.estado, 
                }
                inp_name.value = servi.nombre
                inp_status.value = servi.estado
            }
        });
        btn = `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="validServc(1)">Editar</button>`
        document.getElementById('btn_serv').innerHTML = btn 
    } else {/* Crear servicio */
        inp_name.value = ''
        inp_status.value = 0
        console.log('Crear servicio'); 
        btn = `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="validServc(0)">Guardar</button>`
        document.getElementById('btn_serv').innerHTML = btn       
    }
    servicGenrModal.show()
}
function tipoModalCateg(id,tipo){/* id, ----- tipo 0 es nuevo, 1 crear */
    servSelec = id
    if (tipo) { /* Editar servicio */
        datosCategoria(id)        
    } else {/* Crear servicio */
        resetInputCateg()
        btn = `<button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Cancelar</span>
            </button>
            <button type="button" class="btn btn-primary ml-1 "  onclick="validCateg(0)">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Guardar</span>
            </button>`
        btn_categ.innerHTML = btn 
        listarHoras(0)
        listarDias(0)
    }
    categModal.show()
}

function datosCategoria(id){
    DATOS = new FormData()
    DATOS.append('datosCateg', id)
    fetch(URL+'ajax/configAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        horasSeleccionadas = r.horas
        // tipAtencSeleccionadas = r.servics
        rellenarHorasCatg()
        rellenarTipoCat(r.servics)
        rellenarDiasCat(r.servics)
        console.log(tipAtencSeleccionadas);
        categorias.forEach(cat => {
            if(cat.id == id){
                catSelec = {
                    id : cat.id, 
                    name : cat.nombre, 
                }
                console.log('Si existe ');
                console.log(catSelec);
                inp_name_cat.value = cat.nombre
                inp_descrip_cat.value = cat.descripcion
                inp_precN_cat.value = cat.precio_normal
                inp_precO_cat.value = cat.precio_venta
                inp_prectiem_cat.value = cat.tiempo
                inp_status_cat.value = cat.estado
            }
        });
        console.log(tipAtencSeleccionadas);
        console.log('Editar servicio');
        btn = `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="validCateg(1)">Editar</button>`
        btn_categ.innerHTML = btn 
    })
}
function rellenarHorasCatg(){
    li = ''
    horasSeleccionadas.forEach(hora => {
        li += `<li class="list-group-item">
        <input class="form-check-input me-1" checked  type="checkbox" onchange="quitarHoraAtenc(${hora.id},'${hora.hora}')">
        ${hora.hora}
        </li>`
    });
    htmlULHorasDisp.innerHTML = li
}
function rellenarTipoCat(datos){
    datos.forEach(tipo => {
        if(tipAtencSeleccionadas.find(tip => tip.id == tipo.tipo_cita_id)) console.log('existe')
        else tipAtencSeleccionadas.push({id : tipo.tipo_cita_id})
    }); 
    div = ''
    citasAtencion.forEach(atencion => {
        estado = tipAtencSeleccionadas.find(tip => tip.id == atencion.id) ? 'checked' :''
        div +=`<li class="list-group-item">
            <input class="form-check-input me-1" type="checkbox" ${estado} onchange="updateAtencion(${atencion.id})">
            ${atencion.nombre}
            </li>`
        })
    document.getElementById('listaCitaCrudT').innerHTML = div
}
function rellenarDiasCat(datos){
    diasSeleccionadas = []
    datos.forEach(dia => {
        if(diasSeleccionadas.find(day => day.id == dia.dias_id)) console.log('existe')
        else diasSeleccionadas.push({id : dia.dias_id})
    });
    listarDias(diasSeleccionadas)
    // div = ''
    // diasAtencion.forEach(dia => {
    //     estado = diasSeleccionadas.find(tip => tip.id == dia.id) ? 'checked' :''
    //     div +=`<li class="list-group-item">
    //             <input class="form-check-input me-1"  ${estado}  type="checkbox" onchange="updateDia(${dia.id})">
    //             ${dia.nombre}
    //         </li>`
    //     });
    // document.getElementById('listDiasDisp').innerHTML = div
}
function listarHoras(tipo){
    div = ''
    citasAtencion.forEach(atencion => {
        div +=`<li class="list-group-item">
                <input class="form-check-input me-1" type="checkbox" onchange="updateAtencion(${atencion.id})">
                ${atencion.nombre}
            </li>`
        });
    document.getElementById('listaCitaCrudT').innerHTML = div
}
function listarDias(tipo = ''){
    console.log(tipo);
    div = ''
    diasAtencion.forEach(dia => {
        estado = tipo != '' ? (tipo.find(tip => tip.id == dia.id) ? 'checked' :'') : ''
        div +=`<li class="list-group-item">
                <input class="form-check-input me-1" ${estado} type="checkbox" onchange="updateDia(${dia.id})">
                ${dia.nombre}
            </li>`
        });
    document.getElementById('listDiasDisp').innerHTML = div
}
function updateAtencion(idTipo){
    if(tipAtencSeleccionadas.find(tipo => tipo.id == idTipo)){
        tipAtencSeleccionadas = tipAtencSeleccionadas.filter(tipo => tipo.id != idTipo)
    }else{
        tipAtencSeleccionadas.push({id:idTipo})        
    }
    console.log(tipAtencSeleccionadas);
}
function updateDia(idDia){
    if(diasSeleccionadas.find(day => day.id == idDia)){
        diasSeleccionadas = diasSeleccionadas.filter(day => day.id != idDia)
    }else{
        diasSeleccionadas.push({id:idDia})        
    }
    console.log(diasSeleccionadas);
}
function validCateg(tipo){
    if(inp_name_cat.value != ''){
        // if(inp_descrip_cat.value != ''){
        if(inp_precN_cat.value != ''){
            if(inp_precO_cat.value != ''){
                if(inp_prectiem_cat.value != ''){
                    if(tipAtencSeleccionadas.length > 0){
                        if(diasSeleccionadas.length > 0){
                            tableCategoria(tipo)
                        }else alertaToastify('Completar dias de atención')
                    }else alertaToastify('Completar tipo de atención')
                }else alertaToastify('Completar tiempo de servicio')
            }else alertaToastify('Completar precio venta')
        }else alertaToastify('Completar precio normal')
        // }else alertaToastify('Completar description')
    }else alertaToastify('Completar nombre')
}
function validServc(tipo){
    if(inp_name.value != ''){
        tableServicio(tipo)
    }else{
        alertaToastify('Completar nombre')
    }
}
function tableCategoria(tipo){/* crear, editar, eliminar un servicio general */
    datos = new FormData()
    datos.append('name_cat',inp_name_cat.value)
    datos.append('descrip_cat',inp_descrip_cat.value)
    datos.append('precN_cat',inp_precN_cat.value)
    datos.append('precO_cat',inp_precO_cat.value)
    datos.append('prectiem_cat',inp_prectiem_cat.value)
    datos.append('status_cat',inp_status_cat.value)
    datos.append('horasSelect',JSON.stringify(horasSeleccionadas))
    datos.append('tiposSelect',JSON.stringify(tipAtencSeleccionadas))   
    datos.append('diasSelect',JSON.stringify(diasSeleccionadas))   
    datos.append('tipo_cat',tipo)
    datos.append('id_serv',servSelec)
    fetch(URL+'ajax/configAjax.php',{
        method : 'POST',
        body : datos
    })
    .then( r => r.json())
    .then( r => {
        if(r){
            listarServiciosss(r)
            !tipo ? alertaToastify('Servicio guardado','green') : alertaToastify('Servicio editado','green')
            resetInputCateg()
            categModal.hide()
        }else{
            alertaToastify('No se pudo guardar')            
        }
    })
}
function tableServicio(tipo){/* crear, editar, eliminar un servicio general */
    datos = new FormData()
    datos.append('serv_name',inp_name.value)
    datos.append('serv_status',inp_status.value)
    datos.append('serv_addEdit',!tipo ? tipo : servSelec.id )
    fetch(URL+'ajax/configAjax.php',{
        method: 'POST', 
        body: datos
    })
    .then(r => r.json())
    .then(r => {
        if(r){
            listarServiciosss(r)
            !tipo ? alertaToastify('Servicio guardado','green') : alertaToastify('Servicio editado','green')
            inp_name.value = ''
            inp_status.value = 0
            servicGenrModal.hide()
        }else{
            alertaToastify('No se pudo guardar')            
        }
    })
}
function alertServicio(idServici, tipo ){/* id , tipo(1 servicio, 2 categoria) */
    message = tipo == 1 ? 'el servicio' : 'la categoria'
    Swal.fire({
        title: '¿Seguro de eliminar?',
        text: "Se eliminará definitivamente "+message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteServicio(idServici,tipo)
            console.log('eliminado....');
        }else{
            alertaToastify('Se cancelo la eliminación','#12d3dc',2000)
        }
    })
}
function deleteServicio(idServici,tipo){
    message = tipo == 1 ? 'el servicio' : 'la categoria'
    console.log(idServici);
    console.log(tipo);
    datos = new FormData()
    datos.append('idServiciD',idServici)
    datos.append('tipoServ',tipo)
    fetch(URL+'ajax/configAjax.php',{
        method: 'POST', 
        body: datos
    })
    .then(r => r.json())
    .then(r => {
        servSelec = []
        listarServiciosss(r)
        tipo == 1 ? alertaToastify('Servicio eliminado','green') : alertaToastify('Categoria eliminado','green')
    } )
    .catch(e => console.log(e))
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
    tiempo = parseInt(document.getElementById('prectiem_cat').value)
    hhhhhh(8, 13, tiempo, 2,{'id':1,'hora':'08:00:00'})
    hhhhhh(15, 20, tiempo, 31,{'id':30,'hora':'15:00:00'})
    
    horasSeleccionadas = horasSeleccionadas.filter(hour => hour.hora >='08:00:00' && hour.hora < '19:00:00')
    li = ''
    horasSeleccionadas.forEach(hora => {
        li += `<li class="list-group-item">
        <input class="form-check-input me-1" checked  type="checkbox" onchange="quitarHoraAtenc(${hora.id},'${hora.hora}')">
        ${hora.hora}
        </li>`
    });
    htmlULHorasDisp.innerHTML = li
}
function quitarHoraAtenc(id, hora){
    if(horasSeleccionadas.find(hour => hour.id == id)){
        horasSeleccionadas = horasSeleccionadas.filter(hour => hour.id != id)
    }else{
        horasSeleccionadas.push({'id':id,'hora':hora})        
    }
    console.log(horasSeleccionadas);
}



function resetInputCateg(){
    inp_name_cat.value = ''
    inp_descrip_cat.value = ''
    inp_precN_cat.value = ''
    inp_precO_cat.value = ''
    inp_prectiem_cat.value = ''
    inp_status_cat.value = 0
    horasSeleccionadas = []
    tipAtencSeleccionadas = []
    diasSeleccionadas = []
    htmlULHorasDisp.innerHTML = ''
}
 
// function HtmlListConfig(){
//     console.log(listConfig);
//     li = `<div class="list-group"> `
//     listConfig.forEach((confId,i) => {
//         li+=`<a class="list-group-item list-group-item-action" style="cursor:pointer" onclick="verConfig(${confId.id},2)" >
//             Config ${i+1}:  ${confId.nombre} <button class="btn btn-info" data-bs-toggle="modal"  data-bs-target="#xlarge"><i class="far fa-eye"></i></button></a>`
//     });
//     li+=`</div>`
//     document.getElementById('listarConfig').innerHTML = li
    
// }


// tipoDeCitaAddd = []
// function showServic(id, tipo){
//     datos = new FormData()
//     datos.append('idServiConf', id)
//     fetch(URL+'ajax/configAjax.php',{
//         method : 'POST',
//         body : datos,
//     })
//     .then( r => r.json())
//     .then(r => {
//         console.log(r);
//         tipoDeCitaAddd = r.tipo
//         updateTipCita = r.tipo
//         console.log('tipoDeCitaAddd');
//         console.log(tipoDeCitaAddd);
//         HMTLConfigServv(r);
        
//     })
// }
// idServicEdit = 0

// function HMTLConfigServv(datos){
//     idServicEdit = datos.servicio.id 
//     // datos principales
//     nameservC = document.getElementById('nameserv')
//     descripservC = document.getElementById('descripserv')
//     precNservC = document.getElementById('precNserv')
//     precOservC = document.getElementById('precOserv')
//     prectiemserv = document.getElementById('prectiemserv')
//     nameservC.value = datos.servicio.nombre
//     descripservC.value = datos.servicio.descripcion
//     precNservC.value = datos.servicio.precio_normal
//     precOservC.value = datos.servicio.precio_venta
//     prectiemserv.value = datos.servicio.tiempo
//     prectiemserv.disabled = true
//     li =''
//     datos.horas.forEach(hora => {
//         li += `<li class="list-group-item">
//         <input class="form-check-input me-1" checked  type="checkbox" id="horaId_${hora.id}" onchange="quitarHoraConf(${hora.id},'${hora.hora}')" aria-label="...">
//         ${hora.hora}
//         </li>`
//     });
//     document.getElementById('listHoursDisp').innerHTML = li

//     div = ''
//     citasAtencion.forEach((cita,index) => {
//         estado = datos.tipo.find(type => type.tipo_cita_id == cita.id) ? 'checked' : ''
//         div +=`<li class="list-group-item">
//                 <input class="form-check-input me-1" type="checkbox" ${estado} id="citaId_${index}" disabled aria-label="...">
//                 ${cita.nombre}
//             </li>`
//         });
//         // div +=`<li class="list-group-item">
//         //         <input class="form-check-input me-1" type="checkbox" ${estado} id="citaId_${index}" onchange="updateTipoCita(${cita.id})" aria-label="...">
//         //         ${cita.nombre}
//         //     </li>`
//         // });
//     document.getElementById('listaCitaCrudT').innerHTML = div
//     document.getElementById('btnEstadoServicio').innerHTML = `<button type="button" class="btn btn-primary ml-1 "  onclick="saveServicio(1)">
//             <i class="bx bx-check d-block d-sm-none"></i>
//             <span class="d-none d-sm-block">Editar</span>
//         </button>`
//     // updateTipCita = datos.tipo
// }

// function quitarHoraConf(id, hora){
//     if(horasQuitar.find(hour => hour.id == id)){
//         horasQuitar = horasQuitar.filter(hour => hour.id != id)
//     }else{
//         horasQuitar.push({'id':id,'hora':hora})        
//     }
//     console.log(horasQuitar);
// }

// function updateTipoCita(id){

//     if(updateTipCita.find(cita=>cita.tipo_cita_id == id)) {
//         // if(updateTipCita.find(cita=>cita.id != 0)){
//             const citaUp = updateTipCita.map( cit => {
//                 if( cit.id != 0 ) {
//                     // let cantidad = parseInt(curso.cantidad);
//                     // cantidad++
//                     cit.estado = 0;
//                     return cit;
//                } 
                
//             })
//             updateTipCita = [...citaUp];
//         // }else{
//         //     updateTipCita = updateTipCita.filter(cita => cita.tipo_cita_id != id)
//         // }
        
//         // updateTipCita = updateTipCita.filter(cita => cita.tipo_cita_id != id)
//     }
//     else {
//         updateTipCita.push({'tipo_cita_id' : id, 'servicios_id' : idServicEdit, 'id' : 0, 'estado' :0 })
//     }
//     console.log(updateTipCita);
// }
// function verConfig(id,tipo){
//     if(tipo == 1){
//         mostrarDias()
//         mostrarCrudCitas()
//         document.getElementById('showBTNConfig').innerHTML = '<input type="button" class="btn btn-success" value="Guardar Config" onclick="validarConfig()">'
//     }else if(tipo == 2){
//         mostrarDias(id)
//         mostrarCrudCitas(id)
//         document.getElementById('showBTNConfig').innerHTML = ''
//     }
// }
// function updateDia(id, idInp){
//     if(diasSelected.find(dia=>dia.diaId == id)) diasSelected = diasSelected.filter(dia => dia.diaId != id)
//     else diasSelected.push({'diaId' : id })
// }
// function updateCita(id, idInp){
//     if(citasSelected.find(cita=>cita.citaId == id)) citasSelected = citasSelected.filter(cita => cita.citaId != id)
//     else citasSelected.push({'citaId' : id })
//     console.log(citasSelected);
// }
// function validarConfig(){
//     if(diasSelected.length>0 ){
//         if(citasSelected.length>0) guardarConfig()
//         else alertaToastify('Seleccione al menos 1 tipo de cita')
//     }
//     else alertaToastify('Seleccione al menos 1 dia')
// }
// function guardarConfig(){
//     nameConf =document.getElementById('nameConf').value
//     horaInicio =document.getElementById('horaInicio').value
//     horaFin =document.getElementById('horaFin').value
//     if(horaInicio != '' && horaFin != ''){
//         DATOS = new FormData()
//         DATOS.append('saveConfig', 'saveConfig')
//         DATOS.append('nameConf', nameConf)
//         DATOS.append('horaInicio', horaInicio)
//         DATOS.append('horaFin', horaFin)
//         DATOS.append('diaSelect', JSON.stringify(diasSelected))
//         DATOS.append('tipoSelect', JSON.stringify(citasSelected))
//         fetch(URL+'ajax/configAjax.php',{
//             method : 'post',
//             body : DATOS
//         })
//         .then( r => r.text())
//         .then( r => {
//             mostrarCrudCitas()
//             mostrarDias()
//             citasSelected = []
//             diasSelected = []
//             alertaToastify('Se guardo configuración', 'green')
//             leerHorasAtencion()
//             myModalss.hide()
    
//         })
//     }else alertaToastify('Falta las horas')
    
// }
// function mostrarDias(id=0){
//     diasConfir =[]
//     div = ''
//     if(id == 0){
//         diasAtencion.forEach((dia,index) => {
//             // estado = cita.estado == 1 ? 'checked' : '' 
//             div +=`<li class="list-group-item">
//             <input class="form-check-input me-1"  type="checkbox" id="diaId_${index}" onchange="updateDia(${dia.id},this.id)" aria-label="...">
//             ${dia.nombre}
//             </li>`
//         });
//     }else{
//         listConfig.forEach(conff => {
//             if(conff.id == id){
//                 conff.lista.forEach(day => {
//                     if(diasConfir.find(dii => dii.id == day.dias)){
//                         /* no hacer nada */
//                     }else{
//                         diasConfir.push({
//                             'id' : day.dias
//                         })
//                     }
//                 });
//                 /* MOSTRAR LAS HORAS */
//                 a = document.getElementById('horaInicio')
//                 a.value = conff.horainicio
//                 a.disabled = true
//                 b = document.getElementById('horaFin')
//                 b.value = conff.horafin
//                 b.disabled = true
//                 /* MOSTRAR LAS HORAS */

//             }
//         });
//         diasAtencion.forEach((dia,index) => {
//             estado = diasConfir.find(di => di.id == dia.id) ? 'checked' : '' 
//             div +=`<li class="list-group-item">
//             <input class="form-check-input me-1" ${estado} disabled type="checkbox" id="diaId_${index}" onchange="updateDia(${dia.id},this.id)" aria-label="...">
//             ${dia.nombre}
//             </li>`
//         });
//     }
//     document.getElementById('listarDiasA').innerHTML = div
        
// }
// function mostrarCrudCitas(id=0,idSelect='listaCitaCrud'){    
//     tipoConfir =[]
//     div = ''
//     if(id == 0){
//         citasAtencion.forEach((cita,index) => {
//             div +=`<li class="list-group-item">
//                     <input class="form-check-input me-1" type="checkbox" id="citaId_${index}" onchange="updateCita(${cita.id},this.id)" aria-label="...">
//                     ${cita.nombre}
//                 </li>`
//             });
//         console.log('auuuuu');
//     }else{
//         console.log('auiii');
//         listConfig.forEach(conff => {
//             if(conff.id == id){
//                 conff.lista.forEach(type => {
//                     if(tipoConfir.find(typ => typ.id == type.tipo)){
//                         /* no hacer nada */
//                     }else{
//                         tipoConfir.push({
//                             'id' : type.tipo
//                         })
//                     }
//                 });
//             }
//         });
//         citasAtencion.forEach((cita,index) => {
//             estado = tipoConfir.find(di => di.id == cita.id) ? 'checked' : '' 
//             div +=`<li class="list-group-item">
//                     <input class="form-check-input me-1" ${estado} disabled type="checkbox" id="citaId_${index}" onchange="updateCita(${cita.id},this.id)" aria-label="...">
//                     ${cita.nombre}
//                 </li>`
//         });
//     }


//     document.getElementById(idSelect).innerHTML = div
//     // document.getElementById('listaCitaCrudT').innerHTML = div

// }
// function mostrarTipoC(id=0){
//     document.getElementById('nameserv').value = ''
//     document.getElementById('descripserv').value = ''
//     document.getElementById('precNserv').value = ''
//     document.getElementById('precOserv').value = ''
//     document.getElementById('prectiemserv').value = ''
//     document.getElementById('prectiemserv').disabled = false
//     div = ''
//     citasAtencion.forEach((cita,index) => {
//         div +=`<li class="list-group-item">
//                 <input class="form-check-input me-1" type="checkbox" id="citaId_${index}" onchange="updateCita(${cita.id},this.id)">
//                 ${cita.nombre}
//             </li>`
//     });
//     document.getElementById('listaCitaCrudT').innerHTML = div
//     document.getElementById('listHoursDisp').innerHTML = ''
//     document.getElementById('btnEstadoServicio').innerHTML = `<button type="button" class="btn btn-primary ml-1 "  onclick="saveServicio(0)">
//             <i class="bx bx-check d-block d-sm-none"></i>
//             <span class="d-none d-sm-block">Guardar</span>
//         </button>`
// }
// function filtrarUsers(users){
//     users.forEach(user => {
//         if(users_permisos.some( userInt => userInt.persona_id == user.persona_id)){
//             const usersInt = users_permisos.map( userInt => {
//                 if( userInt.persona_id == user.persona_id ) {
//                     userInt.permisos.push({ 
//                         'idp': user.id, 
//                         'permisos_id': user.permisos_id, 
//                     })
//                     return userInt;
//                 } 
//                 else return userInt;
//             })
//             users_permisos = [...usersInt];
//         }else{
//             users_permisos.push({
//                 'persona_id': user.persona_id, 
//                 'nombre': user.nombre, 
//                 'correo': user.correo,                     
//                 'tipo_user_id': user.tipo_user_id,                     
//                 'permisos' : [{ 
//                     'idp': user.id, 
//                     'permisos_id': user.permisos_id, 
//                 }]
//             }, 
//             );
//         }
//     }); 
//     mostrarListaColaboradores()
// }
// function mostrarListaColaboradores(){
//     div = ''
//     users_permisos.forEach(user => {
//         div+= `<div class="recent-message d-flex px-4 py-3 colaborador" onclick="listaPermiso(${user.persona_id})"id="jjdjdj" >
//                 <div class="avatar avatar-lg">
//                     <img src="${URL}vistas/assets/images/faces/4.jpg">
//                 </div>
//                 <div class="name ms-4">
//                     <h5 class="mb-1">${user.nombre}</h5>
//                     <h6 class="text-muted mb-0">${user.correo}</h6>
//                 </div>
//             </div>`
//     });
//     document.getElementById('listaColabor').innerHTML = div
// }
// function listaPermiso(user_id){
//     user = users_permisos.find( userInt => userInt.persona_id == user_id)
//     div = ''
//     permisos.forEach(permiso => {
//         estado = user.permisos.some( permisoInt => permisoInt.permisos_id == permiso.id) ? 'checked' : ''
//         div += `<li class="list-group-item" >
//             <input class="form-check-input me-1" ${estado}  type="checkbox" 
//                 id="${permiso.id}" onchange="updatePermisUser(this.id,${user.persona_id})" aria-label="...">
//             ${permiso.nombre}
//         </li>`
//     });
//     document.getElementById('permisosUser').innerHTML = div
// }
// function updatePermisUser(idInput, user_id){
//     DATOS = new FormData()
//     DATOS.append('tipoPerm', idInput)
//     DATOS.append('user_idPerm', user_id)
//     fetch(URL+'ajax/configAjax.php',{
//         method : 'post',
//         body : DATOS
//     })
//     .then( r => r.json())
//     .then( r => {
//         users_permisos = []
//         leerHorasAtencion()
//     })
// }
// function selectPermis(id){
//     if(document.getElementById(`permi_${id}`).checked){
//     }
//     if (permisosTempo.find(perTem => perTem.id == id )) {
//         permisosTempo = permisosTempo.filter(perT => perT.id != id)
//     } else {
//        permisosTempo.push({
//            'id' : id
//        }) 
//     }
// }



// 
// function saveUsuario(){
//     myModallarge2 = new bootstrap.Modal(document.getElementById('large2'))
//     datos = new FormData()
//     datos.append('dni_appoint',document.getElementById('dni').value)
//     datos.append('name_appoint',document.getElementById('nombre').value)
//     datos.append('last_appoint',document.getElementById('apellido').value)
//     datos.append('celphone_appoint',document.getElementById('celular').value)
//     datos.append('email_appoint',document.getElementById('correo').value)
//     datos.append('permisosTemp',JSON.stringify(permisosTempo))

//     fetch(URL+'ajax/configAjax.php',{
//         method : 'POST',
//         body : datos
//     })
//     .then( r => r.json())
//     .then( r => {
//         console.log(r);
//         // if(r == 1){
//         alertaToastify('Se guardo usuario','green',1500)
//         document.getElementById('dni').value = ''
//         document.getElementById('nombre').value = ''
//         document.getElementById('apellido').value = ''
//         document.getElementById('celular').value = ''
//         document.getElementById('correo').value = ''
//         permisosTempo.forEach(element => {
//             document.getElementById(`permi_${element.id}`).checked = false
//         });
//         leerHorasAtencion()
//         permisosTempo = []
//         setTimeout(() => {
//             myModallarge2.hide()
//         }, 1500);

//         // }
//     })
//     .catch(e => alertaToastify('Probablemente tu dni ya existe en nuestros datos','red',1500))

    
// }



// /* ******************************************** */



