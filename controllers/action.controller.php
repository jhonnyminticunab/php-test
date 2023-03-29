<?php

class ControllerAction{

    static public function cus_quote(){

        if( isset( $_POST['idq'] ) ){

            $location = ControllerGeneral::ctrRecord('single','tags','where id='.$_POST['city']);

            switch ( $_POST['idq'] ){
                case 0:
                    $data = [
                        'person' => 0,
                        'type_id' => 0,
                        'document' => 0,
                        'code_document' => 0,
                        'regime' => 0,
                        'business_name' => $_POST['business_name'],
                        'business_surname' => null,
                        'tradename' => '',
                        'tax_responsibilities' => null,
                        'withholding' => 0,
                        'postal_code' => 0,
                        'city' => $location['tag'],
                        'address' => $_POST['address'],
                        'departamen_code' => $location['other'],
                        'departament_name' => $location['complement'],
                        'municipal_code' => $location['cod'],
                        'person_charge' => $_POST['person_charge'],
                        'person_phone' => $_POST['person_phone'],
                        'mail' => $_POST['mail'],
                        'pri' => 1,
                        'segment' => 2
                    ];
                    $response = ControllerGeneral::ctrInsertRow('customer',$data);
                    break;
                default:
                    $data = [
                        'id' => $_POST['idq'],
                        'person' => 0,
                        'type_id' => 0,
                        'document' => 0,
                        'code_document' => 0,
                        'regime' => 0,
                        'business_name' => $_POST['business_name'],
                        'business_surname' => null,
                        'tradename' => '',
                        'tax_responsibilities' => null,
                        'withholding' => 0,
                        'postal_code' => 0,
                        'city' => $location['tag'],
                        'address' => $_POST['address'],
                        'departamen_code' => $location['other'],
                        'departament_name' => $location['complement'],
                        'municipal_code' => $location['cod'],
                        'person_charge' => $_POST['person_charge'],
                        'person_phone' => $_POST['person_phone'],
                        'mail' => $_POST['mail'],
                        'pri' => 1,
                        'segment' => 2
                    ];
                    $response = ControllerGeneral::ctrUpdateRow('customer',$data);
            }
            switch ( $response ){
                case 'ok': success('¡Prospecto guardado con éxito!'); break;
                case 'error': error('¡Intente de nuevo o coumíquese con el administrador!'); break;
                case 'repeated': repeated(''); break;
            }

        }

    }
    static public function cus_invoice(){

        if( isset( $_POST['idi'] ) ){

            if( !isset( $_POST['type_id'] ) ){ $type = 31; } else { $type = $_POST['type_id']; }
            if( !isset( $_POST['regime'] ) ){ $regime = 48; } else { $regime = $_POST['regime']; }
            if( !isset( $_POST['withholding'] ) ){ $withholding = 0; } else { $withholding = $_POST['withholding']; }

            $location = ControllerGeneral::ctrRecord('single','tags','where id='.$_POST['city']);
            $surname = null; if( isset( $_POST['business_surname'] ) ){ $surname = $_POST['business_surname']; }

            switch ( $_POST['idi'] ){
                case 0: $data = [
                        'person' =>   $_POST['person'],
                        'type_id' =>   $type,
                        'document' =>   str_replace('.','',$_POST['document']),
                        'code_document' =>   $_POST['code_document'],
                        'regime' =>   $regime,
                        'business_name' => $_POST['business_name'],
                        'business_surname' => $surname,
                        'tradename' => $_POST['tradename'],
                        'tax_responsibilities' => $_POST['tax_responsibilities'],
                        'withholding' => $withholding,
                        'postal_code' => str_replace('_','',$_POST['postal_code']),
                        'city' => $location['tag'],
                        'address' => $_POST['address'],
                        'departamen_code' => $location['other'],
                        'departament_name' => $location['complement'],
                        'municipal_code' => $location['cod'],
                        'person_charge' => $_POST['person_charge'],
                        'person_phone' => str_replace('_','',$_POST['person_phone']),
                        'mail' => $_POST['mail'],
                        'pri' => 1,
                        'segment' => $_POST['segment']
                    ];
                $response = ControllerGeneral::ctrInsertRow('customer',$data);
                break;
                default:
                    $data = [
                        'id' => $_POST['idi'],
                        'person' =>   $_POST['person'],
                        'type_id' =>   $type,
                        'document' =>   str_replace('.','',$_POST['document']),
                        'code_document' =>   $_POST['code_document'],
                        'regime' => $regime,
                        'business_name' => $_POST['business_name'],
                        'business_surname' => $surname,
                        'tradename' => $_POST['tradename'],
                        'tax_responsibilities' => $_POST['tax_responsibilities'],
                        'withholding' => $_POST['withholding'],
                        'postal_code' => str_replace('_','',$_POST['postal_code']),
                        'city' => $location['tag'],
                        'address' => $_POST['address'],
                        'departamen_code' => $location['other'],
                        'departament_name' => $location['complement'],
                        'municipal_code' => $location['cod'],
                        'person_charge' => $_POST['person_charge'],
                        'person_phone' => str_replace('_','',$_POST['person_phone']),
                        'mail' => $_POST['mail'],
                        'pri' => 1,
                        'segment' => $_POST['segment']
                    ];
                    $response = ControllerGeneral::ctrUpdateRow('customer',$data);
            }
            switch ( $response ){
                case 'ok': success('¡Cliente guardado con éxito!'); break;
                case 'error': error('¡Intente de nuevo o coumíquese con el administrador!'); break;
                case 'repeated': repeated(''); break;
            }

        }

    }

