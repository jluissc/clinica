
comprasModal = new bootstrap.Modal(document.getElementById('comprasModal'), {
    keyboard: false
})

listarCompras()
listarMateriales()
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
        ]
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
function cambioCategoria(id){
    console.log(id);
}
function modalCompras(id){
    comprasModal.show()
}