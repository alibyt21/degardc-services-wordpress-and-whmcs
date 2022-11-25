<?php

use WHMCS\Database\Capsule;

add_hook('ClientAreaPage', 1, function($vars) {
    
   if(isset($_REQUEST['payment_method'])) {
        
        $invoice_id = $_REQUEST['invoice_id'];
        $payment_method = $_REQUEST['payment_method'];
        $client_id = $_REQUEST['client_id'];

        $_SESSION['uid'] = $client_id;

        $command = 'GetClientsDetails';
        $postData = array(
            'clientid' => $client_id,
        );
        $client_info = localAPI($command, $postData);
        $client = [];
        $client['clientdetails'] = $client_info['client'];

        $command = 'GetInvoice';
        $postData = array(
            'invoiceid' => $invoice_id,
        );
        $invoice_info = localAPI($command, $postData);
        

        require_once __DIR__ . '/../../../includes/gatewayfunctions.php';
        
        $gatewayParams = getGatewayVariables($payment_method);
        
        require_once __DIR__ . '/../../gateways/'.$payment_method.'.php';
        /* $config = $payment_method.'_config';
        print_r($config()); */
        $func = $payment_method.'_link';
        if(function_exists($func)){
            echo $func(array_merge($invoice_info, $gatewayParams, $client));
            echo '<script language="javascript">
            document.getElementsByTagName("form")[0].submit();
                
            </script>';
        }
       
        die();
    } 
});


