<?php

	include_once('openerp.class.php');

	$rpc = new OpenERP();

	$rpc->login("admin", "admin", "database_name", "database_host:8069/xmlrpc/");

	// SEARCH
	$partner_by_name_ids = $rpc->search('res.partner', 'name', 'like', 'openerp', 'string');
	echo 'SEARCH PARTNERS BY NAME IDS:<br />';
	print_r($partner_by_name_ids);
	$partner_by_id_ids = $rpc->search('res.partner', 'id', '>', 100, 'int');
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

?>
