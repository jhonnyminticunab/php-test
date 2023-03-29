<?php

class ControllerUsers{

    static public function ctrEntryUsers()
    {
        if( isset( $_POST['username'] ) ){

            $type = strpos( $_POST['username'] , '@' );
            $user = str_replace ( ' ','',$_POST['username']);

            switch ( $type ){
                case false: $preg_match_username = 'preg_match(\'/^[a-zA-Z0-9]+$/\', $user )';  break; //username
                default:  $preg_match_username = 'preg_match(\'/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/\', $_POST[\'username\'] )'; break; //email
            }

            if( $preg_match_username ){

                $data_user = ModelsGeneral::mdlRecord('single','users',"where username = '$user'" );

                if( empty($data_user) ){

                    echo '<script>toastr.warning("<b>¡Usuario no existe!</b> intentelo de nuevo o comuniquese con el administrador"); setTimeout(function(){ window.history.back(); }, 2000);</script>';

                }elseif ( password_verify( $_POST['password'], $data_user['password'] ) ) {

                    switch ( $data_user['status'] ){

                        case 1:
                            $data = array(
                                'set' => current_date("date_time"),
                                'id' => $data_user['id']
                            );

                            $lastLogin = ModelsGeneral::mdlUpdateFieldUnique( 'users', 'last_login', $data );

                            switch ( $lastLogin ){
                                case 'ok':

                                    $_SESSION['startSesion'] = 'ok';
                                    $_SESSION['id'] = $data_user['id'];
                                    $_SESSION['role'] = $data_user['role'];
                                    $_SESSION['site'] = $data_user['site'];

                                    switch ( $data_user['role'] ){
                                        case 1: echo '<script> window.location = "dashboard"; </script>'; break;
                                        case 2: echo '<script> window.location = "dashboard"; </script>'; break;
                                        case 3: echo '<script> window.location = "sales";</script>'; break;
                                    }
                                    break;

                            }
                            break;

                        default:
                            echo '<script>toastr.info("<b>¡El usuario no está activado!</b> solicítele al administrador la activación"); setTimeout(function(){ window.history.back(); }, 2000);</script>';
                            break;

                    }

                }else{
                    echo '<script>toastr.error("<b>¡Contraseña errada!</b> intentelo de nuevo o de click en olvide mi contraseña"); setTimeout(function(){ window.history.back(); }, 2000);</script>';
                }

            }



        }
    }
    static public function ctrUpdatePass( $id )
    {
        if( isset( $_POST['update_password'] ) ){
            $data = [ 'id' => $id, 'set' => password_hash( $_POST['update_password'], PASSWORD_DEFAULT ), ];
            $response = ControllerGeneral::ctrUpdateFieldUnique('users','password',$data);
            switch ( $response ){ case 'ok': echo success('¡Cambio de contraseña realizada con éxito!'); break; default: echo error('¡Intente de nuevo o comuníquese con el administrador!'); break; }
        }
    }
    static public function ctrUpdateInsertUsers()
    {
        $pass = 0;
        if( isset( $_POST['usu_id'] ) ){

            switch ( $_POST['usu_id'] ){

                case 0:
                    $pass =  substr(str_shuffle( '1234567890' ), 0, 4);
                    $data = [
                        'name' => $_POST['name'],
                        'document' => $_POST['document'],
                        'username' => $_POST['username'],
                        'role' => $_POST['role'],
                        'site' => $_POST['site'],
                        'email' => $_POST['email'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'],
                        'password' => password_hash( $pass, PASSWORD_DEFAULT )
                    ];
                    $response = ControllerGeneral::ctrInsertRow('users',$data);
                    switch ( $response ){ case 'ok': echo new_user($pass); break; default: echo error('¡Intente de nuevo o comuníquese con el administrador!'); break; }
                    break;
                default:
                    $user = ControllerGeneral::ctrRecord('single','users','where id = "'.$_POST['usu_id'] .'"');
                    $data = [
                        'id' => $user['id'],
                        'name' => $_POST['name'],
                        'document' => $_POST['document'],
                        'username' => $_POST['username'],
                        'role' => $_POST['role'],
                        'site' => $_POST['site'],
                        'email' => $_POST['email'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'],
                        'password' => $user['password'],
                    ];
                    $response = ControllerGeneral::ctrUpdateRow('users',$data);
                    switch ( $response ){ case 'ok': echo success('¡Actualización realizada con éxito!'); break; default: echo error('¡Intente de nuevo o comuníquese con el administrador!'); break; }
                    break;
            }

        }

    }
    static public function ctrChangeStatusUser($user, $sta)
    {

        /*$data = array(
            'set' => current_date("date_time"),
            'id' => $data_user['id']
        );*/

        $respuesta =  ModelsGeneral::mdlUpdateFieldUnique('','','');
        return $respuesta;

    }
    static public function ctrRecoverPass()
    {
        if( isset( $_POST['mail_recovery'] ) ){

            $validate =  ModelsGeneral::mdlRecord('single','users','where email = "'.$_POST['mail_recovery'].'" and username = "'.$_POST['username_recovery'].'" ');

            if( $validate != false){

                $pass =  substr(str_shuffle( 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!#$%&/()=' ), 0, 10);

                $data = [ 'id' => $validate['id'], 'set' => password_hash( $pass , PASSWORD_DEFAULT ), ];
                $recovery = ControllerGeneral::ctrUpdateFieldUnique('users','password',$data);

                switch ( $recovery ){
                    case "ok":
                        $template = ModelsGeneral::mdlRecord('single','template','where id = 1');
                        $data_mail = [
                            'typ' => 'recovery',
                            'mail' => $_POST['mail_recovery'],
                            'html' => ' <div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
                                        <div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
                                            <center>
                                                <h3 style="font-weight:100; color:#999">Generación de nueva contraseña</h3>
                                                <hr style="border:1px solid #ccc; width:80%">
                                                <h4 style="font-weight:100; color:#999; padding:0 20px">Su nueva contraseña es:</h4><br>
                                                <div style="line-height:30px; background:'.$template['corporate_color'].'; width:60%; color:white; border-radius: 20px">'.$pass.'</div>
                                                <br>
                                                <hr style="border:1px solid #ccc; width:80%">
                                            </center>
                                        </div>',
                            'title' => '¡Contraseña generada con Éxito!',
                            'text' => '¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico '.$_POST['mail_recovery'].' para obtener su nueva contraseña!',
                            'icon' => 'success',
                        ];
                        ControllerGeneral::ctrSendEmail($data_mail);
                        break;
                }

            }else{
                return recovery_error();
            }

        }
    }

}

