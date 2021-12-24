// persona
cuentaModal = new bootstrap.Modal(document.getElementById('cuentaModal'))
dni = document.getElementById('dni_cc')
dni.disabled = true
nombre = document.getElementById('nombre_c')
apellido = document.getElementById('apellido_c')
celular = document.getElementById('celular_c')
correo = document.getElementById('correo_c')

// empresa
cuentaEmpresa = new bootstrap.Modal(document.getElementById('cuentaEmpresa'))
nombre_emp = document.getElementById('nombre_emp')
address_emp = document.getElementById('address_emp')
cel1_emp = document.getElementById('cel1_emp')
correo_emp = document.getElementById('correo_emp')
face_emp = document.getElementById('face_emp')
inst_emp = document.getElementById('inst_emp')

function StatusCuenta(){
    DATOS = new FormData()
    DATOS.append('user','user')
    fetch(URL+'ajax/configAjax.php',{
        method :'POST',
        body : DATOS,
    })
    .then( r => r.json())
    .then( r => {
        // console.log(r)
        cuentaModal.show()
        dni.value = r.dni
        nombre.value = r.nombre
        apellido.value = r.apellidos
        celular.value = r.celular
        correo.value = r.correo
    })
}

function updateDatos(){
    if (nombre.value.trim().length > 0) {
        if (apellido.value.trim().length > 0) {
            datos = {
                nombre : nombre.value,
                apellido : apellido.value,
                celular : celular.value,
                correo : correo.value,
            }
            DATOS = new FormData()
            DATOS.append('userUpdate',JSON.stringify(datos))
            fetch(URL+'ajax/configAjax.php',{
                method :'POST',
                body : DATOS,
            })
            .then( r => r.json())
            .then( r => {
                if(r){
                    alertaToastify('Datos cambiados','green')
                    cuentaModal.hide()
                }else alertaToastify('Algo salio mal')
            })
        } else  alertaToastify('Completar apellidos')
    } else  alertaToastify('Completar nombres')
    
}
function StatusEmpresa(){
    DATOS = new FormData()
    DATOS.append('empresa','empresa')
    fetch(URL+'ajax/configAjax.php',{
        method :'POST',
        body : DATOS,
    })
    .then( r => r.json())
    .then( r => {
        // console.log(r)
        cuentaEmpresa.show()
        nombre_emp.value = r.nombre
        address_emp.value = r.direccion
        cel1_emp.value = r.telefono
        correo_emp.value = r.email
        face_emp.value = r.facebook
        inst_emp.value = r.instagram
    })
}

function updateEmpresa(){
    if (nombre_emp.value.trim().length > 0) {
        if (address_emp.value.trim().length > 0) {
            datos = {
                nombre_emp : nombre_emp.value,
                address_emp : address_emp.value,
                cel1_emp : cel1_emp.value,
                correo_emp : correo_emp.value,
                face_emp : face_emp.value,
                inst_emp : inst_emp.value,
            }
            DATOS = new FormData()
            DATOS.append('empresaUpdate',JSON.stringify(datos))
            fetch(URL+'ajax/configAjax.php',{
                method :'POST',
                body : DATOS,
            })
            .then( r => r.json())
            .then( r => {
                if(r){
                    alertaToastify('Datos cambiados','green')
                    cuentaEmpresa.hide()
                }else alertaToastify('Algo salio mal')
            })
        } else  alertaToastify('Completar dirección')
    } else  alertaToastify('Completar nombres')
    
}