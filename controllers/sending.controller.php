<?php

class ControllerSending{

    static public function ctrInvoice ( $ids ){

        $company = ModelsGeneral::mdlRecord('single','company','where id = 1');
        $template = ModelsGeneral::mdlRecord('single','template','where id = 1');
        $sale = ModelsGeneral::mdlRecord('single','sale','where id ='.$ids);

        $dto = $sale['subtotal'] * ($sale['dto']/100);

        $references = json_decode( $sale['products'], true );
        $customer = ModelsGeneral::mdlRecord('single','customer','where id ='.$sale['customer_id']);

//        $due_date= date('Y-m-d', strtotime($sale['created'] .'7 day')) ;
//        date("Y-m-d",strtotime($sale['created']."+ 1 month"));

        if( $sale['balance'] == 0 ){ $dateCredit = substr($sale['created'],0,10); $paymentMethods = 1; }
        else{ $dateCredit = date('Y-m-d', strtotime($sale['created'] .'15 day')); $paymentMethods = 2; }



        foreach ( $references as $key => $row ){
            $net_total = $row['price'] * $row['cant']; $total_tax = 0;
            $dinamic[] = [
                'ITE' => [
                    'ITE_1' => $key+1,
                    'ITE_2' => '',
                    'ITE_3' => $row['cant'],
                    'ITE_4' => 'NAR',
                    'ITE_5' => round($net_total,2),
                    'ITE_6' => 'COP',
                    'ITE_7' => round($row['price'],2),
                    'ITE_8' => 'COP',
                    'ITE_9' => '',
                    'ITE_11' => $row['product'],
                    'ITE_18' => '999',
                    'ITE_19' => round($net_total,2),
                    'ITE_20' => 'COP',
                    'ITE_21' => round($net_total,2),
                    'ITE_22' => 'COP',
                    'ITE_27' => $row['cant'],
                    'ITE_28' => 'NAR',
                    'IAE' => [
                        'IAE_1' => $row['reference'],
                        'IAE_2' => '999',
                    ],
                    'TII' => [
                        'TII_1' => round($total_tax,2),
                        'TII_2' => 'COP',
                        'TII_3' => 'false',
                        'IIM' => [
                            'IIM_1' => '01',
                            'IIM_2' => round($total_tax,2),
                            'IIM_3' => 'COP',
                            'IIM_4' => round($net_total,2),
                            'IIM_5' => 'COP',
                            'IIM_6' => '0',
                        ]
                    ]
                ]
            ];
        };

        $discount = [];
        if( $sale['dto'] != 0 ){
            $discount[] = [
                'DSC' => [
                    'DSC_1' => 'false',
                    'DSC_2' => number_format(round($sale['dto'],2),2),
                    'DSC_3' => $dto,
                    'DSC_4' => 'COP',
                    'DSC_7' => $sale['subtotal'],
                    'DSC_8' => 'COP',
                    'DSC_10' => 1,
                ]
            ];
        }

        $simple[] = [
            'ENC' => [
                'ENC_1' => 'INVOIC',
                'ENC_2' => $company['EMI_2_numero_identificacion'],
                'ENC_3' => $customer['document'],
                'ENC_4' => $company['ENC_4_version_ubl'],
                'ENC_5' => $company['ENC_5_version_dian'],
                'ENC_6' => $company['ICC_9_prefijo_facturacion_autorizado'].$sale['sales'],
                'ENC_7' => substr($sale['created'],0,10),
                'ENC_8' => substr($sale['created'],11,9).'-05:00',
                'ENC_9' => '01',
                'ENC_10' => 'COP',
                'ENC_15' => count( $references ),
                'ENC_16' => $dateCredit,
                'ENC_20' => $company['ENC_20_ambiente_trabajo'],
                'ENC_21' => $company['ENC_21_tipo_operacion'],
            ],
            'EMI' => [
                'EMI_1' => $company['EMI_1_tipo_identificacion'],
                'EMI_2' => $company['EMI_2_numero_identificacion'],
                'EMI_3' => $company['EMI_3_tipo_documento_identificacion'],
                'EMI_4' => $company['EMI_4_regimen'],
                'EMI_6' => $company['EMI_6_razon_social'],
                'EMI_7' => $company['EMI_7_nombre_comercial'],
                'EMI_10' => $company['EMI_10_direccion'],
                'EMI_11' => $company['EMI_11_departamento'],
                'EMI_13' => $company['EMI_13_ciudad_municipio'],
                'EMI_14' => $company['EMI_14_codigo_postal'],
                'EMI_15' => $company['EMI_15_codigo_pais'],
                'EMI_18' => $company['EMI_10_direccion'],
                'EMI_19' => $company['EMI_19_nombre_departamento'],
                'EMI_21' => $company['EMI_21_nombre_pais'],
                'EMI_22' => $company['EMI_22_digito_verificacion'],
                'EMI_23' => $company['EMI_23_codigo_municipio'],
                'EMI_24' => $company['EMI_24_nombre_registrado_rut'],
                'TAC' => [
                    'TAC_1' => 'R-99-PN',
                ],
                'DFE' => [
                    'DFE_1' => $company['EMI_23_codigo_municipio'],
                    'DFE_2' => $company['EMI_11_departamento'],
                    'DFE_3' => $company['EMI_15_codigo_pais'],
                    'DFE_4' => $company['EMI_14_codigo_postal'],
                    'DFE_5' => $company['EMI_21_nombre_pais'],
                    'DFE_6' => $company['EMI_19_nombre_departamento'],
                    'DFE_7' => $company['EMI_13_ciudad_municipio'],
                    'DFE_8' => $company['EMI_10_direccion'],
                ],
                'ICC' => [
                    'ICC_1' => $company['ICC_1_numero_matricula_mercantil'],
                    'ICC_9' => $company['ICC_9_prefijo_facturacion_autorizado'],
                ],
                'CDE' => [
                    'CDE_1' => $company['CDE_1_tipo_contacto'],
                    'CDE_2' => $company['CDE_2_nombre_contacto'],
                    'CDE_3' => $company['CDE_3_telefono_contacto'],
                    'CDE_4' => $company['CDE_4_correo_contacto'],
                ],
                'GTE' => [
                    'GTE_1' => '01',
                    'GTE_2' => 'IVA',
                ]
            ],
            'ADQ' => [
                'ADQ_1' => $customer['person'],
                'ADQ_2' => $customer['document'],
                'ADQ_3' => $customer['type_id'],
                'ADQ_4' => $customer['regime'],
                'ADQ_6' => $customer['business_name'].' '.$customer['business_surname'],
                'ADQ_7' => $customer['tradename'],
                'ADQ_8' => $customer['business_name'].' '.$customer['business_surname'],
                'ADQ_9' => $customer['business_surname'],
                'ADQ_10' => $customer['address'],
                'ADQ_11' => $customer['departamen_code'],
                'ADQ_13' => $customer['city'],
                'ADQ_14' => $customer['postal_code'],
                'ADQ_15' => 'CO',
                'ADQ_19' => $customer['departament_name'],
                'ADQ_21' => 'COLOMBIA',
                'ADQ_22' => $customer['code_document'],
                'ADQ_23' => $customer['municipal_code'],
                'TCR' => [
                    'TCR_1' => $customer['tax_responsibilities'],
                ],
                'ILA' => [
                    'ILA_1' => $customer['business_name'].' '.$customer['business_surname'],
                    'ILA_2' => $customer['document'],
                    'ILA_3' => $customer['type_id'],
                    'ILA_4' => $customer['code_document'],
                ],
                'DFA' => [
                    'DFA_1' => 'CO',
                    'DFA_2' => $customer['departamen_code'],
                    'DFA_3' => $customer['postal_code'],
                    'DFA_4' => $customer['municipal_code'],
                    'DFA_5' => 'COLOMBIA',
                    'DFA_6' => $customer['departament_name'],
                    'DFA_7' => $customer['city'],
                    'DFA_8' => $customer['address'],
                ],
                'CDA' => [
                    'CDA_1' => '1',
                    'CDA_2' => $customer['person_charge'],
                    'CDA_3' => $customer['person_phone'],
                    'CDA_4' => $customer['mail'],
                ],
                'GTA' => [
                    'GTA_1' => '01',
                    'GTA_2' => 'IVA',
                ]
            ],
            'DRF' => [
                'DRF_1' => $company['DRF_1_numero_autorizacion_dian'],
                'DRF_2' => $company['DRF_2_fecha_inicio'],
                'DRF_3' => $company['DRF_3_fech_fin'],
                'DRF_4' => $company['ICC_9_prefijo_facturacion_autorizado'],
                'DRF_5' => $company['DRF_5_rango_minimo'],
                'DRF_6' => $company['DRF_6_rango_maximo'],
            ],
            'MEP' => [
                'MEP_1' => '10',
                'MEP_2' => $paymentMethods,
                'MEP_3' => $dateCredit,
            ],
            'TOT' => [
                'TOT_1' => round($sale['subtotal'],2),
                'TOT_2' => 'COP',
                'TOT_3' => round($sale['subtotal']-$dto,2),
                'TOT_4' => 'COP',
                'TOT_5' => round($sale['subtotal']-$dto,2),
                'TOT_6' => 'COP',
                'TOT_7' => round($sale['subtotal']-$dto,2),
                'TOT_8' => 'COP',
                'TOT_9' => round($dto,2),
                'TOT_10' => 'COP'
            ],
        ];
        $data = array_merge( $simple, $discount, $dinamic );

        xml_file( $data, $template['ftech_status'], $ids, 'FACTURA' );

    }

