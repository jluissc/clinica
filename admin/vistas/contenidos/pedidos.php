<div id="pedidos">
    <div >
        <?php 
            require_once './controladores/pedidosControlador.php';
            $listaPedidos = new pedidosControlador();
            echo $listaPedidos -> listaPedidos_c();           
        ?>
    </div>
    
    <!-- DETALLE DEL PEDIDO -->
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">Detalle de pedido</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="text-center">
            <h3>Monto : S/. {{total}}.00</h3>
            
            
        </div>
        <div class="offcanvas-body small">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Precio</th>
                    <th scope="col">SubTotal</th>
                    <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="pedido in pedidos">
                        <th scope="row">1</th>
                        <td>{{pedido.detped_cantidad}}</td>
                        <td>{{pedido.prod_nombre}}</td>
                        <td>{{pedido.prod_precio}}</td>
                        <td>{{pedido.detped_cantidad*pedido.prod_precio}}</td>
                        <td>
                            <div class="text-left">
                                <input v-if=estado type="button" value="Atendido" @click=atentido(false)>
                                
                                <span  v-else class="badge bg-primary">El pedido fue atentido</span>
                            
                            </div>
                        </td>
                    </tr>     
                </tbody>
            </table>
        </div>
    </div>

    
    

</div>


<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<script>
const app = new Vue({
    el:"#pedidos",
    //data empleada en la aplicación
    data() {
        return {
            idgg:0,
            url: "../ajax/pedidosAjax.php",
            pedidos:[],
            total :0,
            idPedido:0,
            idDetPedido:0,
            estado:0,
            
        }
    },

    //propiedades computadas (se guarda en cache, por lo que no se repite)
    computed: {
        revertirMensaje(){
            return this.mensaje.split('').reverse().join('');
        },
    },

    // los metodos realizan la operacion cada vez que se llaman.
    methods: {
        /* MOSTRAR EN la pizarra el pedido  */
        verLista(idPedido,estado){
            this.estado = estado == 1 ? false: true; /* 1 atentido, 0 sin atender */
            this.idPedido = idPedido;
            let datos = new FormData();
            datos.append('idPedido',this.idPedido);
            fetch(this.url, {
                method : 'POST',
		        body : datos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                this.total = 0
                this.pedidos = respuesta
                console.log(respuesta);
                respuesta.forEach(pedido => this.total +=pedido.detped_cantidad*pedido.prod_precio);
                
            })
        },

        atentido(v){
            this.estado = false;
            console.log(v);
            let datos = new FormData();
            datos.append('estado',this.idPedido);
            fetch(this.url,{
                method : 'POST',
		        body : datos,
            })
            .then(respuesta => respuesta.text())
            .then(respuesta => console.log(respuesta))

        },
    },
})
</script>
