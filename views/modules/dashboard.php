<?php
$day = date("Y-m-d", time());
$ini = date("Y-m-01", time());
$end = strtotime ( '+1 day' , strtotime ( $day ) ) ;
$end = date ( 'Y-m-d' , $end );

$sold_month = ControllerAction::tot_double('total','status_sale = 1 and payment = 0 and created > "'.$ini.'" and created < "'.$end.'" ' );
$sold_day = ControllerAction::tot_double('total','status_sale = 1 and payment = 0 and created > "'.$day.'" and created < "'.$end.'" ' );
$credit_month = ControllerAction::tot_double('total','(payment != 0 or status_sale = 2) and created > "'.$ini.'" and created < "'.$end.'" ' );
$credit_day = ControllerAction::tot_double('total','(payment != 0 or status_sale = 2) and created > "'.$day.'" and created < "'.$end.'" ' );
$products = ControllerGeneral::ctrRecord('all','`references`',''); $tot_pro_act = 0; $tot_pro_ina = 0; foreach ( $products as $row ){ if( $row['status'] != 0 ){ $tot_pro_act++; } else { $tot_pro_ina++;  } };
$tax_month = ControllerAction::tot_double('tax','created > "'.$ini.'" and created < "'.$end.'" ' );
$tax_day = ControllerAction::tot_double('tax','created > "'.$day.'" and created < "'.$end.'" ' );



?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h5 class="m-0 text-dark">Dashboard</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3">
                    <div class="small-box bg-gradient-info">
                        <div class="inner"> <h4><?php echo number_format($sold_day['tot']) ?></h4> <h6><small><?php echo number_format($sold_month['tot']).' del mes' ?></small></h6> <p>Ventas</p> </div>
                        <div class="icon"> <i class="fas fa-store"></i> </div>
                        <a href="<?php echo $url.'reports/ventas/'.$ini.'/'.$end ?> " class="small-box-footer">Detalle <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="small-box bg-gradient-danger">
                        <div class="inner"> <h4><?php echo number_format($credit_day['tot']) ?></h4> <h6><small><?php echo number_format($credit_month['tot']).' del mes' ?></small></h6> <p>Créditos</p> </div>
                        <div class="icon"> <i class="fas fa-archive"></i> </div>
                        <a href="<?php echo $url.'reports/apartados' ?>" class="small-box-footer">Detalle <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="small-box bg-gradient-primary">
                        <div class="inner"> <h4><?php echo $tot_pro_act ?></h4> <h6><small><?php echo $tot_pro_ina.' inactivos' ?></small></h6> <p>Referencias</p> </div>
                        <div class="icon"> <i class="fas fa-boxes"></i> </div>
                        <a href="<?php echo $url.'products'?>" class="small-box-footer">Detalle <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="small-box bg-gradient-warning">
                        <div class="inner"> <h4><?php echo number_format($tax_day['tot']) ?></h4> <h6><small><?php echo number_format($tax_month['tot']).' del mes' ?></small></h6> <p>Iva</p> </div>
                        <div class="icon"> <i class="fas fa-shopping-cart"></i> </div>
                        <a href="<?php echo $url.'reports/compras/'.$ini.'/'.$end ?> " class="small-box-footer">Detalle <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>