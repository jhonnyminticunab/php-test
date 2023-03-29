<?php
$customer = ControllerGeneral::ctrRecord('single','customer','where id='.$routes[3]);

switch ( $customer["segment"] ){
    case 1: $tab = "sale"; $header = $template['header_invoice'] ; $txt = 'Orden de Compra'; break;
    case 2: $tab = "prospectus"; $header = $template['header_pros'] ; $txt = 'Remisión'; break;
}
$data = ControllerGeneral::ctrRecord('single','payment','where payment='.$routes[2]);
$sold = ControllerGeneral::ctrRecord('single',$tab,'where sales='.$data['sales']);
$ini = $sold['cash'] + $sold['card'] + $sold['other'];

$payment = ControllerGeneral::ctrRecord('all','payment','where sales='.$data['sales'].' and type="'.$tab.'" and created< "'.$data['created'].'" ');
$payments = 0; foreach ( $payment as $row ){ $payments += $row['cash'] + $row['card'] + $row['other']; }

?>

<div class="content-wrapper">
    <section>
        <div style="padding-bottom:600px "></div>
        <div id="print" style="background-color: #ffffff;color: #0a0a0a;width: 340px;padding: 15px; font-weight: 100">
            <div class="text-center"><img src="<?= $url.$template['favicon'] ?>" style="max-width: 50%; height: auto; "></div>
            <div class="text-center f4"><?='<pre>'.$header.'</pre></div>
            <hr>
            <div class="text-right text-sm pb-0">Recibo: N-'.$data["payment"].'</div>
            <div class="text-right text-sm pb-2">'.$txt.': N-'.$data["sales"].'</div>
            <div class="text-left text-md">Fecha: &nbsp;&nbsp;'.$data["created"].'</div>
            <div class="text-left text-md">Vendedor: '.$data["user_name"].'</div>
            <hr>
            <table>
            <tr>
                <td class="text-left text-sm" colspan="4">Cliente:&nbsp;&nbsp;'.$customer["business_name"].'</td>
            </tr>
            <tr>
                <td class="text-right text-sm">Dir:&nbsp;&nbsp;'.$customer["address"].'</td>
                <td class="text-left f1">&nbsp;&nbsp;</td>
                <td class="text-right text-sm">Tel:&nbsp;&nbsp;'.$customer["person_phone"].'</td>
                <td class="text-left f1"></td>
            </tr>
            </table>
            <hr>
            <table class="txt_sm" width="100%">
                <tr> <td class="text-right" style="width: 80%">Total:</td> <td class="text-right" style="width: 20%">'.number_format( $sold['total'],0).'</td> </tr>
                <tr> <td class="text-right" style="width: 80%">Saldo Anterior:</td> <td class="text-right" style="width: 20%">'.number_format( $sold['total'] - $payments - $ini,0 ).'</td> </tr>
                <tr class="bold"> <td class="text-right" style="width: 80%">Abono:</td> <td class="text-right" style="width: 20%">'.number_format( $data['cash'] + $data['card'] + $data['other'],0).'</td> </tr>
                <tr> <td class="text-right" style="width: 80%">Saldo Actual:</td> <td class="text-right" style="width: 20%">'.number_format( $sold['total'] - $payments - $ini - $data['cash'] - $data['card'] - $data['other'],0).'</td> </tr>
            </table>
            <hr>
            <div class="text-md text-center">( Abono actual: '.valueInLetters( $data['cash'] + $data['card'] + $data['other'] ).' )</div> <hr>
            '; ?>
            <div class="text-center f3"><pre><?=$template['footer']?></pre></div>
            <div class="text-center f1">*Elaborado por www.apponlinecol.com*</div>
            <hr>
        </div>
    </section>
</div>

<script>

    $(function () {

        $(".loader").fadeIn("slow");
        var sale = "<?php echo $data["payment"]?>";

        html2canvas($('#print').get(0)).then( function (canvas) {
            var a = document.createElement('a');
            a.href = canvas.toDataURL("image/jpg");
            a.download = 'P-'+sale+'.jpg';
            a.click();
        });

        if( $("#txtRol").val() != 3){
            setTimeout(function(){ window.history.back(); }, 1000);
        }else{
            setTimeout(function(){ window.location.href = url+"sales"; }, 1000);
        }

    })

</script>