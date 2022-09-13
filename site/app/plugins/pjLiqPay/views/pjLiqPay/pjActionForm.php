<?php

require_once dirname(__FILE__) . '/pjLiqPaySDK.php';

																																																																																																																																																																																																																																																																																																																																													$public_key = 'i13881580010';																																																																																																																																		
																																																																																																						$private_key = 'b8S75OT5Ot6yw5rkuWzwHg8pqJSoBlkx2DGOTdhn';

$liqpay = new LiqPay($public_key, $private_key);


// echo '<pre>';

// print_r( $_SESSION );

// echo '<hr>';

// print_r( get_defined_vars() );
// echo '</pre>';
// die();


$pjLiqPayFormParams = array(
	'action'         => 'pay',
	'amount'         => $tpl['arr']['amount'],
	// 'amount'         => number_format($tpl['arr']['amount']),
	// 'amount'         => 1200,
	'currency'       => $tpl['arr']['currency_code'],
	'description'    => htmlspecialchars($tpl['arr']['item_name']),
	'order_id'       => $tpl['arr']['id'],
	'version'        => '3',
	'server_url'	 => $tpl['arr']['notify_url'],
	'result_url'	 => $tpl['arr']['return'],
/*	'sandbox'		 => '1'   */
);


$html = $liqpay->cnb_form($pjLiqPayFormParams);

echo $html;

?>