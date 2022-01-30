<div class="container">
    <div class="row">
        <div class="col-12 form-group">
            <label>DNI: </label>
            <input type="number" placeholder="DNI" class="form-control" id="dni" onchange="validarDni()" max="8">
        </div>
        <div class="col-12 col-sm-6 form-group">
            <label> NOMBRES:</label>
            <input type="text" placeholder="Nombres" class="form-control" id="nombre" >
        </div>
        <div class="col-12 col-sm-6 form-group">
            <label>APELLIDOS: </label>
            <input type="text" placeholder="Apellidos" class="form-control" id="apellido" >
        </div>
        <div class="col-12 col-sm-6 form-group">
            <label> CELULAR:</label>
            <input type="number" placeholder="Celular" class="form-control" id="celular" min="7"  max="12">
        </div>
        <div class="col-12 col-sm-6 form-group">
            <label>CORREO: </label>
            <input type="email" placeholder="Correo" class="form-control" id="correo" required>
        </div>
    </div>
</div>