    static public function provider(){

        if( isset( $_POST['company'] ) ){

            if( $_POST['id_provider'] != 0 ){ $test = [ 'id' => $_POST['id_provider'] ] ; }

            $data = [
                'company' => $_POST['company'],
                'vendor' => $_POST['vendor'],
                'nit' => str_replace('.','', $_POST['nit']),
                'mail' => $_POST['mail'],
                'phone' => str_replace('-','', $_POST['phone']),
                'other' => str_replace('-','', $_POST['other']),
                'address' => $_POST['address']
            ];
            switch ( $_POST['id_provider'] ){
                case 0: $response = ControllerGeneral::ctrInsertRow('providers',$data); break;
                default: $data = array_merge($data,$test); $response = ControllerGeneral::ctrUpdateRow('providers',$data); break;
            }

            switch ( $response ){
                case 'ok': success(); break;
                case 'error': error(); break;
                case 'repeated': repeated(); break;
            }

        }

    }

    static public function sale(){

        if( isset( $_POST['customer_id'] ) ){

            $sub = str_replace('.','',$_POST['sub']); $dto = str_replace('.','',$_POST['dto']); $tot = str_replace('.','',$_POST['total']);
            $cas = str_replace('.','',$_POST['cash']); $tra = str_replace('.','',$_POST['tran']); $oth = str_replace('.','',$_POST['other']);

            if( $cas+$tra+$oth == $tot ){ $sta = 1; $bal = 0; }
            else{ $sta = 2; $bal = $tot-($cas+$tra+$oth); }

            $customer = ControllerGeneral::ctrRecord('single','customer','where id='.$_POST['customer_id']);
            switch ( $customer['segment'] ){ case 1: $table = 'sale'; $invoice = 'send'; break; case 2: $table = 'prospectus';  $invoice = 'none'; break; }

            $last_record = ControllerGeneral::ctrRecord('single', $table,'where status_sale != -1 order by created desc limit 1');
            $last_record == false ? $num = 1 : $num = $last_record['sales']+1 ;

            $products = json_decode( $_POST["sold"], true );
            $tax = 0;
            if( $table != "prospectus" ){
                foreach ( $products as $row ){
                    ( $row['tax'] != 0 ) ?  $tax += ( $row['price'] - ( $row['price'] / (1+$row['tax'] ) ) ) * $row['cant'] : '';
                }
            }

            echo round($tax,2);

            $data = [
                'sales' => $num,
                'customer_id' => $_POST['customer_id'],
                'customer' => $customer['business_name'],
                'products' => $_POST['sold'],
                'subtotal' => $sub,
                'dto' => $_POST['dto'],
                'total' => $tot,
                'cash' => $cas,
                'card' => $tra,
                'other' => $oth,
                'balance' => $bal,
                'payment' => 0,
                'user_id' => $_POST['user_id'],
                'user_name' => $_POST['user_name'],
                'site' => $_POST['site'],
                'observation' => null,
                'status_sale' => $sta,
                'tax' => strval(round($tax,2)),
                'transaccionID' => 0,
                'response' => null,
                'cufe' => null,
                'status_fe' => null,
                'credit_note' => null,
                'transactionID_CN' => null,
                'response_cn' => null,
                'cude' => null,
                'status_cn' => null,
                'motive_cn' => null,
                'created_cn' => null,
            ];
            echo $sold = ControllerGeneral::ctrInsertRow( $table, $data );

            switch ( $sold ){
                case 'ok':
                    foreach ( $products as $row ){
                        $reference = ControllerGeneral::ctrRecord('single','inventories','where site='.$_POST['site'].' and idr='.$row['idr']);
                        $update = [
                            'id' => $reference['id'],
                            'site' => $reference['site'],
                            'idr' => $reference['idr'],
                            'reference' => $reference['reference'],
                            'product' => $reference['product'],
                            'loads' => $reference['loads'],
                            'sales' => $reference['sales']+$row['cant'],
                            'returns' => $reference['returns'],
                            'changes' => $reference['changes'],
                            'transfers' => $reference['transfers'],
                            'stock' => $reference['stock']-$row['cant'],
                        ];
                        $stock = ControllerGeneral::ctrUpdateRow('inventories',$update);
                    }; break;
                default: error('No se creó la venta, intente de nuevo o comuníquese con el administrador'); break;
            }

            switch ( $stock ){
                case 'ok': print_doc( '/print/'.$num.'/'.$_POST['customer_id'].'/'.$invoice  ); break;
                case 'error': error('No se actualizaron los inventarios, verifique con el administrador'); break;
            }

        }

    }
    static public function save_payment(){

        if( isset( $_POST['tbl'] ) ){

            $customer = ControllerGeneral::ctrRecord('single','customer','where id='.$_POST['customer_id'] );
            $sold = ControllerGeneral::ctrRecord('single',$_POST['tbl'],'where id='.$_POST['idr'] );
            $ini = $sold['cash'] + $sold['card'] +$sold['other'];

            $last_record = ControllerGeneral::ctrRecord('single','payment','order by id desc limit 1');
            $last_record == false ? $num = 100 : $num = $last_record['payment']+1 ;

            $cash = 0; if( $_POST['cash'] != "" ){ $cash = str_replace('.','', $_POST['cash'] ); }
            $card = 0; if( $_POST['card'] != "" ){ $card = str_replace('.','', $_POST['card'] ); }
            $other = 0; if( $_POST['other'] != "" ){ $other = str_replace('.','', $_POST['other'] ); }

            $data =[
                'payment' => $num,
                'sales' => $sold['sales'],
                'type' => $_POST['tbl'],
                'customer' => $customer['business_name'],
                'customer_id' => $_POST['customer_id'],
                'cash' => $cash,
                'card' => $card,
                'other' => $other,
                'user_name' => $_POST['user_name'],
                'user_id' => $_POST['user_id'],
                'site' => $_POST['site'],
            ];
            $payment = ControllerGeneral::ctrInsertRow('payment',$data);

            switch ( $payment ){
                case 'ok':
                    $pay = ControllerGeneral::ctrRecord('all','payment','where sales='.$sold['sales'].' and type="'.$_POST['tbl'].'"' );
                    $value = 0; if( $pay != '' ){
                        foreach ( $pay as $row ){ $value += $row['cash'] + $row['card'] + $row['other']; }
                    }

                    $data = [ 'id' => $sold['id'], 'set' => $value ];
                    ControllerGeneral::ctrUpdateFieldUnique( $_POST['tbl'],'payment',$data);
                    if( ($sold['total'] - $ini - $value) == 0 ){
                        $data = [ 'id' => $sold['id'], 'set' => 1 ]; ControllerGeneral::ctrUpdateFieldUnique( $_POST['tbl'],'status_sale',$data);
                    }
                    $data = [ 'id' => $sold['id'], 'set' => $sold['total'] - $ini - $value ];
                    $update = ControllerGeneral::ctrUpdateFieldUnique( $_POST['tbl'],'balance',$data);
            }

            switch ( $update ){
                case 'ok': print_doc( '/print/'.$num.'/'.$_POST['customer_id']  ); break;
                case 'error': error('No se actualizaron los inventarios, verifique con el administrador'); break;
            }

        }

    }

