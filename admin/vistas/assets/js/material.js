console.log('holllllaa');
var materialModal = new bootstrap.Modal(document.getElementById('materialModal'), {
    keyboard: false
  })

function cambModalMat(estado, id){
    estado ? materialModal.show() : materialModal.hide()
}