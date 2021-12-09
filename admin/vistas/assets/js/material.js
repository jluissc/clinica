console.log('holllllaa');
// para materiales
materialModal = new bootstrap.Modal(document.getElementById('materialModal'), {
    keyboard: false
})
name_mat = document.getElementById('name_mat')
descr_mat = document.getElementById('descr_mat')
btn_materiales = document.getElementById('btn_materiales')
newMaterial= 0
listarMateriales()
function listarMateriales(){
    tablaUsuarios = $('#tableMateriales').DataTable({  
        "ajax":{            
            "url": URL+'ajax/materialAjax.php', 
            "method": 'POST', //usamos el metodo POST
            "data": {'listarMat':'ho'}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },        
        "columns":[
            {"data": "nombre"},
            {"data": "descr"},
            {"data": "acciones"},
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
    });     
}

function cambModalMat(estado, id){
    estado ? materialModal.show() : materialModal.hide()
    if(id){
        newMaterial = id
        searchMaterial(id)
        opt = `<button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Cancelar</span>
            </button>
            <button type="button" class="btn btn-info ml-1" id="btnsss" onclick="verificarMater()">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Editar</span>
            </button>`
    }else{
        opt = `<button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Cancelar</span>
            </button>
            <button type="button" class="btn btn-info ml-1" id="btnsss" onclick="verificarMater()">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Guardar</span>
            </button>`
    }
    btn_materiales.innerHTML=opt
}

function searchMaterial(id){
    datos = new FormData()
    datos.append('idMaterial', id)
    fetch(URL+'ajax/materialAjax.php',{
        method : 'post',
        body : datos
    })
    .then( r => r.json())
    .then( r => {
        name_mat.value = r.nombre
        descr_mat.value = r.descripcion
    })
}

function verificarMater(){
    if(name_mat.value != ''){
        if(descr_mat.value != ''){
            updateMaterial()
        }else alertaToastify('Completar descripción')
    }else alertaToastify('Completar nombre')
}

function deleteMat(id){
    Swal.fire({
        title: '¿Seguro de eliminar?',
        text: "Se eliminará definitivamente el material!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteDefinity(id)
        }else{
            alertaToastify('Se cancelo la eliminación','#12d3dc')
        }
    })
}

function deleteDefinity(id){
    console.log(id);
    datos = new FormData()
    datos.append('idDelete', id)
    fetch(URL+'ajax/materialAjax.php',{
        method : 'post',
        body : datos
    })
    .then( r => r.json())
    .then( r => {
        console.log(r);
        if(r == 1) {
            $('#tableMateriales').DataTable().destroy()
            listarMateriales()
            alertaToastify('Eliminado','green')
        }else alertaToastify('Error al eliminar')
    })
}

function updateMaterial(){
    datosMateriales = {
        name_mat : name_mat.value,
        descr_mat : descr_mat.value,
        newMaterial : newMaterial,
    }
    datos = new FormData()
    datos.append('datosMateriales', JSON.stringify(datosMateriales) )
    fetch(URL+'ajax/materialAjax.php',{
        method : 'post',
        body : datos
    })
    .then( r => r.json())
    .then( r => {
        if(r == 1) {
            newMaterial ? materialModal.hide() : ''
            newMaterial ? alertaToastify('Editado','green') : alertaToastify('Creado','green');
            $('#tableMateriales').DataTable().destroy()
            listarMateriales()
            name_mat.value = ''
            descr_mat.value = ''
        }
        else console.log('jjj');
    })
}