    static public function exchange()
    {
        if( isset( $_POST['segment'] ) ){

            $last_record = ControllerGeneral::ctrRecord('single','exchanges','order by id desc limit 1');
            $last_record == false ? $num = 100 : $num = $last_record['exchange']+1 ;
            $cus = ControllerGeneral::ctrRecord('single','customer','where id='.$_POST['customer_id']);

            $cash = 0; if( $_POST['cash'] != "" ){ $cash = str_replace('.','', $_POST['cash'] ); }
            $card = 0; if( $_POST['card'] != "" ){ $card = str_replace('.','', $_POST['card'] ); }
            $other = 0; if( $_POST['other'] != "" ){ $other = str_replace('.','', $_POST['other'] ); }

            $data = [
                'exchange' => $num,
                'in_products' => $_POST['in_products'],
                'in_val' => str_replace('.','',$_POST['in_val']),
                'out_products' => $_POST['out_products'],
                'out_val' => str_replace('.','',$_POST['out_val']),
                'customer' => $cus['business_name'],
                'customer_id' => $_POST['customer_id'],
                'cash' => $cash,
                'card' => $card,
                'other' => $other,
                'user_name' => $_POST['user_name'],
                'user_id' => $_POST['user_id'],
                'site' => $_POST['site'],
            ];
            $new = ControllerGeneral::ctrInsertRow('exchanges',$data);

            switch ( $new ){
                case 'ok': $products = json_decode( $_POST["in_products"], true );
                    foreach ( $products as $row ){
                        $reference = ControllerGeneral::ctrRecord('single','inventories','where site='.$_POST['site'].' and idr='.$row['idr']);
                        $update = [
                            'id' => $reference['id'],
                            'site' => $reference['site'],
                            'idr' => $reference['idr'],
                            'reference' => $reference['reference'],
                            'product' => $reference['product'],
                            'loads' => $reference['loads'],
                            'sales' => $reference['sales'],
                            'returns' => $reference['returns']+$row['cant'],
                            'changes' => $reference['changes'],
                            'transfers' => $reference['transfers'],
                            'stock' => $reference['stock']+$row['cant'],
                        ];
                        $stock = ControllerGeneral::ctrUpdateRow('inventories',$update);
                    }; $products = json_decode( $_POST["out_products"], true );
                    foreach ( $products as $row ){
                        $reference = ControllerGeneral::ctrRecord('single','inventories','where site='.$_POST['site'].' and idr='.$row['idr']);
                        $update = [
                            'id' => $reference['id'],
                            'site' => $reference['site'],
                            'idr' => $reference['idr'],
                            'reference' => $reference['reference'],
                            'product' => $reference['product'],
                            'loads' => $reference['loads'],
                            'sales' => $reference['sales'],
                            'returns' => $reference['returns'],
                            'changes' => $reference['changes']+$row['cant'],
                            'transfers' => $reference['transfers'],
                            'stock' => $reference['stock']-$row['cant'],
                        ];
                        $stock = ControllerGeneral::ctrUpdateRow('inventories',$update);
                    };break;
                default: error('No se creó la venta, intente de nuevo o comuníquese con el administrador'); break;
            }
            switch ( $stock ){
                case 'ok': print_doc( '/print/'.$num.'/'.$_POST['customer_id']  ); break;
                case 'error': error('No se actualizaron los inventarios, verifique con el administrador'); break;
            }

        }
    }

