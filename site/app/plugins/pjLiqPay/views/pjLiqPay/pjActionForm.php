<?php

require_once dirname(__FILE__) . '/pjLiqPaySDK.php';

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                																																																																																																																																		
//$private_key = 'b8S75OT5Ot6yw5rkuWzwHg8pqJSoBlkx2DGOTdhn';																																																																																																					
//$public_key = 'i13881580010';

$public_key = 'sandbox_i42968995129';
$private_key = 'sandbox_UXFowv7bgWRt3gbLR30XmLhO5s3YV3kacoqrWaFH';
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
if(isset($tpl['arr']['paytypes'])){
//    echo __LINE__;exit();
    $pjLiqPayFormParams['paytypes'] = $tpl['arr']['paytypes'];
}


$html = $liqpay->cnb_form($pjLiqPayFormParams);

echo $html;

?>