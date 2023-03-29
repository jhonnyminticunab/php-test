<?php

if( isset( $routes[1] ) ){
    $report = ControllerGeneral::ctrRecord('single','reports','where name = "'.$routes[1].'" ');
    switch ( $report ){ case null: include_once '404.php'; }
}

switch ( $report['filter'] ){
    case 1: $filter = ''; break;
    case 2: $filter = ' and created >= "'.$routes[2] .'" and created < "'.date("Y-m-d",strtotime($routes[3]." + 1 days")) .'" '; break;
}

$data = ControllerGeneral::ctrDataTableDynamic( $routes[1], $filter );

?>

<div class="content-wrapper">

    <section class="content pt-2">

        <?php if( $report['filter'] != 1 ) { echo '
        <div class="card p-3">
            <div class="col-md-3 offset-md-9">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="far fa-calendar-alt text-primary"></i></span></div>
                    <input type="text" class="form-control float-right" id="date_between_reports">
                </div>
            </div>
        </div>
        '; } ?>

        <div class="card ">

            <div class="card-body">
                <table class="table dt-responsive w-100" id="tbl_reports_dynamic">

                    <h5>Reporte <?php echo str_replace('-',' ', strtoupper( $routes[1] ) ) ?></h5><hr>

                    <thead>
                    <?php foreach ($data["header"] as $row){ echo'<th>'.$row.'</th>'; } ?>
                    </thead>

                    <tbody>
                    <?php switch ( $report['type'] ){
                        case 1:
                            foreach ($data["data"] as $row){ echo '<tr>';
                                foreach ($data["header"] as $header){ echo'<td>'.$row[$header].'</td>'; }
                                echo '</tr>'; };
                            break;
                        case 2:
                            foreach ($data["data"] as $row){
                                $ref = json_decode( $row['producto'], true );
                                foreach ( $ref as $item ){
                                    $val = 0;
                                    if( isset( $item['reference'] ) ){ $ref = $item['reference']; }
                                    if( isset( $item['ref'] ) ){ $ref = $item['ref']; }
                                    if( isset( $item['price'] ) ){ $val = $item['price']; }
                                    echo '<tr>';
                                    foreach ( $data["header"] as $header ){
                                        switch ( $header ){
                                            case 'ref': $value = $ref; break;
                                            case 'producto': $value = $item['product']; break;
                                            case 'cant': $value = $item['cant']; break;
                                            case 'precio': $value = number_format( $item['price'] ); break;
                                            case 'iva': $value = number_format( $item['tax']*100 ).'%'; break;
                                            case 'total': $value = number_format($val * $item['cant'] ); break;
                                            default: $value = $row[$header]; break;
                                        }
                                        echo ' <td>'.$value.'</td> ';
                                    }
                                }
                            };
                            break;
                    } ?>
                    </tbody>

                </table>
            </div>

        </div>

    </section>

</div>