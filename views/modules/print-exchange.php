<?php
$customer = ControllerGeneral::ctrRecord('single','customer','where id='.$routes[3]);
$data = ControllerGeneral::ctrRecord('single','exchanges','where exchange='.$routes[2]);
$in_products = json_decode( $data["in_products"], true );
$out_products = json_decode( $data["out_products"], true );
$diff = $data['out_val']-$data['in_val'];
//var_dump($data)
?>

<div class="content-wrapper">
    <section>
        <div style="padding-bottom:600px "></div>
        <div id="print" style="background-color: #ffffff;color: #0a0a0a;width: 340px;padding: 15px; font-weight: 100">
            <div class="text-center"><img src="<?= $url.$template['favicon'] ?>" style="max-width: 50%; height: auto; "></div>
            <div class="text-center f4"><?='<pre>'.$template['header_pros'].'</pre></div>
            <hr>
            <div class="text-right f3 pb-2">Cambios y/o devoluciones: N-'.$data["exchange"].'</div>
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
            <div class="text-center text-bold">Entradas</div>
            <table width="100%" class="f3">
                <thead class="text-center">
                <th>Producto</th>
                <th>Cant</th>
                <th>Precio</th>
                <th>Total</th>
                </thead>
                <tbody>
                ';
            foreach ($in_products as $row){ echo'
                    <tr>
                    <td class="text-left">'.$row["product"].'</td>
                    <td class="text-center">'.$row["cant"].'</td>
                    <td class="text-right">'.number_format($row["price"],0).'</td>
                    <td class="text-right">'.number_format($row["cant"]*$row["price"],0).'</td>
                    </tr>
                ';}
            echo' </tbody>
            </table>
            <hr>
            <div class="text-center  text-bold">Salidas</div>
            <table width="100%" class="f3">
                <thead class="text-center">
                <th>Producto</th>
                <th>Cant</th>
                <th>Precio</th>
                <th>Total</th>
                </thead>
                <tbody>
                ';
            foreach ($out_products as $row){ echo'
                    <tr>
                    <td class="text-left">'.$row["product"].'</td>
                    <td class="text-center">'.$row["cant"].'</td>
                    <td class="text-right">'.number_format($row["price"],0).'</td>
                    <td class="text-right">'.number_format($row["cant"]*$row["price"],0).'</td>
                    </tr>
                ';}
            echo' </tbody>
            </table>
            <hr>
            <table width="100%">
                <tr>
                    <td class="text-right f3" style="width: 75%">Valor&nbsp;entradas:&nbsp;&nbsp;</td>
                    <td class="text-right f3">'.number_format($data['in_val'],0).'</td>
                </tr>
                <tr>
                    <td class="text-right f3" style="width: 75%">Valor&nbsp;salidas:&nbsp;&nbsp;</td>
                    <td class="text-right f3">'.number_format($data['out_val'],0).'</td>
                </tr>
                <tr>
                    <td class="text-right f3" style="width: 75%">Diferencia:&nbsp;&nbsp;</td>
                    <td class="text-right f3">'.number_format($diff,0).'</td>
                </tr>
            </table>
            <hr>
            <div class="f2 text-center">( Diferencia por: '.valueInLetters($diff).' )</div>
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
        var sale = "<?php echo $data["exchange"]?>";

        html2canvas($('#print').get(0)).then( function (canvas) {
            var a = document.createElement('a');
            a.href = canvas.toDataURL("image/jpg");
            a.download = 'CD-'+sale+'.jpg';
            a.click();
        });

        if( $("#txtRol").val() != 3){
            setTimeout(function(){ window.history.back(); }, 1000);
        }else{
            setTimeout(function(){ window.location.href = url+"sales"; }, 1000);
        }

    })

</script>