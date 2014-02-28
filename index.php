<?php

    include_once('openerp.class.php');

    $rpc = new OpenERP();

    $rpc->login("admin", "admin", "database_name", "database_host:8069/xmlrpc/");

    // SEARCH
    $filter=Array(
        Array('name', 'like', 'openerp')
    );
    $partner_by_name_ids = $rpc->search('res.partner', $filter);
    echo 'SEARCH PARTNERS BY NAME IDS:<br />';
    print_r($partner_by_name_ids);

    $new_filter=Array(
        Array('id', '>', 100),
        Array('id', '<', 120)
    );

    $partner_by_id_ids = $rpc->search('res.partner', $new_filter);
    echo 'SEARCH PARTNERS BY ID IDS:<br />';
    print_r($partner_by_id_ids);

    // READ
    $fields = array(
        'id','name','ref'
    );
    $partners = $rpc->read($partner_by_name_ids, $fields, "res.partner");

    echo 'READ PARTNERS:<br />';
    foreach ($partners as $p){
        echo $p['ref'] . ' - ' . $p['name']. '<br />';
    }

    // CREATE
    $vals = array(
        'name'=>new xmlrpcval('John Doe', "string"),
        'phone'=>new xmlrpcval('000-45679845697', "string"),
        );
    $new_partner_id = $rpc->create($vals, "res.partner");

    // CALL ON_CHANGHE FUNCTION
    // Call the onchange_partner_id function in sale.order for order with id 6 and partner_id 7
    $ids = array(6);
    $vals = array(
        'part'=>array(7,'int'),
        );
    $res = $rpc->call_function('sale.order','onchange_partner_id',$ids,$vals);
    $res_val = $res->structmem('value');

    $user_id = $res_val->structmem('user_id')->scalarval();
    $partner_invoice_id = $res_val->structmem('partner_invoice_id')->scalarval();
    $partner_shipping_id = $res_val->structmem('partner_shipping_id')->scalarval();
    $payment_term = $res_val->structmem('payment_term')->scalarval();
    $fiscal_position = $res_val->structmem('fiscal_position')->scalarval();
    echo 'ONCHANGE_PARTNER_ID VALUES<br />';
    echo 'USER ID ' . $user_id . '<br />';
    echo 'PARTNER INVOICE ID ' . $partner_invoice_id . '<br />';
    echo 'PARTNER SHIPPING ID ' . $partner_shipping_id . '<br />';
    echo 'PAYMENT TERM ID ' . $payment_term . '<br />';
    echo 'FISCAL POSITION ID ' . $fiscal_position . '<br />';

?>
