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

function morePay(idPay){
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
        r.forEach(detalle => {
            li += `<li class="list-group-item">S/. ${detalle.monto}          
            </li>`
        });
        document.getElementById('detallePago').innerHTML = li
    })
}