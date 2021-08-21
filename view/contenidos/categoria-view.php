<?php 
    $ruta = explode('/',$_GET['ruta']);
    if (isset($ruta[1])) {
        $categoria = $ruta[1];
    } else {
        $categoria = '';
    }
    include 'controller/productosControlador.php';
    $prods = new productosControlador();
    
    $lista = $prods->productos($categoria);			
?>

<!--====== App Content ======-->
<div class="app-content">

<!--====== Section 1 ======-->
<div class="u-s-p-y-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-p">
                    <div class="shop-p__toolbar u-s-m-b-30">
                        <div class="shop-p__meta-wrap u-s-m-b-60">

                            <span class="shop-p__meta-text-1">  <?php echo count($lista) ?> RESULTADOS</span>
                            <div class="shop-p__meta-text-2">

                                <!-- <span>Related Searches:</span>

                                <a class="gl-tag btn--e-brand-shadow" href="#">men's clothing</a>

                                <a class="gl-tag btn--e-brand-shadow" href="#">mobiles & tablets</a>

                                <a class="gl-tag btn--e-brand-shadow" href="#">books & audible</a></div> -->
                        </div>
                        <div class="shop-p__tool-style">
                            <div class="tool-style__group u-s-m-b-8">

                                <!-- <span class="js-shop-filter-target" data-side="#side-filter">Filtrar</span> -->

                                <span class="js-shop-grid-target">Cuadro</span>

                                <span class="js-shop-list-target is-active">Lista</span></div>
                            <!-- <form>
                                <div class="tool-style__form-wrap">
                                    <div class="u-s-m-b-8"><select class="select-box select-box--transparent-b-2">
                                            <option>Show: 8</option>
                                            <option selected>Show: 12</option>
                                            <option>Show: 16</option>
                                            <option>Show: 28</option>
                                        </select></div>
                                    <div class="u-s-m-b-8"><select class="select-box select-box--transparent-b-2">
                                            <option selected>Sort By: Newest Items</option>
                                            <option>Sort By: Latest Items</option>
                                            <option>Sort By: Best Selling</option>
                                            <option>Sort By: Best Rating</option>
                                            <option>Sort By: Lowest Price</option>
                                            <option>Sort By: Highest Price</option>
                                        </select></div>
                                </div>
                            </form> -->
                        </div>
                    </div>
                    <div class="shop-p__collection">
                        <div class="row is-list-active">
                        <?php 
                            foreach ($lista as $prod) {
                                echo ' <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="product-m">
                                        <div class="product-m__thumb">

                                            <a class="aspect aspect--bg-grey aspect--square u-d-block" href="#">
                                                <img class="aspect__img" src="'.SERVERURL.'admin/'.$prod->foto_url.'" alt="">
                                                </a>
                                            <div class="product-m__quick-look">
                                                    <a class="fas fa-search" data-modal="modal" data-modal-id="#quick-look" 
                                                        data-tooltip="tooltip" data-placement="top" title="Ver Detalles" onclick="verDetalle('.$prod->id_prod.')"></a>
                                                </div>
                                            <div class="product-m__add-cart">
                                                <a class="btn--e-brand" data-modal="modal" data-modal-id="#quick-look" onclick="verDetalle('.$prod->id_prod.')">Ver detalles</a>
                                                </div>
                                        </div>
                                        <div class="product-m__content">
                                            <div class="product-m__category">

                                                <a href="'.SERVERURL.'categoria/'.$prod->cat_nombre.'">'.$prod->cat_nombre.'</a></div>
                                            <div class="product-m__name">

                                                <a href="#">'.$prod->prod_nombre.'</a></div>
                                            
                                            <div class="product-m__price">S/. '.$prod->prod_precio.'</div>
                                            <div class="product-m__hover">
                                                <div class="product-m__preview-description">

                                                    <span>'.$prod->prod_espec.'
                                                    </span>
                                                    </div>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                        ?>

<!-- <div class="product-m__wishlist">

<a class="far fa-heart" href="#" data-tooltip="tooltip" data-placement="top" title="Add to Wishlist"></a>
</div> -->
                           
                           
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<!--====== End - Section 1 ======-->
</div>
<!--====== End - App Content ======-->

<?php 
    include 'view/inc/filter.php';
    
?>