    static public function ctrCreditNote ( $credit_note_id ){

        if( isset( $credit_note_id ) ){

            $company = ModelsGeneral::mdlRecord('single','company','where id = 1');
            $template = ModelsGeneral::mdlRecord('single','template','where id = 1');
            $sale = ModelsGeneral::mdlRecord('single','sale','where id ='.$credit_note_id);

            $dto = $sale['subtotal'] * ($sale['dto']/100);

            $references = json_decode( $sale['products'], true );
            $customer = ModelsGeneral::mdlRecord('single','customer','where id ='.$sale['customer_id']);

            $sale['balance'] == 0 ?
                $dateCredit = substr($sale['created'],0,10) :
                $dateCredit = date("Y-m-d",strtotime($sale['created']."+ 1 month"));

            foreach ( $references as $key => $row ){
                $net_total = $row['price'] * $row['cant']; $total_tax = 0;
                $dinamic[] = [
                    'ITE' => [
                        'ITE_1' => $key+1,
                        'ITE_2' => '',
                        'ITE_3' => $row['cant'],
                        'ITE_4' => 'NAR',
                        'ITE_5' => round($net_total,2),
                        'ITE_6' => 'COP',
                        'ITE_7' => round($row['price'],2),
                        'ITE_8' => 'COP',
                        'ITE_9' => '',
                        'ITE_11' => $row['product'],
                        'ITE_18' => '999',
                        'ITE_19' => round($net_total,2),
                        'ITE_20' => 'COP',
                        'ITE_21' => round($net_total,2),
                        'ITE_22' => 'COP',
                        'ITE_27' => $row['cant'],
                        'ITE_28' => 'NAR',
                        'IAE' => [
                            'IAE_1' => $row['reference'],
                            'IAE_2' => '999',
                        ],
                        /*'TII' => [
                            'TII_1' => round($total_tax,2),
                            'TII_2' => 'COP',
                            'TII_3' => 'false',
                            'IIM' => [
                                'IIM_1' => '01',
                                'IIM_2' => round($total_tax,2),
                                'IIM_3' => 'COP',
                                'IIM_4' => round($net_total,2),
                                'IIM_5' => 'COP',
                                'IIM_6' => '0',
                            ]
                        ]*/
                    ]
                ];
            };

            $discount = [];
            if( $sale['dto'] != 0 ){
                $discount[] = [
                    'DSC' => [
                        'DSC_1' => 'false',
                        'DSC_2' => number_format(round($sale['dto'],2),2),
                        'DSC_3' => $dto,
                        'DSC_4' => 'COP',
                        'DSC_7' => $sale['subtotal'],
                        'DSC_8' => 'COP',
                        'DSC_10' => 1,
                    ]
                ];
            }

            $simple[] = [
                'ENC' => [
                    'ENC_1' => 'NC',
                    'ENC_2' => $company['EMI_2_numero_identificacion'],
                    'ENC_3' => $customer['document'],
                    'ENC_4' => $company['ENC_4_version_ubl'],
                    'ENC_5' => $company['ENC_5_version_dian'],
                    'ENC_6' => 'NC'.$sale['credit_note'],
                    'ENC_7' => substr($sale['modified'],0,10),
                    'ENC_8' => substr($sale['modified'],11,9).'-05:00',
                    'ENC_9' => '91',
                    'ENC_10' => 'COP',
                    'ENC_15' => count( $references ),
                    'ENC_16' => date("Y-m-d",strtotime($sale['created']."+ 1 month")),
                    'ENC_20' => $company['ENC_20_ambiente_trabajo'],
                    'ENC_21' => '20',
                ],
                'EMI' => [
                    'EMI_1' => $company['EMI_1_tipo_identificacion'],
                    'EMI_2' => $company['EMI_2_numero_identificacion'],
                    'EMI_3' => $company['EMI_3_tipo_documento_identificacion'],
                    'EMI_4' => $company['EMI_4_regimen'],
                    'EMI_6' => $company['EMI_6_razon_social'],
                    'EMI_7' => $company['EMI_7_nombre_comercial'],
                    'EMI_10' => $company['EMI_10_direccion'],
                    'EMI_11' => $company['EMI_11_departamento'],
                    'EMI_13' => $company['EMI_13_ciudad_municipio'],
                    'EMI_14' => $company['EMI_14_codigo_postal'],
                    'EMI_15' => $company['EMI_15_codigo_pais'],
                    'EMI_18' => $company['EMI_10_direccion'],
                    'EMI_19' => $company['EMI_19_nombre_departamento'],
                    'EMI_21' => $company['EMI_21_nombre_pais'],
                    'EMI_22' => $company['EMI_22_digito_verificacion'],
                    'EMI_23' => $company['EMI_23_codigo_municipio'],
                    'EMI_24' => $company['EMI_24_nombre_registrado_rut'],
                    'TAC' => [
                        'TAC_1' => 'R-99-PN',
                    ],
                    'DFE' => [
                        'DFE_1' => $company['EMI_23_codigo_municipio'],
                        'DFE_2' => $company['EMI_11_departamento'],
                        'DFE_3' => $company['EMI_15_codigo_pais'],
                        'DFE_4' => $company['EMI_14_codigo_postal'],
                        'DFE_5' => $company['EMI_21_nombre_pais'],
                        'DFE_6' => $company['EMI_19_nombre_departamento'],
                        'DFE_7' => $company['EMI_13_ciudad_municipio'],
                        'DFE_8' => $company['EMI_10_direccion'],
                    ],
                    'ICC' => [
                        'ICC_1' => $company['ICC_1_numero_matricula_mercantil'],
                        'ICC_9' => 'NC',
                    ],
                    'CDE' => [
                        'CDE_1' => $company['CDE_1_tipo_contacto'],
                        'CDE_2' => $company['CDE_2_nombre_contacto'],
                        'CDE_3' => $company['CDE_3_telefono_contacto'],
                        'CDE_4' => $company['CDE_4_correo_contacto'],
                    ],
                    'GTE' => [
                        'GTE_1' => '01',
                        'GTE_2' => 'IVA',
                    ]
                ],
                'ADQ' => [
                    'ADQ_1' => $customer['person'],
                    'ADQ_2' => $customer['document'],
                    'ADQ_3' => $customer['type_id'],
                    'ADQ_4' => $customer['regime'],
                    'ADQ_6' => $customer['business_name'].' '.$customer['business_surname'],
                    'ADQ_7' => $customer['tradename'],
                    'ADQ_8' => $customer['business_name'].' '.$customer['business_surname'],
                    'ADQ_9' => $customer['business_surname'],
                    'ADQ_10' => $customer['address'],
                    'ADQ_11' => $customer['departamen_code'],
                    'ADQ_13' => $customer['city'],
                    'ADQ_14' => $customer['postal_code'],
                    'ADQ_15' => 'CO',
                    'ADQ_19' => $customer['departament_name'],
                    'ADQ_21' => 'COLOMBIA',
                    'ADQ_22' => $customer['code_document'],
                    'ADQ_23' => $customer['municipal_code'],
                    'TCR' => [
                        'TCR_1' => $customer['tax_responsibilities'],
                    ],
                    'ILA' => [
                        'ILA_1' => $customer['business_name'].' '.$customer['business_surname'],
                        'ILA_2' => $customer['document'],
                        'ILA_3' => $customer['type_id'],
                        'ILA_4' => $customer['code_document'],
                    ],
                    'DFA' => [
                        'DFA_1' => 'CO',
                        'DFA_2' => $customer['departamen_code'],
                        'DFA_3' => $customer['postal_code'],
                        'DFA_4' => $customer['municipal_code'],
                        'DFA_5' => 'COLOMBIA',
                        'DFA_6' => $customer['departament_name'],
                        'DFA_7' => $customer['city'],
                        'DFA_8' => $customer['address'],
                    ],
                    'CDA' => [
                        'CDA_1' => '1',
                        'CDA_2' => $customer['person_charge'],
                        'CDA_3' => $customer['person_phone'],
                        'CDA_4' => $customer['mail'],
                    ],
                    'GTA' => [
                        'GTA_1' => '01',
                        'GTA_2' => 'IVA',
                    ]
                ],
                'DRF' => [
                    'DRF_1' => '0001',
                    'DRF_2' => '2022-09-15',
                    'DRF_3' => '2024-09-15',
                    'DRF_4' => 'NC',
                    'DRF_5' => '1',
                    'DRF_6' => '999',
                ],
                'REF' => [
                    'REF_1' => 'IV',
                    'REF_2' => $company['ICC_9_prefijo_facturacion_autorizado'].$sale['sales'],
                    'REF_3' => substr($sale['created'],0,10),
                    'REF_4' => $sale['cufe'],
                ],
                'MEP' => [
                    'MEP_1' => '10',
                    'MEP_2' => '1',
                    'MEP_3' => substr($sale['modified'],0,10),
                ],
                'TOT' => [
                    'TOT_1' => round($sale['subtotal'],2),
                    'TOT_2' => 'COP',
                    'TOT_3' => '0',
                    'TOT_4' => 'COP',
                    'TOT_5' => round($sale['subtotal']-$dto,2),
                    'TOT_6' => 'COP',
                    'TOT_7' => round($sale['subtotal']-$dto,2),
                    'TOT_8' => 'COP',
                    'TOT_9' => round($dto,2),
                    'TOT_10' => 'COP'
                ],
            ];
            $data = array_merge( $simple, $discount, $dinamic );

            xml_file( $data, $template['ftech_status'], $credit_note_id, 'NOTA' );

        }

    }

}