    static public function new_product(){

        if( isset( $_POST['ref'] ) ){

            $ref = ControllerGeneral::ctrRecord('single','`references`','where ref = "'.$_POST['ref'].'"');

            if( !empty($ref) ){
                repeated('¡La referencia ya existe, verifique y cambie la que está intentando crear o modifique la existente!');
            }else{
                $data = [
                    'ref' => $_POST['ref'],
                    'cod' => null,
                    'product' => $_POST['product'],
                    'size' => null,
                    'price1' => 0,
                    'price2' => 0,
                    'price3' => 0,
                    'tax' => 0,
                    'cost' => 0,
                    'stock' => 0
                ];
                $response = ControllerGeneral::ctrInsertRow('`references`',$data);
            }

            switch ( $response ){
                case 'ok': success('¡Producto creado con éxito!'); break;
                case 'error': error('¡Intente de nuevo o comuníquese con el administrador!'); break;
                case 'repeated': repeated('¡La referencia ya existe, verifique y cambie la que está intentando crear o modifique la existente!'); break;
            }

        }

    }
    static public function update_product(){

        if( isset( $_POST['ref'] ) ){

            $ref = ControllerGeneral::ctrRecord('single', '`references`', 'where id = "'.$_POST['id'].'"');
            $data = [
                'id' => $_POST['id'],
                'ref' => $_POST['ref'],
                'cod' => $_POST['cod'],
                'product' => $_POST['product'],
                'size' => $_POST['size'],
                'price1' => str_replace('.','',$_POST['price1']),
                'price2' => str_replace('.','',$_POST['price2']),
                'price3' => str_replace('.','',$_POST['price3']),
                'tax' => $_POST['tax']/100,
                'cost' => $ref['cost'],
                'stock' => $ref['stock']
            ];
            $response = ControllerGeneral::ctrUpdateRow('`references`',$data);

            switch ( $response ){
                case 'ok': success('¡Producto actualizado con éxito!'); break;
                case 'error': error('¡Intente de nuevo o comuníquese con el administrador!'); break;
                case 'repeated': repeated('¡La referencia ya existe, verifique y cambie la que está intentando crear o modifique la existente!'); break;
            }

        }

    }

