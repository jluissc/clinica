<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/homeModelo.php';
	}else{
		require_once './modelos/homeModelo.php';
	} 

	class homeControlador extends homeModelo	{
		
		public function readAppointmentToday() {
      $appointments = homeModelo::readAppointmentToday_m();
      $hmtl = '';
      foreach ($appointments as $appointment) {
        $appoint = ($appointment->tipo_cita_id == 2) ? 'PRESENCIAL': 'DOMICILIO';
        $typeAppoint = ($appointment->tipo_cita_id == 1) ? 'ONLINE': $appoint;

        $color = ($appointment->tipo_cita_id == 2) ? 'success': 'warning';
        $typeColor = ($appointment->tipo_cita_id == 1) ? 'info': $color;
        
        $hmtl .= '<div class="col-sm-3 appoint-'.$typeColor.'">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">'.$appointment->nombre.' '.$appointment->apellidos.'</h5>
              <h6 class="card-text">CELULAR : '.$appointment->celular.' </h6>
              <h6 class="card-text">HORA : '.$appointment->hora.' </h6>
              <h6 class="card-text">TIPO CITA : '.$typeAppoint.' </h6>
              
            </div>
          </div>
        </div>';
        // <button type="button" class="btn btn-outline-'.$typeColor.'" id="showDetailAppoint" data-bs-toggle="modal"
        //           data-bs-target="#info" onclick="showDetailAppoint('.$appointment->id.')">Ver Detalles
        //       </button>
      }
      return $hmtl;
		}

		public function readAppointmentNexts() {
      $appointments = homeModelo::readAppointmentNexts_m();
      $hmtl = '';
      foreach ($appointments as $appointment) {
        $appoint = ($appointment->tipo_cita_id == 2) ? 'PRESENCIAL': 'DOMICILIO';
        $typeAppoint = ($appointment->tipo_cita_id == 1) ? 'ONLINE': $appoint;

        $color = ($appointment->tipo_cita_id == 2) ? 'success': 'warning';
        $typeColor = ($appointment->tipo_cita_id == 1) ? 'info': $color;
        
        $hmtl .= '<div class="col-sm-3 appoint-'.$typeColor.'">
          <div class="card">
            <div class="card-body">
              <h6 class="card-text">FECHA : '.$appointment->fecha.' </h6>
              <h6 class="card-text">HORA : '.$appointment->hora.' </h6>
              <h6 class="card-text">TIPO CITA : '.$typeAppoint.' </h6>
              
            </div>
          </div>
        </div>';
        // <button type="button" class="btn btn-outline-'.$typeColor.'" id="showDetailAppoint" data-bs-toggle="modal"
        //           data-bs-target="#info" onclick="showDetailAppoint('.$appointment->id.')">Ver Detalles
        //       </button>
      }
      return $hmtl;
		}

    public function showDetailAppoint(){
      $idAppoint = $_POST['idAppoint'];
      homeModelo::showDetailAppoint_m($idAppoint);
    }	

    public function dateQuantity(){
      $dates = homeModelo::dateQuantity_m();
      return $dates;
    }		

	} 
?>
