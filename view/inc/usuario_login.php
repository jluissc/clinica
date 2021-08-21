<div id="sesionLogueo" @mouseover="estadoLogueo">
    <button class="btn btn--icon toggle-button toggle-button--white fas fa-cogs" type="button" ></button>
    <div class="ah-lg-mode">
        <span class="ah-close">✕ Close</span>
        <ul class="ah-list ah-list--design1 ah-list--link-color-white">
            <li class="has-dropdown" data-tooltip="tooltip" data-placement="left" title="Opcion">

                <a><i class="far fa-user-circle"></i></a>
                <span class="js-menu-toggle"></span>
                <ul style="width:120px">
                    <li v-if=logueo>
                        <a href="#" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-user-circle u-s-m-r-6" ></i>
                            <span>Login</span></a>
                    </li>
                    <li v-if=logueo>
                        <a onclick="registro_caleta()" href="#"><i class="fas fa-user-plus u-s-m-r-6"></i>
                            <span>Registro</span></a></li>
                    <li>
                    <li v-if=!logueo>
                        <a href=""><span>
                            {{usuario}}                        
                        </span></a>
                    </li>

                    <li v-if=!logueo>
                        <a onclick href="#"><i class="fas fa-edit u-s-m-r-6"></i>

                            <span>Editar Perfil</span></a>
                    </li>
                    <li v-if=!logueo>
                        <a onclick href="#"><i class="fas fa-lock-open u-s-m-r-6"></i>

                            <span>Salir</span></a>
                    </li>                
                </ul>
            </li>                                    
            
        </ul>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" placeholder="Usuario" id="userLogin">
                    <input type="text" placeholder="Contraseña" id="passLogin">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="loginInicio()">Entrar</button>
                </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script>

const app = new Vue({
    el:"#sesionLogueo",
    //data empleada en la aplicación
    data() {
        return {
            logueo:true,
            url : '',
            usuario:'',
            
        }
    },

    //propiedades computadas (se guarda en cache, por lo que no se repite)
    // computed: {
    //     nombre (){
    //         this.url = 'asjd';
    //     },
    // },

    // los metodos realizan la operacion cada vez que se llaman.
    methods: {
        /* MOSTRAR EN la pizarra el pedido  */
        loginInicio(){
            this.link()
            userLogin = document.getElementById('userLogin').value;
            passLogin = document.getElementById('passLogin').value;                

            datos = new FormData();
            datos.append('userLogin',userLogin);
            datos.append('passLogin',passLogin);

            fetch(this.url,{
                method:'post',
                body:datos,
            })
            .then(resp => resp.json())
            .then(resp => {
                if (resp.respuesta == 'ok') {
                    this.logueo = false;
                    var cliente = { 
                        userEmail: userLogin,
                        userId: resp.id,  
                    };

                    // Guardo el objeto como un string
                    localStorage.setItem('datos', JSON.stringify(cliente));
                } else {
                    console.log('mal user o pass')
                }
            })
        },
        estadoLogueo(){
            
            var guardado = localStorage.getItem('datos');
            if (guardado) {
                this.logueo = false
                guardado = JSON.parse(guardado)
                this.usuario = guardado.userEmail
            } else {
                console.log('sin logueo')
            }
        },
        link (){
            this.url =  window.location.href;
            a = this.url.split('/')
            if (a.length == 5)  {
                this.url = `./ajax/logueoAjax.php`
            }else if(a.length == 6){
                this.url = `../ajax/logueoAjax.php`
            }
            else if(a.length == 7){
                this.url = `../../ajax/logueoAjax.php`
            }
            else if(a.length == 8){
                this.url = `../../../ajax/logueoAjax.php`
            }
        },      
    },
})
</script>
 

   