    static public function shopping(){
        if( isset( $_POST['load'] ) ){
            $data = [
                'site' => $_POST['site'],
                'user_id' => $_POST['user_id'],
                'user_name' => $_POST['user_name'],
                'loads' => $_POST['load'],
                'inventory' => null,
            ];
            $response = ControllerGeneral::ctrInsertRow('loads',$data);
            switch ( $response ){
                case 'ok': success('¡Cargue realizado con éxito, para vender recuerde activarlo!'); break;
                case 'error': error('Intente de nuevo o comuníquese con el administrador'); break;
            }
        }
    }
    static public function shopping_payment(){

        if( isset( $_POST['credit_id_pay'] ) ){

            $shopping = ControllerGeneral::ctrRecord('single','shopping','where id = "'.$_POST['credit_id_pay'].'"');

            $cash = 0; if( $_POST['cash_credit_pay'] != "" ){ $cash = str_replace('.','', $_POST['cash_credit_pay'] ); }
            $card = 0; if( $_POST['card_credit_pay'] != "" ){ $card = str_replace('.','', $_POST['card_credit_pay'] ); }
            $other = 0; if( $_POST['other_credit_pay'] != "" ){ $other = str_replace('.','', $_POST['other_credit_pay'] ); }

            $payment = ControllerGeneral::ctrRecord('single','payment_shopping','order by id desc limit 1');
            $pay = $payment['payment'] + 1;

            $data = [
                'payment' => $pay,
                'shopping' => $shopping['shopping'],
                'provider' => $shopping['provider'],
                'provider_id' => $shopping['provider_id'],
                'cash' => $cash,
                'card' => $card,
                'other' => $other,
                'vendor' => $shopping['vendor'],
                'vendor_id' => $shopping['vendor_id'],
            ];
            $save = ControllerGeneral::ctrInsertRow('payment_shopping',$data);

            switch ( $save ){
                case 'ok':

                    $sta = 1; if( $shopping['balance'] == $cash + $card + $other ){ $sta = 0; }

                    $data_shopping = [
                        'id' => $shopping['id'],
                        'shopping' => $shopping['shopping'],
                        'provider_id' => $shopping['provider_id'],
                        'provider' => $shopping['provider'],
                        'invoice' => $shopping['invoice'],
                        'products' => $shopping['products'],
                        'subtotal' => $shopping['subtotal'],
                        'dto' => $shopping['dto'],
                        'total' => $shopping['total'],
                        'cash' => $shopping['cash'],
                        'card' => $shopping['card'],
                        'other' => $shopping['other'],
                        'balance' => $shopping['balance'] - $cash - $card - $other,
                        'payment' => $shopping['payment'] + $cash + $card + $other,
                        'vendor_id' => $shopping['vendor_id'],
                        'vendor' => $shopping['vendor'],
                        'observation' => $shopping['observation'],
                        'status_shopping' => $sta,
                    ];
                    $update = ControllerGeneral::ctrUpdateRow('shopping',$data_shopping);
                    break;

            }

            switch ( $update ){ case 'ok': success(); break; case 'error': error(); break; case 'repeated': repeated(); break; }

        }

    }
    static public function update_shopping(){

        if( isset( $_POST['credit_id'] ) ){

            $products = $_POST['credit_products_old'];

            if( !empty( $_POST['credit_products_new'] ) ){

                $products = $_POST['credit_products_new'];

                $old = json_decode( $_POST['credit_products_old'], true );
                foreach ( $old as $row ){
                    $data = ControllerGeneral::ctrRecord('single','`references`','where id = "'.$row['idr'].'"');
                    $stock = [ 'id' => $data['id'], 'set' => $data['sto'] - $row['can'] ];
                    $update_sotck = ControllerGeneral::mdlUpdateFieldUnique('`references`','sto',$stock);
                }

                switch ( $update_sotck ){
                    case 'ok':
                        $new = json_decode( $_POST['credit_products_new'], true );
                        foreach ( $new as $row ){
                            $data = ControllerGeneral::ctrRecord('single','`references`','where id = "'.$row['idr'].'"');
                            $stock = [ 'id' => $data['id'], 'set' => $data['sto'] + $row['can'] ];
                            ControllerGeneral::mdlUpdateFieldUnique('`references`','sto',$stock);
                        };
                        break;
                    default: error(); break;
                }

            }

            $shopping = ControllerGeneral::ctrRecord('single','shopping','where id = "'.$_POST['credit_id'].'"');
            $sho = [
                'id' => $shopping['id'],
                'shopping' => $shopping['shopping'],
                'provider_id' => $shopping['provider_id'],
                'provider' => $shopping['provider'],
                'products' => $products,
                'subtotal' => str_replace('.','', $_POST['sub_credit'] ),
                'dto' => str_replace('.','', $_POST['dto_credit'] ),
                'total' => str_replace('.','', $_POST['total_credit'] ),
                'cash' => $shopping['cash'],
                'card' => $shopping['card'],
                'other' => $shopping['other'],
                'balance' => str_replace('.','', $_POST['balance_credit'] ),
                'payment' => $shopping['payment'],
                'vendor_id' => $shopping['vendor_id'],
                'vendor' => $shopping['vendor'],
                'observation' => $_POST['observation_credit'],
                'status_shopping' => $shopping['status_shopping'],
            ];
            $response = ControllerGeneral::ctrUpdateRow('shopping',$sho);

            switch ( $response ){
                case 'ok': success(); break;
                case 'error': error(); break;
                case 'repeated': repeated(); break;
            }

        }

    }
    static public function delete_shopping(){

        if( isset( $_POST['credit_del_id'] ) ){

            $shopping = ControllerGeneral::ctrRecord('single','shopping','where id = "'.$_POST['credit_del_id'].'"');

            $prod = json_decode( $shopping['products'], true );
            foreach ( $prod as $row ){
                $refe = ControllerGeneral::ctrRecord('single','`references`','where id = "'.$row['idr'].'"');
                $stock = [ 'id' => $refe['id'], 'set' => $refe['sto'] - $row['can'] ];
                $update_stock = ControllerGeneral::mdlUpdateFieldUnique('`references`','sto',$stock);
            }

            switch ( $update_stock ){
                case 'ok':
                    $data = [ 'id' => $shopping['id'], 'set' => 2 ];
                    $res = ControllerGeneral::mdlUpdateFieldUnique('shopping','status_shopping',$data);
                    break;
                default: error(); break;
            }

            switch ( $res ){
                case 'ok':
                    $pay = ControllerGeneral::ctrRecord('single','payment_shopping','order by id desc limit 1'); $pay = $pay['payment'] + 1;
                    $payments = ControllerGeneral::ctrRecord('all','payment_shopping','where shopping = "'.$shopping['shopping'].'"');
                    $save = 'ok'; $tot = 0;
                    if( !empty($payments) || $shopping['cash'] + $shopping['card'] + $shopping['other'] >0 ){
                        foreach ( $payments as $item ){ $tot += $item['cash'] + $item['card'] + $item['other']; }
                        $data = [
                            'payment' => $pay,
                            'shopping' => $shopping['shopping'],
                            'provider' => $shopping['provider'],
                            'provider_id' => $shopping['provider_id'],
                            'cash' => ( $tot + $shopping['cash'] + $shopping['card'] + $shopping['other'] ) * -1,
                            'card' => 0,
                            'other' => 0,
                            'vendor' => $_POST['credit_user_name'],
                            'vendor_id' => $_POST['credit_user_id'],
                        ];
                        $save = ControllerGeneral::ctrInsertRow('payment_shopping',$data);
                    }

                    break;
                default: error(); break;
            }

            switch ( $save ){
                case 'ok': success(); break;
                case 'error': error(); break;
            }

        }

    }

