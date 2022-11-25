<?php


if( $_REQUEST ) foreach( $_REQUEST as $key => $value )
{
    if( strpos( $key, 'amp;' ) === 0 )
    {
        $new_key = str_replace( 'amp;', '', $key );
        $_REQUEST[ $new_key ] = $value;
    }
}


if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'pay' && isset($_REQUEST['invoice_id']) && isset($_REQUEST['client_id']) && isset($_REQUEST['payment_method']) && isset($_REQUEST['destination'])){
    $invoice_id = intval($_REQUEST['invoice_id']);
        $client_id = intval($_REQUEST['client_id']);
        $payment_method = $_REQUEST['payment_method'];
        $destination = $_REQUEST['destination'];
        header("location:". $destination . "?invoice_id=" . $invoice_id . "&client_id=" . $client_id . "&payment_method=" . $payment_method);
}else{
    die('در پردازش درخواست شما خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید');
}
