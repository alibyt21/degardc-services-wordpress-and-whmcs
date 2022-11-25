<?php


add_action('admin_enqueue_scripts','degardc_services_add_admin_styles');
function degardc_services_add_admin_styles(){
    wp_enqueue_style('degardc-services-admin-styles',DEGARDC_SERVICES_PLUGIN_URL.'css/admin/degardc-services-admin.css');
}


add_action('wp_enqueue_scripts','degardc_services_add_front_styles');
function degardc_services_add_front_styles(){
    wp_enqueue_style('degardc-services-front-styles',DEGARDC_SERVICES_PLUGIN_URL.'css/front/degardc-services-front.css');
    wp_register_script('degardc-services-main-scripts' , DEGARDC_SERVICES_PLUGIN_URL . 'js/degardc-services-main-scripts.js' , array('jquery'), false , true );
    wp_enqueue_script('degardc-services-main-scripts');
    /*
     * 	send data by ajax to degardc-services-main-scripts.js
     */
    wp_localize_script('degardc-services-main-scripts' , 'degardc_services_ajax_object' , array('ajax_url' => admin_url('admin-ajax.php')));
}


add_action('wp', 'degardc_services_payment_result_process');
function degardc_services_payment_result_process(){
    global $degardc_services_options;
    $page_id = get_the_ID();
    $user_id = get_current_user_id();
    if( is_page() && ($page_id == $degardc_services_options['payment_result_page_id']) ) {
        if (isset($_REQUEST['status']) && isset($_REQUEST['invoiceid']) && (($_REQUEST['status'] == 'succeed') || ($_REQUEST['status'] == 'failed'))) {
            $payres['invoiceid'] = sanitize_text_field($_REQUEST['invoiceid']);
            $payres['trynew'] = false;
            var_dump('salam');
            if ($_REQUEST['status'] == 'succeed') {
                $payres['status'] = 'succeed';
                $payres['trynew'] = false;
                $invoice_id = intval(sanitize_text_field($_REQUEST['invoiceid']));
                if (is_camp_cookie_set()) {
                    $camp_cookie = is_camp_cookie_set();
                    if (isset($camp_cookie['invoiceid'])) {
                        $camp_cookie_invoice_id = $camp_cookie['invoiceid'];
                    } else {
                        $camp_cookie_invoice_id = null;
                    }
                    if ($camp_cookie_invoice_id == $invoice_id) {
                        //it means user try to buy new campaign
                        $payres['trynew'] = 'camp';
                        //it means user buy a new campaign and succeed
                        $payres['domain'] = $camp_cookie['domain'];
                        $payres['billingcycle'] = $camp_cookie['billingcycle'];
                    }
                }
            } elseif ($_REQUEST['status'] == 'failed') {
                $payres['status'] = 'failed';
            }
            setcookie('payres', json_encode($payres), time() + 3600, '/');
            wp_redirect(get_permalink($degardc_services_options['payment_result_page_id']));
        }
        if(isset($_COOKIE['payres'])){
            $payres = json_decode(stripslashes($_COOKIE['payres']),true);
            if($payres['trynew'] == 'camp'){
                setcookie('camp' . $user_id, null, 1 , '/');
            }
        }
    }
}