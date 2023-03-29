<?php switch ( $user['role'] ){ case 3: $initial = $url.'sales'; break; default: $initial = $url.'dashboard'; break; }?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?php echo $initial ?>" class="brand-link">
        <img src="<?=$url.$template['favicon'] ?>" alt="<?php echo $template['system_name'].' logo' ?>" class="brand-image img-circle elevation-3" >
        <span class="brand-text font-weight-light"><?php echo $template['system_name'] ?></span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-store"></i>
                        <p class="item-menu">Comercial<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">

                        <li class="nav-item">
                            <a href="<?php echo $url; ?>sales" class="nav-link" onclick="clear_localstorage()">
                                <i class="fas fa-users item-submenu"></i>
                                <p>Ventas</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo $url; ?>credit" class="nav-link">
                                <i class="fas fa-credit-card item-submenu"></i>
                                <p>Creditos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo $url; ?>exchanges" class="nav-link">
                                <i class="fas fa-exchange-alt item-menu"></i>
                                <p>Camb o devo</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo $url; ?>expenses" class="nav-link">
                                <i class="fas fa-coins item-submenu"></i>
                                <p>Gastos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php  $user['role'] == 3 ? $us = $user['id'] : $us = 0; echo $url.'close-day/'.current_date('date').'/'.$us ?>" class="nav-link">
                                <i class="fas fa-calendar-day item-submenu"></i>
                                <p>Cierre diario</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-box"></i>
                        <p class="item-menu">Bodega<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <?php echo'
                            <a href="'.$url.'load/site/'.$_SESSION["site"].'" class="nav-link" onclick="clear_localstorage()">
                            ';?>
                            <i class="fas fa-box-open item-submenu"></i>
                            <p>Cargues</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <?php echo'
                            <a href="'.$url.'inventories" class="nav-link" onclick="clear_localstorage()">
                            ';?>
                            <i class="far fa-list-alt item-submenu"></i>
                            <p>Inventarios</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php if( $_SESSION['role'] == 1 || $_SESSION['role'] == 2 ){ echo '

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-building"></i>
                        <p class="item-menu">Administración<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">

                        <li class="nav-item">
                            <a href="'.$url.'products" class="nav-link">
                                <i class="fas fa-boxes item-submenu"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="'.$url.'customer" class="nav-link">
                                <i class="fas fa-user-friends item-submenu"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="'.$url.'users" class="nav-link">
                                <i class="fas fa-users-cog item-submenu"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="'.$url.'general" class="nav-link">
                                <i class="fas fa-cog item-submenu"></i>
                                <p>General</p>
                            </a>
                        </li>

                    </ul>
                </li>
                
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-clipboard"></i>
                        <p class="item-menu">Informes<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">';
                        $reports = ControllerGeneral::ctrRecord('all','reports','order by `order`');
                        foreach ( $reports as $item ) {echo '
                        <li class="nav-item">';
                            switch ( $item['filter'] ){
                                case 1: echo'<a href="'.$url.'reports/'.$item["name"].'" class="nav-link">'; break;
                                case 2: echo'<a href="'.$url.'reports/'.$item["name"].'/'.date("Y-m-d",strtotime(current_date('date')." - 8 days")).'/'.current_date('date').' " class="nav-link">'; break;
                            }echo'
                                <i class="fas fa-list item-submenu"></i>
                                <p class="text-capitalize">'.str_replace("-"," ",$item["name"]).'</p>
                            </a>
                        </li>
                        '; } echo'   
                    </ul>
                </li>
                
                '; } ?>



            </ul>
        </nav>

    </div>

</aside>