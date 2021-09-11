<?php 
    if($_SESSION['tipo']==1 || in_array(3, $_SESSION['permisos']) ){
        require_once './controladores/clientesControlador.php';
        $inst = new clienteControlador();
?>
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
        data-bs-target="#large" >
        Nuevo Cliente
    </button>
    <br>
    <br>
    <h4 class="modal-title" id="myModalLabel17">LISTA DE CLIENTES</h4>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <!-- Simple Datatable -->
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php 
                            echo $inst->reedListCustomers();
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#info">
                                            Info
                                        </button>

                                        <!--info theme Modal -->
                                        <div class="modal fade text-left" id="info" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel130" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h5 class="modal-title white" id="myModalLabel130">Info Modal
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Tart lemon drops macaroon oat cake chocolate toffee chocolate
                                                        bar icing. Pudding jelly beans
                                                        carrot cake pastry gummies cheesecake lollipop. I love cookie
                                                        lollipop cake I love sweet
                                                        gummi bears cupcake dessert.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <button type="button" class="btn btn-info ml-1"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Accept</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

    </section>
    <script>
        const url= '<?php echo SERVERURL?>'+'ajax/clienteAjax.php';
        function showCustomer(idCustomer){
            // urlDestino = url+'ajax/clienteAjax.php'
            datos = new FormData()
            datos.append('idCustomer',idCustomer)
            fetch(url,{
                method : 'POST',
                body : datos,
            })
            .then(r => r.json())
            .then(r => console.log(r))
            
        }

        function deleteCustomer(idCustomer){
            
            Swal.fire({
                title: '¿Seguro de eliminar?',
                text: "Se eliminar definitivamente al paciente!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteDefinity(idCustomer)
                }else{
                    Toastify({
                        text: "Se cancelo la eliminación",
                        duration: 2000,
                        backgroundColor: "#12d3dc",
                    }).showToast();
                }
            })
        }

        function deleteDefinity(idCustomer){
            datos = new FormData()
            datos.append('idDelete',idCustomer)
            fetch(url, {
                method: 'POST', 
                body: datos
            })
            .then(r => r.json())
            .then(r => r == 1 ? location.reload() : console.log('no se elimino') )
            .catch(e => console.log(e))
        }

        function userDni(dni){
            // const url="https://api.apis.net.pe/v1/dni?numero=60691536";
            // const url="https://api.apis.net.pe/v1/dni?numero=60691536";
            const url=`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Impsc2MuaGNvOTZAZ21haWwuY29tIn0.ysxMDCaGlMQRJen3msmMcniIx_Q-nuhjXjQ4RNkP31o`;
            // ,{    
            //     mode: 'no-cors', // no-cors, *cors, same-origin
            //     headers: {
            //     'Content-Type': 'application/json',
            //     'Access-Control-Allow-Origin': '*'
            //     },
            // }
            fetch(url)
            .then(r => r.json())
            .then(r => console.log(r))
            
        }
    </script>
<?php 
    }else{
        echo 'UPS!!!... PARECE QUE NO HAY NADA QUE MOSTRAR';
    }
?>