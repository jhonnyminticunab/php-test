<?php
$customer = ControllerGeneral::ctrRecord('single','customer','where id='.$routes[3]);

switch ( $customer["segment"] ){
    case 1: $tab = "sale"; $header = $template['header_invoice'] ; $txt = 'Orden de Compra'; $pre='OC-'; break;
    case 2: $tab = "prospectus"; $header = $template['header_pros'] ; $txt = 'Remisión'; $pre='RM-'; break;
}

$data = ControllerGeneral::ctrRecord('single',$tab,'where id>42 and sales='.$routes[2]);
$products = json_decode( $data["products"], true );

if( isset( $routes[4] ) ){
    if( $routes[4] == 'send') { $send = new ControllerSending(); $send -> ctrInvoice( $data['id'] ); }
}
$rf = 0; $ri = 0;
?>

<style>





</style>

<div class="content-wrapper">
    <section>
        <div style="padding-bottom:600px "></div>
        <div id="print" style="background-color: #ffffff;color: #0a0a0a;width: 340px;padding: 15px; font-weight: 100">
            <div class="text-center"><img src="<?= $url.$template['favicon'] ?>" style="max-width: 50%; height: auto; "></div>
            <div class="text-center f4"><?='<pre>'.$header.'</pre></div>
            <hr>
            <div class="text-right f3 pb-2">'.$txt.':'.$pre.$data["sales"].'</div>
            <div class="text-left f2">Fecha: &nbsp;&nbsp;'.$data["created"].'</div>
            <div class="text-left f2">Vendedor: '.$data["user_name"].'</div>
            <hr>
            <table>
            <tr>
                <td class="text-left f3" colspan="4">Cliente:&nbsp;&nbsp;'.$customer["business_name"].'</td>
            </tr>
            <tr>
                <td class="text-right f3">Dir:&nbsp;&nbsp;'.$customer["address"].'</td>
                <td class="text-left f1">&nbsp;&nbsp;</td>
                <td class="text-right f3">Tel:&nbsp;&nbsp;'.$customer["person_phone"].'</td>
                <td class="text-left f1"></td>
            </tr>
            </table>
            <hr>
            <table width="100%" class="f3">
                <thead class="text-center">
                <th>Producto</th>
                <th>Cant</th>
                <th>Precio</th>';
                $tab == 'sale' ? '<th>%Iva</th>' : ''; echo'
                <th>Total</th>
                </thead>
                <tbody>
                ';
            $sumSub = 0;$sumTax = 0;$sumTot = 0;

            foreach ($products as $row){

                $pri = number_format( round($row["price"]/(1+$row["tax"]),2),0 );
                $tax = round($row["tax"]*100,0);
                $tot = number_format( $row["price"] * $row["cant"] );

                if( $customer['segment'] == 1 ){
                    $sumSub+= ( $row["price"] / ( 1 + $row["tax"] )) * $row["cant"];
                    $sub = $sumSub;

                    $sumTax+= ( $row["price"] * $row["cant"] - ( ( $row["price"] / ( 1 + $row["tax"] )) * $row["cant"] ));
                    $tax_tot = $sumTax - ($sumTax * ($data['dto']/100) );

                    $sumTot+= ( $row["price"] * $row["cant"] );
                    $total = $sumTot - ($sumTot * ($data['dto']/100) );
                }else{
                    $sumSub+= $row["price"] * $row["cant"];
                    $sub = $sumSub;

                    $sumTot+= ( $row["price"] * $row["cant"] );
                    $total = $sumTot - ($sumTot * ($data['dto']/100) );
                }


                $dto = $sumSub * ($data['dto']/100);

                echo'
                    <tr>
                    <td class="text-left">'.$row["product"].'</td>
                    <td class="text-center">'.$row["cant"].'</td>
                    <td class="text-right">'.$pri.'</td>';
                    $tab == 'sale' ? '<td class="text-center">'.$tax.'</td>' : ''; echo'
                    <td class="text-right">'.$tot.'</td>
                    </tr>
                
                ';}

            echo'
                </tbody>
            </table>
            <hr>
            <table width="100%">
                <tr>
                    <td class="text-right f3" style="width: 75%">Sub-Total:&nbsp;&nbsp;</td>
                    <td class="text-right f3">'.number_format($sub,2).'</td>
                </tr>
                <tr>
                    <td class="text-right f3">dto:&nbsp;&nbsp;</td>
                    <td class="text-right f3">'.number_format($dto,2).'</td>
                </tr>';
                if( $tab == 'sale' ){
                    echo '<tr> <td class="text-right f3">Iva:&nbsp;&nbsp;</td> <td class="text-right f3">'.number_format($tax_tot,2).'</td> </tr> ' ;
                    if ($customer['withholding'] == 1){
                        $rf = ($sub - $dto) * $template['retefuente']; $ri = (($sub - $dto) * $template['reteica'])/1000;
                        echo '<tr> <td class="text-right f3">Retenciones:&nbsp;&nbsp;</td> <td class="text-right f3">'.number_format($rf + $ri,2).'</td> </tr> '
                        ;}
                    $total = $total - ($rf + $ri)  ;
                } echo'
                <tr>'; $tab == 'sale' ?  $tt='Total&nbsp;de&nbsp;la&nbsp;factura' : $tt='Total'; echo'
                    <td class="text-right f3">'.$tt.':&nbsp;&nbsp;</td>
                    <td class="text-right f3">'.number_format($total,2).'</td>
                </tr>
                <tr>'; $tab == 'sale' ?  $pay='Pago&nbsp;Realizado' : $pay='Inicial'; echo'
                    <td class="text-right f3">'.$pay.':&nbsp;&nbsp;</td>
                    <td class="text-right f3">'.number_format( $data["cash"]+$data["card"]+$data["other"],2).'</td>
                </tr>
                <tr>'; $tab == 'sale' ?  $bt='Saldo' : $bt='Restante'; echo'
                    <td class="text-right f3">'.$bt.':&nbsp;&nbsp;</td>
                    <td class="text-right f3">'.number_format( $total-$data["cash"]-$data["card"]-$data["other"] ,2).'</td>
                </tr>
            </table>
            <hr>
            <div class="f2 text-center">( Son: '.valueInLetters($data['total']).' )</div>
            <hr>';
            ?>
            <div class="text-center f3"><pre><?=$template['footer']?></pre></div>
            <div class="text-center f1">*Elaborado por www.apponlinecol.com*</div>
            <hr>
        </div>
    </section>
</div>


<script>

    $(function () {

        $(".loader").fadeIn("slow");
        var sale = "<?php echo $data["sales"]?>";

        html2canvas($('#print').get(0)).then( function (canvas) {
            var a = document.createElement('a');
            a.href = canvas.toDataURL("image/jpg");
            a.download = 'S-'+sale+'.jpg';
            a.click();
        });

        if( $("#txtRol").val() != 3){
            setTimeout(function(){ window.history.back(); }, 1000);
        }else{
            setTimeout(function(){ window.location.href = url+"sales"; }, 1000);
        }

    })

</script>


