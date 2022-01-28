<div class="container">
    <div class="row">
        <div class="col-12">
            <label>DNI: </label>
            <div class="form-group">
                <input type="number" placeholder="DNI" 
                class="form-control" id="dni" onchange="validarDni()" max="8">
            </div>
        </div>

        <div class="col-6">
            <label> NOMBRES:</label>
            <div class="form-group">
                <input type="text" placeholder="Nombres" class="form-control" id="nombre" >
            </div>
        </div>
        <div class="col-6">
            <label>APELLIDOS: </label>
            <div class="form-group">
                <input type="text" placeholder="Apellidos" class="form-control" id="apellido" >
            </div>
        </div>
        <div class="col-6">
            <label> CELULAR:</label>
            <div class="form-group">
                <input type="number" placeholder="Celular" class="form-control" id="celular" min="7"  max="12">
            </div>
        </div>
        <div class="col-6">
            <label>CORREO: </label>
            <div class="form-group">
                <input type="email" placeholder="Correo" class="form-control" id="correo" required>
            </div>
        </div>
    </div>
</div>