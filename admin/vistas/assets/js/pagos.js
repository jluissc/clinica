clickModal = new bootstrap.Modal(document.getElementById('pagosModal'))
listarPagos()
function listarPagos(){
    tablaUsuarios = $('#tablepagos').DataTable({  
        "ajax":{            
            "url": URL+'ajax/pagosAjax.php', 
            "method": 'POST', //usamos el metodo POST
            "data": {'listarPagos':'listarPagos'}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },        
        "columns":[
            {"data": "nombre"},
            {"data": "dni"},
            {"data": "acciones"},
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
    });     
}

function verPagos(idUser){
    datos = new FormData()
    datos.append('Idpagos', idUser)
    fetch(URL+'ajax/pagosAjax.php',{
        method : 'post',
        body : datos
    })
    .then( r => r.json())
    .then( r => {
        pintarListaPagos(r)
    })
}
function pintarListaPagos(r){
    li = ''
    r.forEach(pay => {
        li += `<li class="list-group-item">${pay.nombre}
        <button class="btn btn-info" onclick="morePay(${pay.id})">Ver pagos</button>                
        </li>`
    });
    
    document.getElementById('listPagos').innerHTML = li
}

idPayT = 0 /* para un pago(id temporal) */
function morePay(idPay){
    idPayT = idPay
    datos = new FormData()
    datos.append('idDetalle', idPay)
    fetch(URL+'ajax/pagosAjax.php',{
        method : 'post',
        body : datos
    })
    .then( r => r.json())
    .then( r => {
        li = ''
        monto = 0.0
        r.forEach(detalle => {
            monto += parseFloat(detalle.monto)
            li += `<li class="list-group-item"> S/. ${detalle.monto} :: ${detalle.fecha}          
            </li>`
        });
        li += `<h4>TOTAL: S/. ${monto} <br></h4>`
        li += `agregar un pago mas
            <input type="button" value="Agregar Pago" class="btn btn-outline-primary" onclick="payUser()">`
        document.getElementById('detallePago').innerHTML = li
    })
}

function payUser(){
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
            alertaToastify('Se guardo el pago', 'green',2000)
            datos = new FormData()
            datos.append('idPay',idPayT)
            datos.append('montoPay',parseInt(result.value))
            fetch(URL+'ajax/pagosAjax.php',{
                method : 'POST',
                body : datos,
            })
            .then( result => result.json())
            .then( result => console.log(result))
        }else alertaToastify('Cancelado')
    })
}

function modalPagos(id){
    if(id){
        document.getElementById('btns_pagos').innerHTML = 'EDITAR'
    }else{
        
    }
    clickModal.show()
} 
idUserT = 0
function validarDni(){
    dni = document.getElementById('dni').value
    DATOS = new FormData()
    DATOS.append('dni', dni)
    fetch(URL+'ajax/citaAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {       
        idUserT = r.user.id
        document.getElementById('nombre').value = r.user.nombre
        document.getElementById('apellido').value = r.user.apellidos
        document.getElementById('celular').value = r.user.celular
        document.getElementById('correo').value = r.user.correo
    })
}
function verificarPag(){
    concetPay = document.getElementById('concetPay').value    
    firstPay = document.getElementById('firstPay').value
    
    if(concetPay.trim().length > 0){
        if(firstPay.length > 0 ){
            datos = {
                id : idUserT,
                concept : concetPay,
                monto : firstPay
            }
            console.log(datos);
            updatePayUser(datos)
        }else alertaToastify('Ingresa monto')
    }else alertaToastify('Ingresa el concepto de pago')
}

function updatePayUser(datosd){
    DATOS = new FormData()
    DATOS.append('updateDatos', JSON.stringify(datosd))
    fetch(URL+'ajax/pagosAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        if(r!=0){
            clickModal.hide()
            pintarListaPagos(r)
            alertaToastify('Se guardo pago', 'green')
        }else alertaToastify('Error al guardar pago')
    })
}