<?php

require_once '../controllers/general.controller.php';
require_once '../models/general.models.php';

class AjaxGeneral{

    public $id;
    public $value;
    public $set;
    public $field;
    public $table;
    public $filter;
    public $search;
    public $column1;
    public $column2;
    public $column3;

    public function ajaxAll(){
        $response = ControllerGeneral::ctrRecord('all',$this->table,'where '.$this->filter);
        echo json_encode($response);
    }
    public function ajaxDetailed(){
        $response = ControllerGeneral::ctrRecord('single',$this->table,'where id = '.$this->id);
        echo json_encode($response);
    }
    public function AjaxUpdateText(){
        switch ( $this->field ){
            case 'EMI_23_codigo_municipio':
                $company = ControllerGeneral::ctrRecord('single', $this->table,'');
                $tag = ControllerGeneral::ctrRecord('single','tags','where id='.$this->value);
                $data = [
                    'id' => 1,
                    'EMI_1_tipo_identificacion' => $company['EMI_1_tipo_identificacion'],
                    'EMI_2_numero_identificacion' => $company['EMI_2_numero_identificacion'],
                    'EMI_3_tipo_documento_identificacion' => $company['EMI_3_tipo_documento_identificacion'],
                    'EMI_4_regimen' => $company['EMI_4_regimen'],
                    'EMI_6_razon_social' => $company['EMI_6_razon_social'],
                    'EMI_7_nombre_comercial' => $company['EMI_7_nombre_comercial'],
                    'EMI_10_direccion' => $company['EMI_10_direccion'],
                    'EMI_11_departamento' => $tag['other'],
                    'EMI_13_ciudad_municipio' => $tag['tag'],
                    'EMI_14_codigo_postal' => $company['EMI_14_codigo_postal'],
                    'EMI_15_codigo_pais' => $company['EMI_15_codigo_pais'],
                    'EMI_18_direccion_postal' => $company['EMI_18_direccion_postal'],
                    'EMI_19_nombre_departamento' => $tag['complement'],
                    'EMI_21_nombre_pais' => $company['EMI_21_nombre_pais'],
                    'EMI_22_digito_verificacion' => $company['EMI_22_digito_verificacion'],
                    'EMI_23_codigo_municipio' => $tag['cod'],
                    'EMI_24_nombre_registrado_rut' => $company['EMI_24_nombre_registrado_rut'],
                    'EMI_25_codigo_ciiu' => $company['EMI_25_codigo_ciiu'],
                    'TAC_1_obligaciones_contribuyente' => $company['TAC_1_obligaciones_contribuyente'],
                    'ICC_1_numero_matricula_mercantil' => $company['ICC_1_numero_matricula_mercantil'],
                    'ICC_9_prefijo_facturacion_autorizado' => $company['ICC_9_prefijo_facturacion_autorizado'],
                    'CDE_1_tipo_contacto' => $company['CDE_1_tipo_contacto'],
                    'CDE_2_nombre_contacto' => $company['CDE_2_nombre_contacto'],
                    'CDE_3_telefono_contacto' => $company['CDE_3_telefono_contacto'],
                    'CDE_4_correo_contacto' => $company['CDE_4_correo_contacto'],
                    'DRF_1_numero_autorizacion_dian' => $company['DRF_1_numero_autorizacion_dian'],
                    'DRF_2_fecha_inicio' => $company['DRF_2_fecha_inicio'],
                    'DRF_3_fech_fin' => $company['DRF_3_fech_fin'],
                    'DRF_5_rango_minimo' => $company['DRF_5_rango_minimo'],
                    'DRF_6_rango_maximo' => $company['DRF_6_rango_maximo'],
                    'ENC_4_version_ubl' => $company['ENC_4_version_ubl'],
                    'ENC_5_version_dian' => $company['ENC_5_version_dian'],
                    'ENC_20_ambiente_trabajo' => $company['ENC_20_ambiente_trabajo'],
                    'ENC_21_tipo_operacion' => $company['ENC_21_tipo_operacion']
                ];
                $response = ControllerGeneral::ctrUpdateRow( $this->table, $data);
                break;
            case 'EMI_10_direccion':
                ControllerGeneral::ctrUpdateFieldUnique( $this->table, 'EMI_18_direccion_postal', [ 'id' => $this->id, 'set' => $this->value, ] );
                $response = ControllerGeneral::ctrUpdateFieldUnique( $this->table, $this->field, [ 'id' => $this->id, 'set' => $this->value, ] ); break;
            case 'EMI_6_razon_social':
                ControllerGeneral::ctrUpdateFieldUnique( $this->table, 'EMI_24_nombre_registrado_rut', [ 'id' => $this->id, 'set' => $this->value, ] );
                $response = ControllerGeneral::ctrUpdateFieldUnique( $this->table, $this->field, [ 'id' => $this->id, 'set' => $this->value, ] ); break;
            default:
                $response = ControllerGeneral::ctrUpdateFieldUnique( $this->table, $this->field, [ 'id' => $this->id, 'set' => $this->value, ] ); break;
        }

        switch ($response){ case 'ok': echo 'ok'; break; default: echo $response; break; }
    }
    public function AjaxChangeStatus(){
        $data = [ 'id' => $this->id, 'set' => $this->value ];
        $response = ControllerGeneral::ctrUpdateFieldUnique($this->table,'status',$data);
        if( $this->table == '`references`' && $this->value == 0 ){
            ControllerGeneral::ctrDeleteRow('inventories','idr',$this->id, '');
        }
        echo $response;
    }
    public function AjaxStatusZero(){
        $data = [ 'id' => $this->id, 'set' => $this->value ];
        $response = ControllerGeneral::ctrUpdateFieldUnique($this->table,$this->set,$data);
        echo $response;
    }
    public function AjaxLoadActivate(){

        $load = ControllerGeneral::ctrRecord('single','loads','where id='.$this->id);
        $inv = json_decode( $load['loads'], true );
        foreach ( $inv as $row ){
            $val = ControllerGeneral::ctrRecord('single','inventories', 'where site='.$load['site'].' and idr='.$row['idr'] );
            switch ( $val ){
                case null:
                    $data = [
                        'site' => $load['site'],
                        'idr' => $row['idr'],
                        'reference' => $row['ref'],
                        'product' => $row['product'],
                        'loads' => $row['cant'],
                        'sales' => 0,
                        'returns' => 0,
                        'changes' => 0,
                        'transfers' => 0,
                        'stock' => $row['cant']
                    ];
                    $inventories = ControllerGeneral::ctrInsertRow('inventories', $data);
                    break;
                default:
                    ControllerGeneral::ctrUpdateFieldUnique('inventories','loads', [ 'id' => $val['id'], 'set' => $row['cant'] + $val['loads'] ]);
                    $inventories = ControllerGeneral::ctrUpdateFieldUnique('inventories','stock', [ 'id' => $val['id'], 'set' => $row['cant'] + $val['stock'] ]);
                    break;
            }
        }

        switch ( $inventories ){
            case 'ok':
                $data = [ 'id' => $this->id, 'set' => 1 ];
                $response = ControllerGeneral::ctrUpdateFieldUnique('loads','status',$data);
                switch ( $response ){ case 'ok': echo 'ok'; break; default: echo 'activate'; break; }
                break;
            default: echo 'inventories'; break;
        }

    }
    public function AjaxResetPass() {
        $pass =  substr(str_shuffle( 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!#$%&/()=' ), 0, 10);
        $data = [ 'id' => $this->id, 'set' => password_hash( $pass, PASSWORD_DEFAULT ), ];
        $response = ControllerGeneral::ctrUpdateFieldUnique('users','password',$data);
        echo $pass;
    }
    public function ajaxSearch()
    {
        $response = [];
        $data = ControllerGeneral::ctrRecord( 'all', $this->table, 'where status=1 and ('.$this->column1.' like "%'.$this->search.'%" or '.$this->column2.' like "%'.$this->search.'%" or '.$this->column3.' like "%'.$this->search.'%" '.$this->filter.')');
        switch ( $this->table ){
            case 'tags': foreach ( $data as $row ){ $response[] = [ 'id' => $row['id'], 'text' => $row['tag'].' - '.$row['complement'] ]; }; break;
            case 'customer': foreach ( $data as $row ){ $response[] = [ 'id' => $row['id'], 'text' => $row['business_name'].' - '.$row['tradename'].' - '.$row['document'] ]; }; break;
        }
        echo json_encode( [ 'results' =>  $response  ] );
    }
    public function ajaxUnique(){
        $response = ControllerGeneral::ctrRecord('single',$this->table,'where '.$this->field.' = '.$this->id);
        echo json_encode($response);
    }

    public function ajaxUpdate(){
        $response = ControllerGeneral::ctrUpdateFieldUnique( $this->table, $this->set, [ 'id' => $this->id, 'set' => $this->value ]);
        echo $response;
    }



}

// actions
if( isset( $_POST['all'] ) ){
    $general = new AjaxGeneral();
    $general -> table = $_POST['all'];
    $general -> filter = $_POST['filter'];
    $general -> ajaxAll();
}
if( isset( $_POST['detailed'] ) ){
    $general = new AjaxGeneral();
    $general -> id = $_POST['detailed'];
    $general -> table = $_POST['position'];
    $general -> ajaxDetailed();
}
if( isset( $_POST['text'] ) ){
    $general = new AjaxGeneral();
    $general -> id = $_POST['id'];
    $general -> field = $_POST['field'];
    $general -> value = $_POST['text'];
    $general -> table = $_POST['direction'];
    $general -> AjaxUpdateText();
}
if( isset( $_POST['status'] ) ){
    $general = new AjaxGeneral();
    $general -> id = $_POST['status'];
    $general -> value = $_POST['value'];
    $general -> table = $_POST['position'];
    $general -> AjaxChangeStatus();
}
if( isset( $_POST['load_active'] ) ){
    $general = new AjaxGeneral();
    $general -> id = $_POST['load_active'];
    $general -> AjaxLoadActivate();
}
if( isset( $_POST['reset'] ) ){
    $general = new AjaxGeneral();
    $general -> id = $_POST['reset'];
    $general -> AjaxResetPass();
}
if( isset( $_GET['term'] ) ){
    $cus = new AjaxGeneral();
    $cus -> table = $_GET['direction'];
    $cus -> column1 = $_GET['column1'];
    $cus -> column2 = $_GET['column2'];
    $cus -> column3 = $_GET['column3'];
    $cus -> search = $_GET['term'] ;
    $cus -> filter = $_GET['filter'] ;
    $cus -> ajaxSearch();
}
if( isset( $_POST['delete'] ) ){
    $general = new AjaxGeneral();
    $general -> id = $_POST['delete'];
    $general -> value = $_POST['value'];
    $general -> table = $_POST['position'];
    $general -> set = $_POST['set'];
    $general -> AjaxStatusZero();
}
if( isset( $_POST['unique'] ) ){
    $general = new AjaxGeneral();
    $general -> id = $_POST['unique'];
    $general -> field = $_POST['field'];
    $general -> table = $_POST['position'];
    $general -> ajaxUnique();
}

if( isset( $_POST['update'] ) ){
    $general = new AjaxGeneral();
    $general -> id = $_POST['update'];
    $general -> set = $_POST['set'];
    $general -> table = $_POST['position'];
    $general -> value = $_POST['value'];
    $general -> ajaxUpdate();
}