    static public function resend_case()
    {
        if( isset( $_POST['resend'] ) ){
            ControllerSending::ctrInvoice( $_POST['resend'] );
        }
    }
    static public function delete_case()
    {
        if( isset( $_POST['case'] ) ){

            $return = ControllerGeneral::ctrRecord('single', $_POST['case'],'where id = "'.$_POST['case_id'].'"');
            switch ( $_POST['case'] ){
                case 'exchanges': $sta = 'status';
                    $prod = json_decode( $return['in_products'], true );
                    foreach ( $prod as $row ){
                        $refe = ControllerGeneral::ctrRecord('single','inventories','where site = "'.$return['site'].'" and reference = "'.$row['reference'].'"');
                        ControllerGeneral::ctrUpdateFieldUnique('inventories','`returns`', [ 'id' => $refe['id'], 'set' => $refe['returns'] + $row['cant'] ] );
                        $update_stock = ControllerGeneral::ctrUpdateFieldUnique('inventories','stock', [ 'id' => $refe['id'], 'set' => $refe['stock'] + $row['cant'] ] );
                    }
                    if( $return['out_products'] != '' ){
                        $prod = json_decode( $return['out_products'], true );
                        foreach ( $prod as $row ){
                            $refe = ControllerGeneral::ctrRecord('single','inventories','where site = "'.$return['site'].'" and reference = "'.$row['reference'].'"');
                            ControllerGeneral::ctrUpdateFieldUnique('inventories','`changes`', [ 'id' => $refe['id'], 'set' => $refe['changes'] + $row['cant'] ] );
                            $update_stock = ControllerGeneral::ctrUpdateFieldUnique('inventories','stock', [ 'id' => $refe['id'], 'set' => $refe['stock'] - $row['cant'] ] );
                        }
                    }
                    break;
                default: $sta = 'status_sale';
                    $prod = json_decode( $return['products'], true );
                    foreach ( $prod as $row ){
                        $refe = ControllerGeneral::ctrRecord('single','inventories','where site = "'.$return['site'].'" and reference = "'.$row['reference'].'"');
                        ControllerGeneral::ctrUpdateFieldUnique('inventories','sales', [ 'id' => $refe['id'], 'set' => $refe['sales'] - $row['cant'] ] );
                        $update_stock = ControllerGeneral::ctrUpdateFieldUnique('inventories','stock', [ 'id' => $refe['id'], 'set' => $refe['stock'] + $row['cant'] ] );
                    }
                    break;
            }

            switch ( $update_stock ){
                case 'ok': $def = ControllerGeneral::ctrUpdateFieldUnique( $_POST['case'], $sta, [ 'id' => $return['id'], 'set' => 0 ] ); break;
                default: $def = 'error'; break;
            }

            switch ( $_POST['case'] ){
                case 'sale': $NC = ModelsGeneral::mdlRecord('single','sale','where credit_note is not null order by id desc');
                    empty($NC) ? $num = 1 : $num = $NC['credit_note']+1;
                    $def = ControllerGeneral::ctrUpdateFieldUnique('sale','credit_note', [ 'id' => $return['id'], 'set' => $num ] );
                    ControllerGeneral::ctrUpdateFieldUnique('sale','motive_cn', [ 'id' => $return['id'], 'set' => $_POST['motive_cn'] ] );
                    if( $return['cufe'] == null ){ cufe_nusopa( $return['id']); }
                    ControllerSending::ctrCreditNote( $return['id'] ); break;
            }

            switch ( $def ){ case 'ok'; success('Eliminación realizada con éxito'); break; case 'error'; error('Intente de nuevo o comuníquese con el administrador'); break; }

        }
    }

