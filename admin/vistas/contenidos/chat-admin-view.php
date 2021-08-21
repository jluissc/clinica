<div class="col-md-12">
    <div class="card"> 

              
        <div class="row no-gutters">
            <div class="col-lg-3 col-xl-2 border-right">
                <div class="card-body border-bottom">
                    <form>
                        <input class="form-control" type="text" placeholder="Search Contact">
                    </form>
                </div>
                
                <div class="scrollable position-relative" style="height: calc(100vh - 111px);"  id="mensajesss">
                    <ul class="mailbox list-style-none">
                        <li>
                            <div class="message-center">

                                <!-- *****************Lista Chats***************** -->
                                 
                                <?php 
                                    require_once './controladores/chatUUControlador.php';
                                    $listachatUU = new chatUUControlador();            
                                    echo $listachatUU -> lista_chatUU_C();
                                 ?>
                                
                                <!-- *****************Lista Chats Fin***************** -->
                            </div>
                        </li>
                    </ul>
                </div> 
            </div> 
            <div class="col-lg-9  col-xl-10">
                <div class="chat-box scrollable position-relative"
                style="height: calc(100vh - 111px);">
                <!--chat Row -->
                <ul class="chat-list list-style-none px-3 pt-3" id="mensajeLista">
                                 
                    <!--**************************chat Row************************** -->


                    <!--**************************chat Row************************** -->
                    
                </ul>
            </div>
            
            <div class="card-body border-top" id="barraM" style="display: none;">
                <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/chat-adminAjax.php" method="POST" data-form="mensaje" autocomplete="off">
                    <input type="hidden" name="idRec" id="idRec">
                    <div class="row">
                        <div class="col-9">
                            <div class="input-field mt-0 mb-0">
                                <input id="mensajeEnv" name="mensajeEnv" placeholder="Escribe..."
                                class="form-control border-0" type="text">
                            </div>
                        </div>
                        <div class="col-3">
                            <button class="btn-circle btn-lg btn-cyan float-right text-white" type="submit"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 