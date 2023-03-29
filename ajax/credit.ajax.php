<?php
require_once '../controllers/general.controller.php';
require_once '../models/general.models.php';

class ajaxCredit{

    public $id;
    public $table;
    public $tag;
    public $filter;

    public function ajaxSearch()
    {
        $query = 'select * from ( select customer_id from sale where status_sale = 2 union select customer_id from prospectus where status_sale = 2 ) d inner join customer c on c.id = d.customer_id where '.$this->column1.' like "%'.$this->search.'%" or '.$this->column2.' like "%'.$this->search.'%" or '.$this->column3.' like "%'.$this->search.'%" '.$this->filter;
        $data = ControllerGeneral::ctrExecuteQuery( $query);
        $response = [];
        foreach ( $data as $row ){ $response[] = [ 'id' => $row['id'], 'text' => $row['business_name'].' - '.$row['tradename'].' - '.$row['document'] ]; };
        echo json_encode( [ 'results' =>  $response  ] );
    }
    public function ajaxFilterData()
    {
        $response = ControllerGeneral::ctrRecord( 'all', $this->table, 'where status_shopping = 1 and '.$this->tag.' =  "'.$this->filter.'" ');
        echo json_encode( $response );
    }
    public function ajaxSingle()
    {
        $response = ControllerGeneral::ctrRecord( 'single', $this->table, 'where id = "'.$this->id.'" ');
        echo json_encode( $response );
    }
    public function ajaxAllFil()
    {
        $response = ControllerGeneral::ctrRecord( 'all', $this->table, 'where '.$this->tag.' = "'.$this->id.'" ');
        echo json_encode( $response );
    }
    public function ajaxDataCustomer()
    {
        $cus = ControllerGeneral::ctrRecord('single','customer','where id='.$this->id);
        $query = 'select *,\'sale\' as \'typ\' from sale where status_sale = 2 and customer_id = '.$this->id.' union all select * ,\'prospectus\' as \'typ\' from prospectus where status_sale = 2 and customer_id ='.$this->id;
        $credits = ControllerGeneral::ctrExecuteQuery( $query );
        $data = [ 'cust' => $cus, 'cred' => $credits] ;
        echo json_encode( $data );
    }

}

if( isset( $_POST['filter'] ) ){
    $sep = new ajaxCredit();
    $sep -> filter = $_POST['filter'];
    $sep -> tag = $_POST['tag'];
    $sep -> table = $_POST['direction'];
    $sep -> ajaxFilterData();
}
if( isset( $_POST['single'] ) ){
    $sep = new ajaxCredit();
    $sep -> id = $_POST['single'];
    $sep -> table = $_POST['name'];
    $sep -> ajaxSingle();
}
if( isset( $_POST['all_fil'] ) ){
    $sep = new ajaxCredit();
    $sep -> id = $_POST['all_fil'];
    $sep -> table = $_POST['name'];
    $sep -> tag = $_POST['fil'];
    $sep -> ajaxAllFil();
}
if( isset( $_GET['term'] ) ){
    $cus = new ajaxCredit();
    $cus -> table = $_GET['direction'];
    $cus -> column1 = $_GET['column1'];
    $cus -> column2 = $_GET['column2'];
    $cus -> column3 = $_GET['column3'];
    $cus -> search = $_GET['term'] ;
    $cus -> filter = $_GET['filter'] ;
    $cus -> ajaxSearch();
}
if( isset( $_POST['customer'] ) ){
    $sep = new ajaxCredit();
    $sep -> id = $_POST['customer'];
    $sep -> ajaxDataCustomer();
}