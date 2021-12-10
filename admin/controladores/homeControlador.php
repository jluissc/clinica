<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/homeModelo.php';
	}else{
		require_once './modelos/homeModelo.php';
	} 

	class homeControlador extends homeModelo	{

    public function clave(){
      return mainModelo::encryption('22510467');
    }
		/* ****************** */
		public function readAppointmentToday() {
      $appointments = homeModelo::readAppointmentToday_m();
      $hmtl = '';
      foreach ($appointments as $appointment) {
        $appoint = ($appointment->tipo_cita_id == 2) ? 'PRESENCIAL': 'DOMICILIO';
        $typeAppoint = ($appointment->tipo_cita_id == 1) ? 'ONLINE': $appoint;

        $color = ($appointment->tipo_cita_id == 2) ? 'success': 'warning';
        $typeColor = ($appointment->tipo_cita_id == 1) ? 'info': $color;
        $btn = homeModelo::estadoDetalleTratam_m(1, $appointment->id) ? '<h3>ATENTIDO</h3>' : '<button class="btn btn-success" onclick="showDetalleTrat('.$appointment->id.')" data-bs-toggle="modal" data-bs-target="#large3">Detalles</button>';
        $hmtl .= '<div class="col-sm-3 ">
          <div class="card">
            <div class="card-body appoint-'.$typeColor.'">
              <h5 class="card-title">'.$appointment->nombre.' '.$appointment->apellidos.'</h5>
              <h6 class="card-text">CELULAR : '.$appointment->celular.' </h6>
              <h6 class="card-text">HORA : '.$appointment->hora.' </h6>
              <h6 class="card-text">TIPO CITA : '.$typeAppoint.' </h6>
              <h6 class="card-text">SERVICIO: '.$appointment->servic.' </h6>
              '.$btn.'
            </div>
          </div>
        </div>';
      }
      return $hmtl;
		}
    /* ****************** */
		public function readAppointmentNexts() {
      $appointments = homeModelo::readAppointmentNexts_m();
      $hmtl = '';
      foreach ($appointments as $appointment) {
        $appoint = ($appointment->tipo_cita_id == 2) ? 'PRESENCIAL': 'DOMICILIO';
        $typeAppoint = ($appointment->tipo_cita_id == 1) ? 'ONLINE': $appoint;

        $color = ($appointment->tipo_cita_id == 2) ? 'success': 'warning';
        $typeColor = ($appointment->tipo_cita_id == 1) ? 'info': $color;
        
        $hmtl .= '<div class="col-sm-3 ">
          <div class="card">
            <div class="card-body appoint-'.$typeColor.'">
              <h6 class="card-text">FECHA : '.$appointment->fecha.' </h6>
              <h6 class="card-text">HORA : '.$appointment->hora.' </h6>
              <h6 class="card-text">TIPO CITA : '.$typeAppoint.' </h6>
              
            </div>
          </div>
        </div>';
      }
      return $hmtl != '' ? $hmtl : '<h4>No tienes cita proxima</h4>';
		}

    public function showDetailAppoint(){
      $idAppoint = $_POST['idAppoint'];
      homeModelo::showDetailAppoint_m($idAppoint);
    }	

    public function saveDetalleTratam(){
      $datos = json_decode($_POST['savedetaTrat']);
      homeModelo::saveDetalleTratam_m($datos);
    }	
    public function updateDatosExtra(){
      $datos = json_decode($_POST['userUpdate']);
      homeModelo::updateDatosExtra_m($datos);
    }	
    public function datosUserExtra(){
      homeModelo::datosUserExtra_m();
    }	

    public function dateQuantity(){
      $dates = homeModelo::dateQuantity_m();
      return $dates;
    }		

	} 
?>
