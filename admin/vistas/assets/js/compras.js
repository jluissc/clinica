
comprasModal = new bootstrap.Modal(document.getElementById('comprasModal'), {
    keyboard: false
})
prec_com = document.getElementById('prec_com')
cant_com = document.getElementById('cant_com')
listarCompras()

function listarCompras(){
    tablaUsuarios = $('#tableCompras').DataTable({  
        "ajax":{            
            "url": URL+'ajax/comprasAjax.php', 
            "method": 'POST', //usamos el metodo POST
            "data": {'listaCompras':'listaCompras'}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },        
        "columns":[
            {"data": "nombre"},
            {"data": "cant"},
            {"data": "price"},
            {"data": "date"},
            {"data": "subt"},
            {"data": "acciones"},
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
    });     
}
function listarMateriales(){
    datos = new FormData()
    datos.append('listarMat2', 'id')
    fetch(URL+'ajax/materialAjax.php',{
        method : 'post',
        body : datos
    })
    .then( r => r.json())
    .then( r => {
        console.log(r);
        hollla(r)
        
    })
}

function hollla(r){
    
    // 
    opt = `<label>SELECCIONE MATERIAL: </label>
                <fieldset class="form-group">
                    <option value="0">Seleccione</option>
                    <select class="choices form-select" id="selectMat" onchange="cambioCategoria(this.value)">`
    r.forEach(mat => {
        console.log(mat);
        opt += `<option value="${mat.id}">${mat.nombre}</option>`
    });
    opt +=`</select>
    </fieldset> `
    document.getElementById('selectMat').innerHTML = opt
    // 
    let choices = document.querySelectorAll('.choices');
    let initChoice;
    for(let i=0; i<choices.length;i++) {
        if (choices[i].classList.contains("multiple-remove")) {
            initChoice = new Choices(choices[i],
            {
                delimiter: ',',
                editItems: true,
                maxItemCount: -1,
                removeItemButton: true,
            });
        }else{
            initChoice = new Choices(choices[i]);
        }
    }
}
matEscTemp = 0
function cambioCategoria(id){
    console.log(id);
    matEscTemp = id
}
function modalCompras(id){
    if (id) {
        
    } else {
        listarMateriales()
    }
    comprasModal.show()
}

function verificarComp(){
    // a = document.querySelector('input[name="listHHHH"]:checked')
    if(matEscTemp){
        if (prec_com.value.trim().length>0) {
            if (cant_com.value.trim().length>0) {
                datos = {
                    id_mat : matEscTemp,
                    price : prec_com.value,
                    cant : cant_com.value,
                    id_compra : 0
                }
                updateCompras(datos)
            } else alertaToastify('Falta cantidad')
        } else alertaToastify('Falta precio')
    }else alertaToastify('Escoge el material')
}

function updateCompras(datosd){
    DATOS = new FormData()
    DATOS.append('updateDatos', JSON.stringify(datosd))
    fetch(URL+'ajax/comprasAjax.php',{
        method : 'post',
        body : DATOS
    })
    .then( r => r.json())
    .then( r => {
        if(r!=0){
            alertaToastify('Se guardo pago', 'green')
            $('#tableCompras').DataTable().destroy()
            listarCompras()
            prec_com.value = ''
            cant_com.value = ''

        }else alertaToastify('Error al guardar pago')
    })
}