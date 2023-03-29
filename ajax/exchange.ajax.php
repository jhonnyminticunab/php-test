<?php
require_once '../controllers/general.controller.php';
require_once '../models/general.models.php';

class ajaxExchange{

    public $id;
    public $table;
    public $tag;
    public $filter;

    public function ajaxSearch()
    {
        $data = ControllerGeneral::ctrRecord( 'all', 'customer', 'where '.$this->column1.' like "%'.$this->search.'%" or '.$this->column2.' like "%'.$this->search.'%" or '.$this->column3.' like "%'.$this->search.'%" '.$this->filter);
        $response = [];
        foreach ( $data as $row ){ $response[] = [ 'id' => $row['id'], 'text' => $row['business_name'].' - '.$row['tradename'].' - '.$row['document'] ]; };
        echo json_encode( [ 'results' =>  $response  ] );
    }
    public function ajaxDataCustomer()
    {
        $cus = ControllerGeneral::ctrRecord('single','customer','where id='.$this->id);
        $query = 'select *,\'sale\' as \'typ\' from sale where status_sale != 10 and customer_id = '.$this->id.' union all select * ,\'prospectus\' as \'typ\' from prospectus where status_sale = 2 and customer_id ='.$this->id;
        $credits = ControllerGeneral::ctrExecuteQuery( $query );

        $inv = ControllerGeneral::ctrRecord('all','inventories','where stock>0 and site='.$this->filter);
        $invetories = []; foreach ( $inv as $row ){
            $ref = ControllerGeneral::ctrRecord('single','`references`','where id='.$row['idr']);
            $invetories[] = [
                'idr' => $row['idr'],
                'reference' => $row['reference'],
                'product' => $row['product'],
                'price' => $ref['price'.$cus['pri']],
                'tax' => $ref['tax'],
                'stock' => $row['stock'],
            ];
        }

        $ref = ControllerGeneral::ctrRecord( 'all', '`references`', 'where status != 0');
        $list = []; foreach ( $ref as $row ){
            $list[] = [
                'idr' => $row['id'],
                'reference' => $row['ref'],
                'product' => $row['product'],
                'price' => $row['price'.$cus['pri']],
                'tax' => $row['tax'],
                'stock' => 0,
            ];
        }

        $data = [ 'cust' => $cus, 'cred' => $credits, 'inv' => $invetories, 'ref' => $list ] ;
        echo json_encode( $data );
    }
    public function ajaxSingle()
    {
        $sol = ControllerGeneral::ctrRecord( 'single', $this->table, 'where id = "'.$this->id.'" ');
        $cus = ControllerGeneral::ctrRecord('single','customer','where id='.$sol['customer_id']);

        $inv = ControllerGeneral::ctrRecord('all','inventories','where stock>0 and site='.$this->filter);
        $invetories = []; foreach ( $inv as $row ){
            $ref = ControllerGeneral::ctrRecord('single','`references`','where id='.$row['idr']);
            $invetories[] = [
                'idr' => $row['idr'],
                'reference' => $row['reference'],
                'product' => $row['product'],
                'price' => $ref['price'.$cus['pri']],
                'tax' => $ref['tax'],
                'stock' => $row['stock'],
            ];
        }

        $ref = ControllerGeneral::ctrRecord( 'all', '`references`', 'where status != 0');
        $list = []; foreach ( $ref as $row ){
            $list[] = [
                'idr' => $row['id'],
                'reference' => $row['ref'],
                'product' => $row['product'],
                'price' => $row['price'.$cus['pri']],
                'tax' => $row['tax'],
                'stock' => 0,
            ];
        }

        $data = [ 'inv' => $invetories, 'ref' => $list, 'sol' => $sol ];
        echo json_encode( $data );
    }

}

if( isset( $_GET['term'] ) ){
    $cus = new ajaxExchange();
    $cus -> table = $_GET['direction'];
    $cus -> column1 = $_GET['column1'];
    $cus -> column2 = $_GET['column2'];
    $cus -> column3 = $_GET['column3'];
    $cus -> search = $_GET['term'] ;
    $cus -> filter = $_GET['filter'] ;
    $cus -> ajaxSearch();
}
if( isset( $_POST['customer'] ) ){
    $sep = new ajaxExchange();
    $sep -> id = $_POST['customer'];
    $sep -> filter = $_POST['site'];
    $sep -> ajaxDataCustomer();
}
if( isset( $_POST['single'] ) ){
    $sep = new ajaxExchange();
    $sep -> id = $_POST['single'];
    $sep -> table = $_POST['name'];
    $sep -> filter = $_POST['site'];
    $sep -> ajaxSingle();
}