<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControllerGeneral{

//show records
    static public function ctrRecord ( $type, $table, $other )
    {
        $response = ModelsGeneral::mdlRecord( $type, $table, $other );
        return $response;
    }

//update a field unique
    static public function ctrUpdateFieldUnique( $table, $set, $data )
    {
        $response = ModelsGeneral::mdlUpdateFieldUnique( $table, $set, $data );
        return $response;
    }

//insert row
    static public function ctrInsertRow( $table, $data )
    {
        $response = ModelsGeneral::mdlInsertRow( $table, $data );
        return $response;
    }

//update row
    static public function ctrUpdateRow( $table, $data )
    {
        $response = ModelsGeneral::mdlUpdateRow( $table, $data );
        return $response;
    }

//delete row
    static public function ctrDeleteRow($table, $filter, $value, $other)
    {
        $response = ModelsGeneral::mdlDeleteRecord($table, $filter, $value, $other);
        return $response;
    }

//data table dynamic
    static public function ctrDataTableDynamic( $report, $filter )
    {
        $query = ControllerGeneral::ctrRecord('single','reports','where name = "'.$report.'" ');

        $response = ModelsGeneral::mdlDataTableDynamic( $query["query"] . $filter  );
        return $response;
    }

//execute query
    static public function ctrExecuteQuery( $query )
    {
        $response = ModelsGeneral::mdlExecuteQuery($query);
        return $response;
    }
    static public function ctrExecuteQuerySingle( $query )
    {
        $response = ModelsGeneral::mdlExecuteQuerySingle($query);
        return $response;
    }

//send email
    static public function ctrSendEmail( $data_mail )
    {
        $template = ControllerGeneral::ctrRecord('single','template','where id = 1');

        switch ( $data_mail["typ"] ){
            case 'check':
                $subject = 'Verifación de Cuenta (test)';
                $html = $data_mail['html'];
                break;
            case 'recovery':
                $subject = 'Recuepración de contraseña';
                $html = $data_mail['html'];
                break;
        }

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = $template['hosting'];
        $mail->SMTPAuth = true;
        $mail->Username = $template['mail_send'];
        $mail->Password = $template['mail_send_pass'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($template['mail_send'], $template['system_name']);
        $mail->addAddress( $data_mail['mail'] );

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html;
        $mail->AltBody = '';

        if( $mail->send() ){ echo '
            <script> 
                    swal.fire({
                        title: "'.$data_mail['title'].'",
                        text: "'.$data_mail['text'].'",
                        icon: "'.$data_mail['icon'].'",
                        showCancelButton: false,
                        confirmButtonText: "ok!",
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            history.back();
                        }
                    })
            </script>
        '; }else{ echo
            '<script> 
                    swal.fire({
                        title: "Ocurrio un error...",
                        text: "¡Ha ocurrido un problema enviando información a su correo electrónico '.$data_mail['mail'].' - error:'.$mail->ErrorInfo.' !",
                        icon: "",
                        showCancelButton: false,
                        confirmButtonText: "ok!",
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            history.back();
                        }
                    })
            </script>
        '; }

    }


}

function current_date($type){

    date_default_timezone_set('America/Bogota');

    switch ($type){
        case "date_time":
            return date("Y-m-d H:i:s", time());
            break;
        case "date":
            return date("Y-m-d", time());
            break;
        case "time":
            return date("H:i:s", time());
            break;
        case "value":
            return date("ymdHis", time());
            break;
        case "ym":
            return date("Y-m", time());
            break;
        case "month":
            return date("m", time());
            break;
        case "day":
            return date("d", time());
            break;

    }

}

