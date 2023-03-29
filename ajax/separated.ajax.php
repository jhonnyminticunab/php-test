<?php
require_once '../controllers/general.controller.php';
require_once '../models/general.models.php';

class ajaxSeparated{

    public $id;
    public $table;
    public $tag;
    public $filter;

    public function ajaxSearchCustomer()
    {
        $data = ControllerGeneral::ctrExecuteQuery('
        select sale.customer_id "id", sale.customer, (select document from customer where sale.customer_id = customer.id) "document"
        from sale
        where status_sale = 1 and
        (sale.customer like "%'.$this->search.'%" or (select document from customer where sale.customer_id = customer.id) like "%'.$this->search.'%")
        group by sale.customer_id 
        ');
        $response = [];
        foreach ( $data as $row ){ $response[] = [ 'id' => $row['id'], 'text' => $row['document'].' / '.$row['customer'], ]; }
        echo json_encode( [ 'results' =>  $response  ] );
    }
    public function ajaxFilterData()
    {
        $response = ControllerGeneral::ctrRecord( 'all', $this->table, 'where status_sale = 1 and '.$this->tag.' =  "'.$this->filter.'" ');
        echo json_encode( $response );
    }
    public function ajaxData()
    {
        $data = ControllerGeneral::ctrRecord( 'single', $this->table, 'where id = "'.$this->id.'" ');
        $references = ControllerGeneral::ctrRecord('all','`references`','where status != 0');

        $ref = [];
        $products = json_decode( $data['products'] , true );
        foreach ( $products as $key => $row ){
            $sto = ControllerGeneral::ctrRecord('single','`references`','where id = "'.$row['idr'].'"'); $stq =  $sto['sto'] /*- $row['can']*/;
            $ref[] = [ 'idr' => $row['idr'], 'ref' => $row['ref'], 'pro' => $row['pro'], 'pri' => $row['pri'], 'can' => $row['can'], 'sub' => $row['sub'], 'sto' => $stq, 'pvi' => $sto['provider'] ];
        }

        $available = [];
        for ($i = 0; $i < count($references); $i++) {
            $equal = false;
            for ($j = 0; $j < count($ref) & !$equal; $j++) { if ($references[$i]['id'] == $ref[$j]['idr']) $equal = true; }
            if (!$equal) array_push($available,$references[$i]);
        }

        $response =  array_merge( [ 'data' => $data, 'ref' => $available , 'pro' => $ref]);

        echo json_encode( $response );
    }
    public function ajaxAllFil()
    {
        $response = ControllerGeneral::ctrRecord( 'all', $this->table, 'where '.$this->tag.' = "'.$this->id.'" ');
        echo json_encode( $response );
    }

}

if( isset( $_POST['filter'] ) ){
    $sep = new ajaxSeparated();
    $sep -> filter = $_POST['filter'];
    $sep -> tag = $_POST['tag'];
    $sep -> table = $_POST['direction'];
    $sep -> ajaxFilterData();
}
if( isset( $_POST['single'] ) ){
    $sep = new ajaxSeparated();
    $sep -> id = $_POST['single'];
    $sep -> table = $_POST['name'];
    $sep -> ajaxData();
}
if( isset( $_POST['all_fil'] ) ){
    $sep = new ajaxSeparated();
    $sep -> id = $_POST['all_fil'];
    $sep -> table = $_POST['name'];
    $sep -> tag = $_POST['fil'];
    $sep -> ajaxAllFil();
}
if( isset( $_GET['term'] ) ){
    $sep = new ajaxSeparated();
    $sep -> search = $_GET['term'] ;
    $sep -> ajaxSearchCustomer();
}