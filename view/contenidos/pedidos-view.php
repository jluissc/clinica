<?php 

    /* PARA HACER DE MAYUGO, cambiar la BD  */
    // require_once './controller/productosControlador.php';
    // $productos = new productosControlador();
    
    // echo $productos -> mostrar_intereses();

?>


<div class="app-content">

            <!--====== Section 1 ======-->
    <div class="u-s-p-y-60">

        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="breadcrumb">
                    <div class="breadcrumb__wrap">
                        <ul class="breadcrumb__list">
                            <li class="has-separator">

                                <a href="index.html">Home</a></li>
                            <li class="is-marked">

                                <a href="wishlist.html">Lista de pedidos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section 1 ======-->


    <!--====== Section 2 ======-->
    <div class="u-s-p-b-60">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">
                            <h1 class="section__heading u-c-secondary">Lista de pedidos</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" id="listaPedidos">

                        <?php
                            // require_once './controller/pedidosController.php';
                            // $inst = new pedidosController();
                            // echo $inst -> listaPedidos_C();
                        ?>

                       


                    </div>
                   
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 2 ======-->
</div>

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Detalle de mi pedido</h5>
                <button type="button" class="btn-close" onclick="cerrarM()">X</button>
            </div>
            <div class="modal-body" >
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cant. </th>
                        <th scope="col">Producto</th>
                        <th scope="col">Color/Talla</th>
                        <th scope="col"> </th>
                        <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody id="detPedidos">

                    </tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-close" onclick="cerrarM()">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>

    listaPedidos()

    function listaPedidos(){
        user = JSON.parse(localStorage.getItem('user'))
        console.log(user);
        serverURL = '<?php echo SERVERURL ?>'
        url = `${serverURL}ajax/pedidoAjax.php`;
        datos = new FormData();
		datos.append('lista', 'lista')
        datos.append('user', user.id)
        fetch(url,{
            method : 'post',
            body : datos
        })
        .then( r => r.json())
        .then( r => {
            showPedidos(r);
        })
    }

    function cerrarM(){
        $('#exampleModalToggle').modal('hide');
    }

    function showPedidos(datos){
        console.log(datos);
        div =''
        datos.forEach(dato => {
            div += `
                <div class="w-r u-s-m-b-30">
                    <div class="w-r__container">
                        <div class="w-r__wrap-1">
                            <div class="w-r__img-wrap">
                                <img class="u-img-fluid" src="images/product/electronic/product3.jpg" alt="">
                            </div>
                            <div class="w-r__info">
                                <span class="w-r__price">Fecha: ${dato.ped_fecha }</span>
                                <span class="w-r__name">
                                    <a href="#">ID pedido: ${dato.ped_codigo}</a>
                                </span>
                               
                                <span class="w-r__price">Monto Total: S/. ${dato.ped_total}</span>
                            </div>
                        </div>
                        <div class="w-r__wrap-2">
                            <a class="w-r__link btn--e-brand" onclick="mostrarPedidosL(${dato.id_ped})">DETALLES</a>
                        </div>
                    </div>
                </div>`
        });
        document.getElementById('listaPedidos').innerHTML = div
    }

    function mostrarPedidosL(id_ped){
        console.log(id_ped);
        $('#exampleModalToggle').modal('show');
        serverURL = '<?php echo SERVERURL ?>'
        url = `${serverURL}ajax/pedidoAjax.php`;
        dato = new FormData();
		dato.append('id_ped', id_ped)
        fetch(url,{
            method :'post',
            body : dato
        })
        .then(r=>r.json())
        .then(r=>{
            console.log(r);
            li =''
            i=0
            r.forEach(prod => {
                i+=1
                li+=`
                    <tr>
                        <th scope="row">${i}</th>
                        <td>${prod.detped_cantidad}</td>
                        <td>${prod.prod_nombre}</td>
                        <td>${prod.detped_color}-${prod.detped_talla}</td>
                        <td></td>
                        <td>S/. ${prod.precio}</td>
                    </tr>`
            });
            document.getElementById('detPedidos').innerHTML = li
        })
    }
</script>