function new_user( $pass ){echo'
<script>
    swal.fire({ title: "¡Usuario creado con éxito!", html: "La contraseña actual es <b>'.$pass.'</b>, el usuario luego puede personalizarla a su gusto cuando ingrese al sistema", icon: "success", showCancelButton: false, confirmButtonText: "ok!", allowOutsideClick: false,
    }).then((result) => { if (result.value) { history.back(); } })
</script>
';}
function success( $text ){
    ( $_SERVER['HTTP_HOST'] == 'localhost' ) ? $host = 'http://' : $host = 'https://' ; $url = $host.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; echo'
<script>
    swal.fire({ html: "¡'.$text.'!", icon: "success", showCancelButton: false, confirmButtonText: "ok!", allowOutsideClick: false,
    }).then((result) => { if (result.value) { window.location.href= "'.$url.'" ; } })
</script>
';}
function error( $text ){ echo'
<script>
    swal.fire({ title: "Ocurrio un error...", text: "'.$text.'", icon:  "error", showCancelButton: false, confirmButtonText: "ok!", allowOutsideClick: false,
    }).then((result) => { if (result.value) { history.back(); } })
</script>
'; }
function repeated( $text ){echo'
<script>
    swal.fire({ title: "Registro repetido...", text: "'.$text.'", icon:  "warning", showCancelButton: false, confirmButtonText: "ok!", allowOutsideClick: false,
    }).then((result) => { if (result.value) { history.back(); } })
</script>
';}

function valueInLetters($x){
    if ($x<0) { $signo = "Menos ";}
    else      { $signo = "";}
    $x = abs ($x);
    $C1 = $x;
    $G6 = floor($x/(1000000));
    $E7 = floor($x/(100000));
    $G7 = $E7-$G6*10;
    $E8 = floor($x/1000);
    $G8 = $E8-$E7*100;
    $E9 = floor($x/100);
    $G9 = $E9-$E8*10;
    $E10 = floor($x);
    $G10 = $E10-$E9*100;
    $G11 = roUnd(($x-$E10)*100,0);

    $H6 = Unidades($G6);
    if($G7==1 AND $G8==0) { $H7 = "Cien "; }
    else {    $H7 = decenas($G7); }
    $H8 = Unidades($G8);
    if($G9==1 AND $G10==0) { $H9 = "Cien "; }
    else {    $H9 = decenas($G9); }
    $H10 = Unidades($G10);

    if($G6==0) { $I6=" "; }
    elseif($G6==1) { $I6="Mill�n "; }
    else { $I6="Millones "; }
    if ($G8==0 AND $G7==0) { $I8=" "; }
    else { $I8="Mil "; }
    $I10 = "Pesos ";
    $I11 = "m/c ";
    $C3 = $signo.$H6.$I6.$H7.$H8.$I8.$H9.$H10.$I10.$I11;
    return $C3;
}
function Unidades($u){
    if ($u==0)  {$ru = " ";}
    elseif ($u==1)  {$ru = "Un ";}
    elseif ($u==2)  {$ru = "Dos ";}
    elseif ($u==3)  {$ru = "Tres ";}
    elseif ($u==4)  {$ru = "Cuatro ";}
    elseif ($u==5)  {$ru = "Cinco ";}
    elseif ($u==6)  {$ru = "Seis ";}
    elseif ($u==7)  {$ru = "Siete ";}
    elseif ($u==8)  {$ru = "Ocho ";}
    elseif ($u==9)  {$ru = "Nueve ";}
    elseif ($u==10) {$ru = "Diez ";}
    elseif ($u==11) {$ru = "Once ";}
    elseif ($u==12) {$ru = "Doce ";}
    elseif ($u==13) {$ru = "Trece ";}
    elseif ($u==14) {$ru = "Catorce ";}
    elseif ($u==15) {$ru = "Quince ";}
    elseif ($u==16) {$ru = "Dieciseis ";}
    elseif ($u==17) {$ru = "Decisiete ";}
    elseif ($u==18) {$ru = "Dieciocho ";}
    elseif ($u==19) {$ru = "Diecinueve ";}
    elseif ($u==20) {$ru = "Veinte ";}
    elseif ($u==21) {$ru = "Veintiun ";}
    elseif ($u==22) {$ru = "Veintidos ";}
    elseif ($u==23) {$ru = "Veintitres ";}
    elseif ($u==24) {$ru = "Veinticuatro ";}
    elseif ($u==25) {$ru = "Veinticinco ";}
    elseif ($u==26) {$ru = "Veintiseis ";}
    elseif ($u==27) {$ru = "Veintisiente ";}
    elseif ($u==28) {$ru = "Veintiocho ";}
    elseif ($u==29) {$ru = "Veintinueve ";}
    elseif ($u==30) {$ru = "Treinta ";}
    elseif ($u==31) {$ru = "Treinta y Un ";}
    elseif ($u==32) {$ru = "Treinta y Dos ";}
    elseif ($u==33) {$ru = "Treinta y Tres ";}
    elseif ($u==34) {$ru = "Treinta y Cuatro ";}
    elseif ($u==35) {$ru = "Treinta y Cinco ";}
    elseif ($u==36) {$ru = "Treinta y Seis ";}
    elseif ($u==37) {$ru = "Treinta y Siete ";}
    elseif ($u==38) {$ru = "Treinta y Ocho ";}
    elseif ($u==39) {$ru = "Treinta y Nueve ";}
    elseif ($u==40) {$ru = "Cuarenta ";}
    elseif ($u==41) {$ru = "Cuarenta y Un ";}
    elseif ($u==42) {$ru = "Cuarenta y Dos ";}
    elseif ($u==43) {$ru = "Cuarenta y Tres ";}
    elseif ($u==44) {$ru = "Cuarenta y Cuatro ";}
    elseif ($u==45) {$ru = "Cuarenta y Cinco ";}
    elseif ($u==46) {$ru = "Cuarenta y Seis ";}
    elseif ($u==47) {$ru = "Cuarenta y Siete ";}
    elseif ($u==48) {$ru = "Cuarenta y Ocho ";}
    elseif ($u==49) {$ru = "Cuarenta y Nueve ";}
    elseif ($u==50) {$ru = "Cincuenta ";}
    elseif ($u==51) {$ru = "Cincuenta y Un ";}
    elseif ($u==52) {$ru = "Cincuenta y Dos ";}
    elseif ($u==53) {$ru = "Cincuenta y Tres ";}
    elseif ($u==54) {$ru = "Cincuenta y Cuatro ";}
    elseif ($u==55) {$ru = "Cincuenta y Cinco ";}
    elseif ($u==56) {$ru = "Cincuenta y Seis ";}
    elseif ($u==57) {$ru = "Cincuenta y Siete ";}
    elseif ($u==58) {$ru = "Cincuenta y Ocho ";}
    elseif ($u==59) {$ru = "Cincuenta y Nueve ";}
    elseif ($u==60) {$ru = "Sesenta ";}
    elseif ($u==61) {$ru = "Sesenta y Un ";}
    elseif ($u==62) {$ru = "Sesenta y Dos ";}
    elseif ($u==63) {$ru = "Sesenta y Tres ";}
    elseif ($u==64) {$ru = "Sesenta y Cuatro ";}
    elseif ($u==65) {$ru = "Sesenta y Cinco ";}
    elseif ($u==66) {$ru = "Sesenta y Seis ";}
    elseif ($u==67) {$ru = "Sesenta y Siete ";}
    elseif ($u==68) {$ru = "Sesenta y Ocho ";}
    elseif ($u==69) {$ru = "Sesenta y Nueve ";}
    elseif ($u==70) {$ru = "Setenta ";}
    elseif ($u==71) {$ru = "Setenta y Un ";}
    elseif ($u==72) {$ru = "Setenta y Dos ";}
    elseif ($u==73) {$ru = "Setenta y Tres ";}
    elseif ($u==74) {$ru = "Setenta y Cuatro ";}
    elseif ($u==75) {$ru = "Setenta y Cinco ";}
    elseif ($u==76) {$ru = "Setenta y Seis ";}
    elseif ($u==77) {$ru = "Setenta y Siete ";}
    elseif ($u==78) {$ru = "Setenta y Ocho ";}
    elseif ($u==79) {$ru = "Setenta y Nueve ";}
    elseif ($u==80) {$ru = "Ochenta ";}
    elseif ($u==81) {$ru = "Ochenta y Un ";}
    elseif ($u==82) {$ru = "Ochenta y Dos ";}
    elseif ($u==83) {$ru = "Ochenta y Tres ";}
    elseif ($u==84) {$ru = "Ochenta y Cuatro ";}
    elseif ($u==85) {$ru = "Ochenta y Cinco ";}
    elseif ($u==86) {$ru = "Ochenta y Seis ";}
    elseif ($u==87) {$ru = "Ochenta y Siete ";}
    elseif ($u==88) {$ru = "Ochenta y Ocho ";}
    elseif ($u==89) {$ru = "Ochenta y Nueve ";}
    elseif ($u==90) {$ru = "Noventa ";}
    elseif ($u==91) {$ru = "Noventa y Un ";}
    elseif ($u==92) {$ru = "Noventa y Dos ";}
    elseif ($u==93) {$ru = "Noventa y Tres ";}
    elseif ($u==94) {$ru = "Noventa y Cuatro ";}
    elseif ($u==95) {$ru = "Noventa y Cinco ";}
    elseif ($u==96) {$ru = "Noventa y Seis ";}
    elseif ($u==97) {$ru = "Noventa y Siete ";}
    elseif ($u==98) {$ru = "Noventa y Ocho ";}
    else            {$ru = "Noventa y Nueve ";}
    return $ru;
}
function decenas($d){
    if ($d==0)  {$rd = "";}
    elseif ($d==1)  {$rd = "Ciento ";}
    elseif ($d==2)  {$rd = "Doscientos ";}
    elseif ($d==3)  {$rd = "Trescientos ";}
    elseif ($d==4)  {$rd = "Cuatrocientos ";}
    elseif ($d==5)  {$rd = "Quinientos ";}
    elseif ($d==6)  {$rd = "Seiscientos ";}
    elseif ($d==7)  {$rd = "Setecientos ";}
    elseif ($d==8)  {$rd = "Ochocientos ";}
    else            {$rd = "Novecientos ";}
    return $rd;
}
function print_doc( $dir ){ echo'
<script>localStorage.clear(); currentUrl = window.location; window.location = currentUrl + "'.$dir.'" </script>
';}

function clean_name_file($texto){
    $texto = str_ireplace('á','a',$texto);
    $texto = str_ireplace('é','e',$texto);
    $texto = str_ireplace('í','i',$texto);
    $texto = str_ireplace('ó','o',$texto);
    $texto = str_ireplace('ú','u',$texto);
    $texto = str_ireplace(' ','-',$texto);
    return $texto;
}
function clean_scanned( $scan, $dir ){
    $scan = str_ireplace('".","..","','{"img":"'.$dir,$scan);
    $scan = str_ireplace('","','"},{"img":"'.$dir,$scan);
    $scan = str_ireplace('"]','"}]',$scan);
    $scan = str_ireplace('../','',$scan);
    return $scan;
}

function dateDiffInDays($date1, $date2) {
    $diff = strtotime($date2) - strtotime($date1);
    return abs(round($diff / 86400));
}