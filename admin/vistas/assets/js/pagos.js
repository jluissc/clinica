console.log('dddddddddd');
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
        ]
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
        li = ''
        r.forEach(pay => {
            li += `<li class="list-group-item">${pay.nombre}
            <button class="btn btn-info" onclick="morePay(${pay.id})">Pagar</button>                
            </li>`
        });
        
        document.getElementById('listPagos').innerHTML = li
    })
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
        console.log(r);
        li = ''
        a = 0.0
        r.forEach(detalle => {
            a += parseFloat(detalle.monto)
            li += `<li class="list-group-item"> S/. ${detalle.monto}          
            </li>`
        });
        li += `<h4>TOTAL: S/. ${a} <br></h4>`
        li += `agregar un pago mas
            <input type="button" value="Pagar" class="btn btn-outline-primary" onclick="payUser()">`
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