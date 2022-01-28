idAppointDetalle = 0
UserExtra = new bootstrap.Modal(document.getElementById('UserExtra'));
modalEstadEntrada = new bootstrap.Modal(document.getElementById('modalEstadEntrada'));
talla_u = document.getElementById('talla_u')
peso_u = document.getElementById('peso_u')
edad_u = document.getElementById('edad_u')
sangre_u = document.getElementById('sangre_u')

userExtra = false /* Si tiene datos extra existentes */
userDatosExtra = {}
/* CLIENTE */
modalUserExtra(false)
function modalUserExtra(tipo){
    DATOS = new FormData()
    DATOS.append('user','user')
    fetch(URL+'ajax/homeAjax.php',{
        method :'POST',
        body : DATOS,
    })
    .then( r => r.json())
    .then( r => {
        userExtra = false        
        if(r){
            userExtra = true
            userDatosExtra = {
                talla_u : r.talla,
                peso_u : r.peso,
                edad_u : r.edad,
                sangre_u : r.sangre,
            }
        }else userDatosExtra = {}
        HMTLUserExtra()
    })
}
function HMTLUserExtra(){
    document.getElementById('h_talla').innerHTML = userDatosExtra.talla_u ? userDatosExtra.talla_u+ ' cm'  : '--'
    document.getElementById('h_peso').innerHTML = userDatosExtra.peso_u ? userDatosExtra.peso_u+ ' K'  : '--'
    document.getElementById('h_edad').innerHTML = userDatosExtra.edad_u ? userDatosExtra.edad_u : '--'
    document.getElementById('h_sangre').innerHTML = userDatosExtra.sangre_u ? userDatosExtra.sangre_u : '--'

}
function modalExtraShow(){
    UserExtra.show()
    talla_u.value = userDatosExtra.talla_u ? userDatosExtra.talla_u : '' 
    peso_u.value = userDatosExtra.peso_u ? userDatosExtra.peso_u : '' 
    edad_u.value = userDatosExtra.edad_u ? userDatosExtra.edad_u : '' 
    sangre_u.value = userDatosExtra.sangre_u ? userDatosExtra.sangre_u : '' 
}
function updateDatosExtra(){
    if (talla_u.value.trim().length > 0 || peso_u.value.trim().length > 0 || 
        edad_u.value.trim().length > 0 || sangre_u.value.trim().length > 0) {
        datos = {
            talla : talla_u.value,
            peso : peso_u.value,
            edad : edad_u.value,
            sangre : sangre_u.value,
            tipo : userExtra,
        }
        console.log(datos);
        DATOS = new FormData()
        DATOS.append('userUpdate',JSON.stringify(datos))
        fetch(URL+'ajax/homeAjax.php',{
            method :'POST',
            body : DATOS,
        })
        .then( r => r.json())
        .then( r => {            
            if(r){                
                alertaToastify('Datos cambiados','green')
                userExtra = true
                userDatosExtra = {
                    talla_u : r.talla,
                    peso_u : r.peso,
                    edad_u : r.edad,
                    sangre_u : r.sangre,
                }
                UserExtra.hide()
            }else alertaToastify('Algo salio mal')
            HMTLUserExtra()
        })
    } else  alertaToastify('Completar algunos datos')
    
}

/* ADMIN / COLABORADOR */

function showDetailAppoint(idAppoint){
    url = URL+'ajax/homeAjax.php'
    data = new FormData()
    data.append('idAppoint' , idAppoint)

    fetch(url, {
        method : 'POST',
        body : data
    })
    .then( result => result.json())
    .then( result => appointmentHTML(result))
} 

function showDetalleTrat(idAppoint){
    console.log(idAppoint);
    idAppointDetalle = idAppoint
}
function saveDetalle(){
    descripDet = document.getElementById('descripDet').value
    recetDet = document.getElementById('recetDet').value
    otroDet = document.getElementById('otroDet').value
    datos = {
        'descripDet' : descripDet,
        'recetDet' : recetDet,
        'otroDet' : otroDet,
        'idAppoint' : idAppointDetalle,
    }
    if(descripDet != ''){
        url = URL+'ajax/homeAjax.php'
        data = new FormData()
        data.append('savedetaTrat' , JSON.stringify(datos))

        fetch(url, {
            method : 'POST',
            body : data
        })
        .then( result => result.json())
        .then( result => result == 1 ? location.reload() : alertaToastify('Error al guardar'))
    }else alertaToastify('Ingrese detalles')
}

function appointmentHTML(appointDate){
    console.log(appointDate);
    statusMessage = !!appointDate.mensaje ? 'Mensaje' : 'Mandarle un mensaje'
    message = !!appointDate.mensaje ? appointDate.mensaje : ''
    html = `<div class="modal-header bg-info">
            <h5 class="modal-title white" id="myModalLabel130">${appointDate.nombre} ${appointDate.apellidos}</h5>
            <button type="button" class="close" data-bs-dismiss="modal"
                aria-label="Close">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="col-sm-12">
                <h6>${statusMessage}</h6>
                <input class="form-control" type="text" placeholder="Enviarle un mensaje " value="${message}">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary"
                data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Cancelar</span>
            </button>
            <button type="button" class="btn btn-info ml-1"
                data-bs-dismiss="modal">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Enviarle</span>
            </button>
        </div>`
    document.getElementById('show-appointm').innerHTML = html
}

// para las estadisticas

function showEstadEntr(){
    modalEstadEntrada.show();
    console.log('abriendo modal estadist');
    datos = new FormData()
    datos.append('id_estd', 22);
    fetch(URL+'ajax/homeAjax.php',{
        method : 'POST',
        body : datos
    })
    .then( r => r.json())
    .then( r => filtrarEstad(r))
}
datosEst = []
function filtrarEstad(datos){
    datosEst = []
    datosEst2 = []
    fechas = []
    nombres =  ['CONSULTA','ACUPUNTURA']
    datos.forEach(dato => {
        console.log(dato);
        if (datosEst2.find(dat => dat.id == dato.id)){
            const addFechas = datosEst2.map( datAdd => {
                if( datAdd.id == dato.id ) {
                    datAdd.data.push({
                        'fecha' : dato.fecha,
                        'total' : dato.total,
                    })
                    return datAdd;
                } 
                else return datAdd;
                })
                datosEst2 = [...addFechas];
                
        }else{
            datosEst2.push({
                'id' : dato.id,
                'name' : dato.nombre,
                'data' : [{
                    'fecha' : dato.fecha,
                    'total' : dato.total,
                }]
            })
        }
        
        if (datosEst.find(dat => dat.fecha == dato.fecha)){
            const addFechas = datosEst.map( datAdd => {
                if( datAdd.fecha == dato.fecha ) {
                    datAdd.data.push({
                        'total' : dato.total,
                        'name' : dato.nombre,
                    })
                } 
                return datAdd;
               
            })
            datosEst = [...addFechas];
                
        }else{
            fechas.push(dato.fecha)
            datosEst.push({
                'fecha' : dato.fecha,                
                'data' : [{                    
                    'total' : dato.total,
                    'name' : dato.nombre,
                }]
            })
        }

    });
    console.log(datosEst);
    console.log(fechas);
    console.log(datosEst2);
    // nombres.forEach(element => {
    //     if()
    // });
}