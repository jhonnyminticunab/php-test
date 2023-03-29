<?php

require_once '../controllers/general.controller.php';
require_once '../models/general.models.php';

class AjaxImages{

    public $type;
    public $id;
    public $route;
    public $images;
    public $name;
    public $table;
    public $set;
    public $file;
    public $field;

    public function AjaxLoadImage(){

        $directory = '../'.$this->route;
        $file = $this->images;

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $images = count(isset($file['name'])?$file['name']:0);
        $uploaderImages = [];
        for($i = 0; $i < $images; $i++) {

            $name_file=isset($file['name'][$i])?$file['name'][$i]:null;
            $name_temp=isset($file['tmp_name'][$i])?$file['tmp_name'][$i]:null;
            $file_path = $directory.clean_name_file($name_file);

            move_uploaded_file($name_temp,$file_path);

            $del="/ajax/images.ajax.php";
            $info_img[$i] = [ "caption" => clean_name_file($name_file), "height" => "120px", "url"=>$del, "key" => $name_file, 'route' => str_replace('../','',$directory), 'remove' => 'delete' ];
            $update_img[$i] = '<img src="../'.$file_path.'" width="80%" class="file-preview-image">';

        }

        $data = [
            'file_id' => 0,
            'overwriteInitial' => true,
            'initialPreviewConfig' => $info_img,
            'initialPreview' => $update_img
        ];

        $error = ['error'];
        $scanned_directory = clean_name_file( scandir( $directory ) );
        $scan = clean_scanned(json_encode($scanned_directory),$directory);
        $data_update = [
            'id' => $this->id,
            'set' =>  $scan ,
        ];
        $response = ControllerGeneral::mdlUpdateFieldUnique($this->table,'multimedia',$data_update);

        echo json_encode($data_update);

    }
    public function AjaxDeleteImage(){

        $directory = '../'.$this->route;

        if( isset( $this->name ) ){

            if( unlink($directory.$this->name ) ){
                $data = $this->route ;
            };

        }

        $error = ['error'];
        $scanned_directory = clean_name_file( scandir( $directory ) );
        $scan = clean_scanned(json_encode($scanned_directory),$directory);

        $carpeta = @scandir($directory);
        if (count($carpeta) > 2){
            $data_update = [
                'id' => $this->id,
                'set' =>  $scan ,
            ];
        }else{
            $data_update = [
                'id' => $this->id,
                'set' =>  null ,
            ];
        }

        $response = ControllerGeneral::mdlUpdateFieldUnique($this->table,$this->set,$data_update);

        if( $response == 'ok' ){
            echo json_encode( $data );
        }else{
            echo json_encode( $error );
        }


    }
    public function AjaxOnlyImage(){

        $directory = '../'.$this->route;
        $file = $this->file;

        $info = ControllerGeneral::ctrRecord('single',$this->table,'where id ='.$this->id );
        if ( $info[$this->field] != null ){
            if( unlink('../'.$info[$this->field] ) ){}
        }

        $name_file=isset($file['name'])?$file['name']:null;
        $name_temp=isset($file['tmp_name'])?$file['tmp_name']:null;
        $file_path = $directory.clean_name_file($name_file);

        move_uploaded_file( $name_temp, $file_path );
        $response = ControllerGeneral::ctrUpdateFieldUnique( $this->table, $this->field, [ 'set' => clean_name_file($this->route.$name_file), 'id' => $this->id ] );

        switch ($response){
            case 'ok':
                echo 'ok';
                break;
            default:
                echo $response;
                break;
        }


    }
    public function AjaxCaptureImage(){

        switch ( $this->type ){
            case 5: $multi = 'multimedia_customer'; break;
            default: $multi = 'multimedia_users'; break;
        }

        $directory = '../'.$this->route.$this->name.'/'.$multi.'/';
        $file = $this->file;

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $data = base64_decode($file);
        file_put_contents($directory.'support_'.current_date('value').'.jpg', $data);



        $scanned_directory = clean_name_file( scandir( $directory ) );
        $scan = clean_scanned(json_encode($scanned_directory),$directory);
        $data_update = [
            'id' => $this->id,
            'set' =>  $scan ,
        ];
        $response = ControllerGeneral::mdlUpdateFieldUnique($this->table,$multi,$data_update);

        switch ($response){
            case 'ok':
                echo 'ok';
                break;
            default:
                echo $response;
                break;
        }

    }


}


// actions
if( isset( $_POST['load'] ) ){
    $img = new AjaxImages();
    $img -> type = $_POST['type'];
    $img -> id = $_POST['id'];
    $img -> route = $_POST['route'];
    $img -> images = $_FILES['images'];
    $img -> table = $_POST['direction'];
    $img -> AjaxLoadImage();
}
if( isset( $_POST['remove'] ) ){
    $img = new AjaxImages();
    $img -> id = $_POST['id'];
    $img -> name = $_POST['key'];
    $img -> route = $_POST['route'];
    $img -> table = $_POST['direction'];
    $img -> set = $_POST['set'];
    $img -> AjaxDeleteImage();
}
if( isset( $_POST['only'] ) ){
    $img = new AjaxImages();
    $img -> id = $_POST['only'];
    $img -> route = $_POST['url'];
    $img -> table = $_POST['direction'];
    $img -> file = $_FILES['file'];
    $img -> field = $_POST['field'];
    $img -> AjaxOnlyImage();
}
if( isset( $_POST['capture'] ) ){
    $img = new AjaxImages();
    $img -> id = $_POST['capture'];
    $img -> route = $_POST['url'];
    $img -> table = $_POST['direction'];
    $img -> file = $_POST['file'];
    $img -> name = $_POST['name'];
    $img -> field = $_POST['field'];
    $img -> type = $_POST['type'];
    $img -> AjaxCaptureImage();
}