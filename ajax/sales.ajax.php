<?php
require_once '../controllers/general.controller.php';
require_once '../models/general.models.php';

class ajaxSales{

    public $id;
    public $table;
    public $filter;
    public $value;

    public function ajaxData()
    {
        $cust = ControllerGeneral::ctrRecord( 'single', $this->table, 'where id = "'.$this->id.'" ');
        $cust['segment'] == 1 ? $tbl = "sale" : $tbl = "prospectus" ;
        $sal = ControllerGeneral::ctrRecord('all',$tbl,'where customer_id='.$cust['id'].' order by id desc limit 3' );

        $active = ControllerGeneral::ctrRecord('single',$tbl,'where customer_id='.$cust['id'].' order by id desc limit 1' );
        $act = json_decode( $active['products'], true );
        $list = [];
        if( $active != '' ){
            foreach ( $act as $row ){
                $ref = ControllerGeneral::ctrRecord('single','`references`','where id='.$row['idr']);
                $inv = ControllerGeneral::ctrRecord( 'single', 'inventories', 'where idr='.$row['idr'].' '.$this->filter);
                $list[] = [
                    'idr' => $row['idr'],
                    'reference' => $row['reference'],
                    'product' => $row['product'],
                    'stock' => $inv['stock'],
                    'price' => $ref['price'.$cust['pri']],
                    'tax' => $ref['tax'],
                    'sold' => $row['cant'],
                ];
            }
        }


        $inv = ControllerGeneral::ctrRecord( 'all', 'inventories', 'where stock != 0 '.$this->filter);
        $prod = [];
        foreach ( $inv as $row ){
            $ref = ControllerGeneral::ctrRecord('single','`references`','where id='.$row['idr']);
            $prod[] = [
                'idr' => $row['idr'],
                'reference' => $row['reference'],
                'product' => $row['product'],
                'stock' => $row['stock'],
                'price' => $ref['price'.$cust['pri']],
                'tax' => $ref['tax'],
                'dto' => 0
            ];
        }

        $data = [ 'cust' => $cust, 'prod' => $prod, 'sold' => $sal, 'list' => $list ];
        echo json_encode( $data );
    }


}


if( isset( $_POST['single'] ) ){
    $sales = new ajaxSales();
    $sales -> id = $_POST['single'];
    $sales -> table = $_POST['name'];
    $sales -> filter = $_POST['product'];
    $sales -> ajaxData();
}
