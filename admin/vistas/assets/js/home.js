const urlPrincipal = '<?php echo SERVERURL?>';
idAppointDetalle = 0
function showDetailAppoint(idAppoint){
    url = urlPrincipal+'ajax/homeAjax.php'
    // let datos = {
    //     idAppoint : idAppoint,
    //     url : url,
    // }
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
        url = urlPrincipal+'ajax/homeAjax.php'
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