function xml_file( $data, $type, $ids, $seg ){

    $objetoXML = new XMLWriter();

    switch ($type){
        case 0: $objetoXML->openURI("a_other.xml");break;
        case 1: $objetoXML->openMemory(); break;
    }

    $objetoXML->startDocument('1.0', 'UTF-8');
    $objetoXML->setIndent(true);
    $objetoXML->setIndentString("\t");
    $objetoXML->startElement($seg);
    $objetoXML->writeAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
    $objetoXML->writeAttribute("xmlns:xsd", "http://www.w3.org/2001/XMLSchema");

    foreach ( $data as $a => $na ){
        foreach ( $na as $b => $nb ){
            $objetoXML->startElement($b);
            foreach ( $nb as $c => $nc ){

                if( is_array( $nc ) ){
                    $objetoXML->startElement(substr($c,0,3));
                    foreach ( $nc as $d => $nd ){

                        if( is_array( $nd ) ){
                            $objetoXML->startElement($d);
                            foreach ( $nd as $e => $ne ){
                                $objetoXML->startElement( $e);
                                $objetoXML->text($ne);
                                $objetoXML->endElement();
                            }
                            $objetoXML->endElement();
                        }else{
                            $objetoXML->startElement($d); $objetoXML->text($nd); $objetoXML->endElement();
                        }

                    }
                    $objetoXML->endElement();
                }else{
                    $objetoXML->startElement($c); $objetoXML->text($nc); $objetoXML->endElement();
                }

            }
            $objetoXML->endElement();
        }
    }

    $objetoXML->fullEndElement ();

    $objetoXML->endElement();
    $objetoXML->endDocument();

    switch ($type){
        case 1: interaction_nusopa( base64_encode( $objetoXML->outputMemory() ), $seg, $ids ); break;
//        case 1: echo base64_encode( $objetoXML->outputMemory() ); break;
    }

}
function interaction_nusopa( $base64, $seg, $ids ){
    ini_set('display_errors', 1);
    $cliente = new nusoap_client("https://ws.facturatech.co/v2/pro/index.php?wsdl");
    $cliente->soap_defencoding = 'utf-8';
    $error = $cliente->getError();
    if($error){ ControllerGeneral::ctrUpdateFieldUnique('sale','response', [ 'id'=>$ids, 'set'=>json_encode($error) ] ); }
    else{
        $result = $cliente->call('FtechAction.uploadInvoiceFile', ["username" => "1073246748", "password" => "639f6580fa280d1697d309ba5756732fd04e4f1b3d5dae3bf91b876f966ee614", "xmlBase64" => $base64]);
        echo json_encode($result);
        if ($cliente->fault) { ControllerGeneral::ctrUpdateFieldUnique('sale','response', [ 'id'=>$ids, 'set'=>$result['faultstring'] ] ); }
        else {
            $error = $cliente->getError();
            if ($error) {  ControllerGeneral::ctrUpdateFieldUnique('sale','response', [ 'id'=>$ids, 'set'=>$error ] ); }
            else {
                $invoice = ControllerGeneral::ctrRecord('single','sale','where id='.$ids);
                switch ( $result['code'] ){
                    case '201': switch ( $seg ){
                            case 'FACTURA':
                                ControllerGeneral::ctrUpdateFieldUnique('sale','response', [ 'id'=>$ids, 'set'=>json_encode($result) ] );
                                ControllerGeneral::ctrUpdateFieldUnique('sale','transaccionID', [ 'id'=>$ids, 'set'=>$result['transaccionID'] ] );
                                $cliente->call('FtechAction.documentStatusFile', ["username" => "1073246748", "password" => "639f6580fa280d1697d309ba5756732fd04e4f1b3d5dae3bf91b876f966ee614", "transaccionID" => $result['transaccionID'] ]);
                                ControllerGeneral::ctrUpdateFieldUnique('sale','status_fe', [ 'id'=>$ids, 'set'=>$result['code'] ] );
                                $result = $cliente->call('FtechAction.getCUFEFile', ["username" => "1073246748", "password" => "639f6580fa280d1697d309ba5756732fd04e4f1b3d5dae3bf91b876f966ee614", "prefijo" => 'FE' , "folio" => $invoice['sales'] ]);
                                ControllerGeneral::ctrUpdateFieldUnique('sale','cufe', [ 'id'=>$invoice['id'], 'set'=>$result['resourceData'] ] );
                                break;
                            case 'NOTA':
                                ControllerGeneral::ctrUpdateFieldUnique('sale','status_fe', [ 'id'=>$ids, 'set'=>$result['code'] ] );
                                ControllerGeneral::ctrUpdateFieldUnique('sale','response_cn', [ 'id'=>$ids, 'set'=>json_encode($result) ] );
                                ControllerGeneral::ctrUpdateFieldUnique('sale','status_cn', [ 'id'=>$ids, 'set'=>$result['code'] ] );
                                ControllerGeneral::ctrUpdateFieldUnique('sale','transactionID_CN', [ 'id'=>$ids, 'set'=>$result['transaccionID'] ] );
                                $cliente->call('FtechAction.documentStatusFile', ["username" => "1073246748", "password" => "639f6580fa280d1697d309ba5756732fd04e4f1b3d5dae3bf91b876f966ee614", "transaccionID" => $result['transaccionID'] ]);
                                break;
                        }; break;
                    default: error( $result['error'] ); switch ( $seg ){
                            case 'FACTURA': ControllerGeneral::ctrUpdateFieldUnique('sale','response', [ 'id'=>$ids, 'set'=>$result['error'] ] ); break;
                            case 'NOTA':ControllerGeneral::ctrUpdateFieldUnique('sale','response_cn', [ 'id'=>$ids, 'set'=>$result['error'] ] ); break;
                        }; break;
                }
            }
        }
    }
}

function cufe_nusopa( $ids ){
    $company = ModelsGeneral::mdlRecord('single','company','where id = 1');
    $invoice = ControllerGeneral::ctrRecord('single','sale','where id='.$ids);
    ini_set('display_errors', 1);
    $cliente = new nusoap_client("https://ws.facturatech.co/v2/pro/index.php?wsdl");
    $cliente->soap_defencoding = 'utf-8';
    $result = $cliente->call('FtechAction.getCUFEFile', ["username" => "1073246748", "password" => "639f6580fa280d1697d309ba5756732fd04e4f1b3d5dae3bf91b876f966ee614", "prefijo" => $company['ICC_9_prefijo_facturacion_autorizado'] , "folio" => $invoice['sales'] ]);
    ControllerGeneral::ctrUpdateFieldUnique('sale','cufe', [ 'id'=>$invoice['id'], 'set'=>$result['resourceData'] ] );
}

