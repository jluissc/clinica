<?php  
	
	if ($peticionAjax) {
		require_once '../modelos/materialModelo.php';
	}else{
		require_once './modelos/materialModelo.php';
	} 

	class materialControlador extends materialModelo	{

        public function updateMaterial(){
            materialModelo::updateMaterial_m($_POST['datosMateriales']);
        }
        public function searchMaterial(){
            materialModelo::searchMaterial_m($_POST['idMaterial']);
        }
        public function deleteDefinity(){
            materialModelo::deleteDefinity_m($_POST['idDelete']);
        }
        public function listarMater2(){
            materialModelo::listaMateriales2();
        }

        public function listarMater(){
            session_start(['name' => 'bot']);
            $datosMat = materialModelo::listaMateriales();
            $datos =[];
			foreach ($datosMat as $mat) {
                if ($_SESSION['tipo'] != 5) {
                    $btn = '<button class="btn btn-outline-danger" onclick="deleteMat('.$mat->id.')">
                        Eliminar</button>
                        <button class="btn btn-outline-info"  onclick="cambModalMat(1,'.$mat->id.')">
                            Editar</button>';	
                } else {
                    $btn = '<button class="btn btn-outline-danger" onclick="modoView()">
                        Eliminar</button>
                        <button class="btn btn-outline-info"  onclick="modoView()">
                            Editar</button>';	
				}               			
				array_push($datos,[
					'nombre' => $mat->nombre,
					'descr' => $mat->descripcion,
					'acciones' => $btn,					
				]);
			}
			exit(json_encode($datos));//envio el array final el formato json a AJAX
        }
	} 
?>
