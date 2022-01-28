<ul class="menu">
    <li class="sidebar-title">Menu</li>
    
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'home' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>home" class='sidebar-link'>
        <i class="fas fa-bars"></i>
            <span>Home</span>
        </a>
    </li>                       
    <?php if($_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2 || $_SESSION['tipo'] == 4 || in_array(3, $_SESSION['permisos'])){ ?>
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'citas' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>citas" class='sidebar-link'>
        <i class="fas fa-calendar-check"></i>
            <span>Citas</span>
        </a>
    </li> 
    <?php } ?>
    <?php if($_SESSION['tipo'] == 1 || in_array(6, $_SESSION['permisos'])){ ?>
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'paciente' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>paciente" class='sidebar-link'>
        <i class="fas fa-users"></i>
            <span>Pacientes</span>
        </a>
    </li> 
    <?php } ?>
    <?php if($_SESSION['tipo'] == 1 || in_array(2, $_SESSION['permisos'])){ ?>
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'compras' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>compras" class='sidebar-link'>
        <i class="fas fa-shopping-cart"></i>
            <span>Compras</span>
        </a>
    </li> 
    <?php } ?>
    
    <?php if($_SESSION['tipo'] == 1 || in_array(5, $_SESSION['permisos'])){ ?>
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'materiales' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>materiales" class='sidebar-link'>
        <i class="fas fa-drafting-compass"></i>
            <span>Materiales</span>
        </a>
    </li> 
    <?php } ?>
    <?php if($_SESSION['tipo'] == 1 || in_array(1, $_SESSION['permisos'])){ ?>
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'pagos' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>pagos" class='sidebar-link'>
        <i class="fas fa-file-invoice-dollar"></i>
            <span>Pagos</span>
        </a>
    </li> 
    <?php } ?>
    <?php if($_SESSION['tipo'] == 1){ ?>
    <li class="sidebar-item <?php echo $_GET['ruta'] == 'configuracion' ? 'active' : '' ?> ">
        <a href="<?php echo SERVERURL ?>configuracion" class='sidebar-link'>
        <i class="fas fa-cog"></i>
            <span>Configuraciones</span>
        </a>
    </li>  
    <?php } ?>
</ul>