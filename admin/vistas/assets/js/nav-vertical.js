cuentaModal = new bootstrap.Modal(document.getElementById('cuentaModal'))
dni = document.getElementById('dni_cc')
dni.disabled = true
nombre = document.getElementById('nombre_c')
apellido = document.getElementById('apellido_c')
celular = document.getElementById('celular_c')
correo = document.getElementById('correo_c')

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