    static public function tot_double( $variable, $txt ){
        $response = ControllerGeneral::ctrExecuteQuerySingle(' select sum('.$variable.') "tot" from ( select * from sale union all select * from prospectus ) x where '.$txt );
        return $response;
    }
    static public function totals( $var, $tbl, $txt ){
        $response = ControllerGeneral::ctrExecuteQuerySingle(' select sum('.$var.') "tot" from '.$tbl.' where '.$txt );
        return $response;
    }

    static public function item_exp(){
        if( isset( $_POST['txt_save_exp'] ) ){
            $last_record = ControllerGeneral::ctrRecord('single','tags',' where `grupo`="expenses" order by id desc limit 1');
            $last_record == false ? $num = 1 : $num = $last_record['cod']+1 ;
            $data = [
                'tag' => $_POST['txt_save_exp'],
                'cod' => strval( $num ),
                'grupo' => 'expenses',
                'type' => null,
                'orden' => 0,
                'complement' => null,
                'other' => null,
            ];
            $insert = ControllerGeneral::ctrInsertRow('tags', $data );
            switch ( $insert ){
                case 'ok': success('Item gasto creado con éxito'); break;
                case 'error': error('Ocurrio un error, intente de nuevo o comuníquese con el administrador'); break;
            }
        }
    }
    static public function expense()
    {
        if( isset( $_POST['expense'] ) ){

            $data = [
                'expense' => $_POST['expense'],
                'detail' => $_POST['detail'],
                'valor' => str_replace('.','',$_POST['valor']),
                'user_id' => $_POST['user_id'],
                'user_name' => $_POST['user_name'],
                'site' => $_POST['site'],
            ];
            $insert = ControllerGeneral::ctrInsertRow('expenses', $data );

            switch ( $insert ){
                case 'ok': success("Gasto creado con éxito"); break;
                case 'error': success("¡Ocurrio un error! intente de nuevo o comuníquese con el administrador"); break;
            }

        }
    }
    static public function delete_expense(){
        if( isset( $_POST['delete'] ) ) {
            $data = [ 'id' => $_POST['delete'], 'set' => 0 ];
            $response = ControllerGeneral::ctrUpdateFieldUnique('expenses','status',$data);
            switch ( $response ){
                case 'ok': success('Gasto eliminado con éxito'); break;
                case 'error': error('Ocurrio un error, intente de nuevo o comuníquese con el administrador'); break;
            }
        }
    }

    static public function consult_ftech(){
        if( isset($_POST['input'] ) ){
            cufe_nusopa( $_POST['input'] );
        }
    }

}