horasAtencion = []
citasAtencion = []
users_permisos = []
permisos = []
fechaSelecionada = ''

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
        horasAtencion = r.horaAtencion
        permisos = r.permisos
        // users_permisos = r.users
        mostrarCrudHoras()
        mostrarCrudCitas()
        filtrarUsers(r.users)
        
    })
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
    DATOS = new FormData()
    DATOS.append('estadoHoraC', estado)
    DATOS.append('hora_idHoraC', id)
    fetch(URL+'ajax/configAjax.php',{
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
    DATOS = new FormData()
    DATOS.append('estadoCitaC', estado)
    DATOS.append('cita_idCitaC', id)
    fetch(URL+'ajax/configAjax.php',{
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

function mostrarListaColaboradores(){
    div = ''
    users_permisos.forEach(user => {
        div+= `<div class="recent-message d-flex px-4 py-3" onclick="listaPermiso(${user.persona_id})">
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
        div += `<li class="list-group-item">
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
        console.log(r);
    })
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
    DATOS = new FormData()
    DATOS.append('fecha', fecha)
    fetch(URL+'ajax/configAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        horaNoDisponn = [...r.horasNoDispo,...r.citasReser]
        // console.log(horaNoDisponn);
        mostrarHorasAtencion(r.citasReser, horaNoDisponn,r.horasNoDispo);
        mostrarCitasAtencion(r.citasNDisp);
        
    })
}

function mostrarHorasAtencion(citasReser,horaNoDisponn,horasNoDispo){
    horaDisp = horasAtencion.filter(horasDispo=>{
        let res = horaNoDisponn.find((horaNDis)=>{
            return horaNDis.id == horasDispo.id;
        });
        return res == undefined;
      });
    
    horasActivas = horaDisp.filter(horaD => horaD.estado == 1)
    aa = horasActivas.concat(citasReser);
    
    div = ''
    horasAtencion.forEach((hora,index) => {
        if(hora.estado != 0 ){
            atender = horaNoDisponn.some( h => h.horas_id == hora.id) ? '' : 'checked' 
            if(citasReser.some( citaR => citaR.id == hora.id)){
                citasReser.forEach(cit => {
                    if(cit.id == hora.id){
                        div +=`
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <li class="list-group-item accordion-button"  data-bs-toggle="collapse" data-bs-target="#ho${index}" aria-expanded="true" aria-controls="ho${index}"
                                    <input class="form-check-input me-1" ${atender} type="checkbox">
                                    ${hora.hora} PACIENTE : ${cit.nombre} <img style="max-width: 18px;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDUxMi4wMTEgNTEyLjAxMSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyLjAxMSA1MTIuMDExOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTUwNS43NTUsMTIzLjU5MmMtOC4zNDEtOC4zNDEtMjEuODI0LTguMzQxLTMwLjE2NSwwTDI1Ni4wMDUsMzQzLjE3NkwzNi40MjEsMTIzLjU5MmMtOC4zNDEtOC4zNDEtMjEuODI0LTguMzQxLTMwLjE2NSwwDQoJCQlzLTguMzQxLDIxLjgyNCwwLDMwLjE2NWwyMzQuNjY3LDIzNC42NjdjNC4xNiw0LjE2LDkuNjIxLDYuMjUxLDE1LjA4Myw2LjI1MWM1LjQ2MiwwLDEwLjkyMy0yLjA5MSwxNS4wODMtNi4yNTFsMjM0LjY2Ny0yMzQuNjY3DQoJCQlDNTE0LjA5NiwxNDUuNDE2LDUxNC4wOTYsMTMxLjkzMyw1MDUuNzU1LDEyMy41OTJ6Ii8+DQoJPC9nPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" />
                                </li>
                                <div id="ho${index}" class="accordion-collapse collapse" aria-labelledby="horaI${index}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>DNI : ${cit.dni} </strong> <br>
                                        <strong>CELULAR : ${cit.celular} </strong> <br>
                                    </div>
                                </div>
                            </div>
                        </div>`
                    }
                    
                });
                
            }else{
                if(horasNoDispo.some( HNDis => HNDis.id == hora.id)){
                    horasNoDispo.forEach(HNDis => {
                        if(HNDis.id == hora.id){
                            div +=`<li class="list-group-item">
                                <input class="form-check-input me-1"  type="checkbox" 
                                id="horaId_${index}" onchange="estadoHora(${hora.id},this.id)" aria-label="...">
                                ${hora.hora}
                            </li>`
                        }
                    });
                }else{
                    div +=`<li class="list-group-item">
                            <input class="form-check-input me-1" ${atender} type="checkbox" 
                            id="horaId_${index}" onchange="estadoHora(${hora.id},this.id)" aria-label="...">
                            ${hora.hora}
                        </li>`
                }
            }
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
    DATOS = new FormData()
    DATOS.append('estadoCita', estado)
    DATOS.append('fechaCita', fechaSelecionada)
    DATOS.append('cita_idCita', id)
    DATOS.append('sedeC', 1)
    fetch(URL+'ajax/configAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        // console.log(r);
    })
}

function estadoHora(id,idInp){
    estado = document.getElementById(`${idInp}`).checked ? 1: 0
    DATOS = new FormData()
    DATOS.append('estadoSelec', estado)
    DATOS.append('fechaSelec', fechaSelecionada)
    DATOS.append('hora_idSelec', id)
    DATOS.append('sede', 1)
    fetch(URL+'ajax/configAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        // console.log(r);
    })
}

