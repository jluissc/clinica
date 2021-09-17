<ul class="menu">
    <li class="sidebar-title">Menu</li>
    
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'home' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>home" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Home</span>
        </a>
    </li>                       
    
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'citas' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>citas" class='sidebar-link'>
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Citas</span>
        </a>
    </li> 
    
    <?php if($_SESSION['tipo'] == 1){ ?>
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'clientes' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>clientes" class='sidebar-link'>
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Clientes</span>
        </a>
    </li> 

    <li class="sidebar-item <?php echo $_GET['ruta'] == 'configuracion' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>configuracion" class='sidebar-link'>
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Configuraciones</span>
        </a>
    </li>  
    <?php } ?>
</ul>