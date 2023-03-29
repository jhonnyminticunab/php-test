<?php
require_once '../controllers/general.controller.php';
require_once '../models/general.models.php';

class ajaxShopping{

    public $id;
    public $table;

    public function ajaxSearchProvider()
    {
        $data = ControllerGeneral::ctrRecord( 'all', $this->table, 'where company like "%'.$this->search.'%" or vendor like "%'.$this->search.'%" or nit like "%'.$this->search.'%" order by id desc');
        $response = [];
        foreach ( $data as $row ){ $response[] = [ 'id' => $row['id'], 'text' => $row['nit'].' / '.$row['company'].' / '.$row['vendor'], ]; }
        echo json_encode( [ 'results' =>  $response  ] );
    }
    public function ajaxAllProducts()
    {
        $provider = ControllerGeneral::ctrRecord('single','providers','where id = "'.$this->id.'"');
        $data = ControllerGeneral::ctrRecord( 'all', '`references`', 'where provider = "'.$provider['company'].'" ');
        $response = [];
        foreach ( $data as $row ){
            $btn = '<button class="btn btn-outline-success btn-xs add_product_shopping" idr="'.$row['id'].'" ref="'.$row['ref'].'" pro="'.$row['name'].'" cos="'.$row['cost'].'" sto="'.$row['sto'].'" > <i class="fas fa-check-square"></i> </button>';
            $response[] = [ 'data' => $row, 'btn' => $btn ];
        }

        echo json_encode( $response );
    }
    public function ajaxData()
    {
        $response = ControllerGeneral::ctrRecord( 'single', $this->table, 'where id = "'.$this->id.'" ');
        echo json_encode( $response );
    }


}

if( isset( $_POST['products'] ) ){
    $sales = new ajaxShopping();
    $sales -> id = $_POST['products'];
    $sales -> ajaxAllProducts();
}
if( isset( $_POST['single'] ) ){
    $sales = new ajaxShopping();
    $sales -> id = $_POST['single'];
    $sales -> table = $_POST['name'];
    $sales -> ajaxData();
}
if( isset( $_GET['term'] ) ){
    $cus = new ajaxShopping();
    $cus -> table = 'providers';
    $cus -> search = $_GET['term'] ;
    $cus -> ajaxSearchProvider();
}