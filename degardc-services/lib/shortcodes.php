<?php

add_shortcode( 'degardc_services_my_campaigns', 'degardc_services_my_campaigns_callback' );
function degardc_services_my_campaigns_callback(){

    if (!is_user_logged_in()){
        ?>
        <div><p>شما اجازه مشاهده این صفحه را ندارید</p></div><div><a class="btn" href="<?php echo home_url(); ?>">بازگشت به صفحه اصلی</a></div>
        <?php
    }else {

        global $degardc_services_options;
        $local_current_user = wp_get_current_user();
        $user_email = $local_current_user->user_email;
        if(!$user_email){
            global $current_user;
            $user_email = $current_user->user_email;
        }

        $error = true;
        $try_num = 1;
        while($error && $try_num<3) {
            $encode_client_details = whmcs_request('GetClientsDetails', [
                'email' => $user_email
            ]);
            $client_details = json_decode($encode_client_details);
            $client_details_result = $client_details->result;
            if (strtolower($client_details_result) == 'success') {
                $error = false;
            } else {
                usleep( 200 * 1000 );
                $try_num++;
            }
        }

        if ($error){
            //it means some error has happened
            $message = $client_details->message;
            if (strtolower($message) == 'client not found'){
                // it means there is no client with requested email address
                ?>
                <div class="degardc-container">
                    <p>شما هنوز هیچ کمپینی راه‌اندازی نکرده‌اید</p>
                    <a href="<?php echo get_permalink($degardc_services_options['campaign_buy_new_campaign_page_id']) ?>" class="btn btn-info px-4">راه‌اندازی اولین کمپین</a>
                </div>
                <?php
            }
            //this place we can insert new reaction to different condition by message

        }else{
            //it means there is no error and we have to show client's campaigns details
            $whmcs_client_id = $client_details->client_id;

            if (isset($_GET['action']) && $_GET['action'] == 'campaign-services'){

                //we have to show client campaigns services


                $error = true;
                $try_num = 1;
                while($error && $try_num<3) {
                    $encode_client_campaigns = whmcs_request('GetClientsProducts', [
                        'clientid' => $whmcs_client_id,
                        'pid' => $degardc_services_options['campaign_product_id']
                    ]);
                    $client_campaigns = json_decode($encode_client_campaigns);
                    $client_campaigns_result = $client_campaigns->result;
                    if (strtolower($client_campaigns_result) == 'success') {
                        $error = false;
                    } else {
                        usleep( 200 * 1000 );
                        $try_num++;
                    }
                }
                if(!$error){
                    $client_campaigns_totalresults = $client_campaigns->totalresults;
                    if($client_campaigns_totalresults > 0){
                        $products = $client_campaigns->products->product;

                        //load persian date
                        include DEGARDC_SERVICES_PLUGIN_PATH . '/lib/jdf.php';

                        //load html tpl
                        ob_start();
                        include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/front/account/campaign-services-html.php';
                        $html = ob_get_clean();
                        return $html;
                    }else{
                        ?>
                        <div class="degardc-container">
                            <p>شما هنوز هیچ کمپینی راه‌اندازی نکرده‌اید</p>
                            <a href="<?php echo get_permalink($degardc_services_options['campaign_buy_new_campaign_page_id']) ?>" class="btn btn-info px-4">راه‌اندازی اولین کمپین</a>
                        </div>
                        <?php
                    }

                }else{
                    ?>
                    <p>در دریافت اطلاعات خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید</p>
                    <?php
                }



            }elseif (isset($_GET['action']) && $_GET['action'] == 'campaign-invoices'){

                //we have to show client campaigns invoices
                $error = true;
                $try_num = 1;
                while($error && $try_num<3) {
                    $encode_client_invoices = whmcs_request('GetInvoices', [
                        'userid' => $whmcs_client_id,
                        'orderby' => 'invoicenumber',
                        'order' => 'desc'
                    ]);
                    $client_invoices = json_decode($encode_client_invoices);
                    $client_invoices_result = $client_invoices->result;
                    if (strtolower($client_invoices_result) == 'success') {
                        $error = false;
                    } else {
                        usleep( 200 * 1000 );
                        $try_num++;
                    }
                }
                if(!$error){
                    $totalresults = $client_invoices->totalresults;
                    if($totalresults > 0){
                        $invoices = $client_invoices->invoices->invoice;

                        //load persian date
                        include DEGARDC_SERVICES_PLUGIN_PATH . '/lib/jdf.php';

                        //load html tpl
                        ob_start();
                        include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/front/account/campaign-invoices-html.php';
                        $html = ob_get_clean();
                        return $html;
                    }else{
                        ?>
                        <div class="degardc-container">
                            <a href="?" class="degardc-btn-back">بازگشت<i aria-hidden="true" class="fas fa-reply" style="margin-right: 5px"></i></a>
                            <hr class="degardc-hr">
                            <p>اینجا اطلاعاتی برای نمایش وجود ندارد</p>
                        </div>
                        <?php
                    }

                }else{
                    ?>
                    <p>در دریافت اطلاعات خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید</p>
                    <?php
                }


            }elseif (isset($_GET['action']) && $_GET['action'] == 'view-invoice'){
                if (isset($_GET['id'])){
                    $invoice_id = intval($_GET['id']);

                    $error = true;
                    $try_num = 1;
                    while($error && $try_num<3) {
                        $encode_specific_client_invoice = whmcs_request('GetInvoice', [
                            'invoiceid' => $invoice_id,
                        ]);
                        $specific_client_invoice = json_decode($encode_specific_client_invoice);
                        $specific_client_invoice_result = $specific_client_invoice->result;
                        if (strtolower($specific_client_invoice_result) == 'success') {
                            $error = false;
                        } else {
                            usleep( 200 * 1000 );
                            $try_num++;
                        }
                    }

                    if(!$error){
                        if($specific_client_invoice->userid == $whmcs_client_id){

                            //we have to show specific invoice details
                            //load persian date
                            include DEGARDC_SERVICES_PLUGIN_PATH . '/lib/jdf.php';

                            //load html tpl
                            ob_start();
                            include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/front/account/view-invoice-html.php';
                            $html = ob_get_clean();
                            return $html;
                        }else{
                            echo 'شما اجازه مشاهده این صفحه را ندارید';
                        }
                    }else{
                        ?>
                        <p>در دریافت اطلاعات خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید</p>
                        <?php
                    }
                }else{
                    echo 'اطلاعاتی که به دنبال آن هستید یافت نشد';
                }
            }else{


                $error = true;
                $try_num = 1;
                while($error && $try_num<3) {
                    $encode_client_campaigns = whmcs_request('GetClientsProducts', [
                        'clientid' => $whmcs_client_id,
                        'pid' => $degardc_services_options['campaign_product_id']
                    ]);
                    $client_campaigns = json_decode($encode_client_campaigns);
                    $client_campaigns_result = $client_campaigns->result;

                    $encode_client_invoices = whmcs_request('GetInvoices', [
                        'userid' => $whmcs_client_id,
                        'status' => 'unpaid'
                    ]);
                    $client_invoices = json_decode($encode_client_invoices);
                    $client_invoices_result = $client_invoices->result;
                    if (strtolower($client_campaigns_result) == 'success' && strtolower($client_invoices_result) == 'success') {
                        $error = false;
                    } else {
                        usleep( 200 * 1000 );
                        $try_num++;
                    }
                }

                if(!$error){

                    $client_invoices_totalresults = $client_invoices->totalresults;
                    if($client_invoices_totalresults > 0){
                        $client_invoices_array = $client_invoices->invoices->invoice;

                        $total_unpaid = 0;
                        foreach ($client_invoices_array as $invoice){
                            $invoice_id = $invoice->id;
                            $encode_client_invoice = whmcs_request('GetInvoice', [
                                'invoiceid' => $invoice_id,
                            ]);
                            $client_invoice = json_decode($encode_client_invoice);
                            $total_unpaid += $client_invoice->subtotal;
                        }
                    }else{
                        $total_unpaid = 0;
                    }

                    //these variable is used in tpl/front/my-campaigns-html
                    $total_campaigns = $client_campaigns->totalresults;

                    ob_start();
                    include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/front/account/my-campaigns-html.php';
                    $html = ob_get_clean();
                    return $html;

                }else{
                    ?>
                    <p>در دریافت اطلاعات خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید</p>
                    <?php
                }
            }
        }
    }
}





add_shortcode( 'degardc_services_buy_new_campaign_check_domain', 'degardc_services_buy_new_campaign_check_domain_callback' );
function degardc_services_buy_new_campaign_check_domain_callback(){
    global $degardc_services_options;
    $billingcycle = $_GET['billingcycle'];
    ob_start();
    include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/front/order/campaign-check-domain-html.php';
    $html = ob_get_clean();
    return $html;
}


add_shortcode( 'degardc_services_buy_new_campaign_login_register', 'degardc_services_buy_new_campaign_login_register_callback' );
function degardc_services_buy_new_campaign_login_register_callback(){
    global $degardc_services_options;

    $camp_cookie = is_camp_cookie_set();
    if($camp_cookie){
        if(is_user_logged_in()){
            $user_id = get_current_user_id();
            if(is_user_entered_full_name($user_id) && is_user_verified_mobile_number($user_id)){
                $html = '<script>window.location.replace("'.get_permalink($degardc_services_options['campaign_checkout_page_id']).'");</script>';
                return $html;
            }else{
                $html = '<script>window.location.replace("'.get_permalink($degardc_services_options['campaign_validation_page_id']).'");</script>';
                return $html;
            }
        }else{
            ob_start();
            include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/front/order/campaign-login-register-html.php';
            $html = ob_get_clean();
            return $html;
        }
    }else{
        $html = '<script>window.location.replace("'.get_permalink($degardc_services_options['campaign_buy_new_campaign_page_id']).'");</script>';
        return $html;
    }

}


add_shortcode( 'degardc_services_buy_new_campaign_validation', 'degardc_services_buy_new_campaign_validation_callback' );
function degardc_services_buy_new_campaign_validation_callback(){
    global $degardc_services_options;
    $camp_cookie = is_camp_cookie_set();
    if($camp_cookie){
        if(is_user_logged_in()){
            $user_id = get_current_user_id();
            if(is_user_verified_mobile_number($user_id) && is_user_entered_full_name($user_id)){
                $html = '<script>window.location.replace("'.get_permalink($degardc_services_options['campaign_checkout_page_id']).'");</script>';
                return $html;
            }else{
                ob_start();
                include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/front/order/campaign-validation-html.php';
                $html = ob_get_clean();
                return $html;
            }
        }else{
            $html = '<script>window.location.replace("'.get_permalink($degardc_services_options['campaign_login_register_page_id']).'");</script>';
            return $html;
        }
    }else{
        $html = '<script>window.location.replace("'.get_permalink($degardc_services_options['campaign_buy_new_campaign_page_id']).'");</script>';
        return $html;
    }
}


add_shortcode( 'degardc_services_buy_new_campaign_checkout', 'degardc_services_buy_new_campaign_checkout_callback' );
function degardc_services_buy_new_campaign_checkout_callback(){

    global $degardc_services_options;
    $camp_cookie = is_camp_cookie_set();
    if($camp_cookie){
        if(is_user_logged_in()){

            $pid = $degardc_services_options['campaign_product_id'];
            $order_domain = $camp_cookie['domain'];
            $billingcycle = $camp_cookie['billingcycle'];
            $encode_paymentmethods = whmcs_request('GetPaymentMethods', []);
            $paymentmethods = json_decode($encode_paymentmethods);
            $order_paymentmethods = $paymentmethods->paymentmethods->paymentmethod;
            $order_paymentmethod = $order_paymentmethods[0]->module;


            $error = true;
            $try_num = 1;
            while($error && $try_num<3) {
                $encode_products = whmcs_request('GetProducts', [
                    'pid' => $pid
                ]);
                $products = json_decode($encode_products , true);
                $products_result = $products['result'];
                if (strtolower($products_result) == 'success') {
                    $error = false;
                } else {
                    usleep( 200 * 1000 );
                    $try_num++;
                }
            }

            if(!$error){
                $order_product = $products['products']['product'];
                $order_product_name = $order_product[0]['name'];
                $billingcycle_translate = [
                    'monthly' => 'یک ماهه',
                    'quarterly' => 'سه ماهه',
                    'semiannually' => 'شش ماهه',
                    'annually' => 'یک ساله',
                    'biennially' => 'دو ساله',
                    'triennially' => 'سه ساله'
                ];
                $order_product_prices = $order_product[0]['pricing'];
                //we used $keys to find whmcs currency that is set
                $keys = array_keys($order_product_prices);
                $currency = $keys[0];
                $currency_suffix = $order_product_prices[$currency]['suffix'];
                $currency_suffix = 'هزار' . $currency_suffix ;
                $order_product_price = number_format($order_product_prices[$currency][$billingcycle]/1000);
                ob_start();
                include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/front/order/campaign-checkout-html.php';
                $html = ob_get_clean();
                return $html;
            }else{
                ?>
                <p>در دریافت اطلاعات خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید</p>
                <?php
            }
        }else{
            $html = '<script>window.location.replace("'.get_permalink($degardc_services_options['campaign_login_register_page_id']).'");</script>';
            return $html;
        }
    }else{
        $html = '<script>window.location.replace("'.get_permalink($degardc_services_options['campaign_buy_new_campaign_page_id']).'");</script>';
        return $html;
    }
}




add_shortcode( 'degardc_services_payment_result', 'degardc_services_payment_result_callback' );
function degardc_services_payment_result_callback(){
    if(isset($_COOKIE['payres'])){
        $payres = json_decode(stripslashes($_COOKIE['payres']),true);
        $invoice_id = $payres['invoiceid'];
        $try_new = false;
        if(isset($payres['status']) && (($payres['status'] == 'succeed') || ($payres['status'] == 'failed'))){
            if($payres['status'] == 'succeed'){
                $status = 'succeed';
                if($payres['trynew']){
                    $domain = $payres['domain'];
                    $billingcycle = $payres['billingcycle'];
                    $try_new = $payres['trynew'];
                }
            }else{
                $status = 'failed';
            }
            ob_start();
            include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/front/order/payment-result-html.php';
            $html = ob_get_clean();
            return $html;
        }else{
            ?>
            <div class="degardc-container">
                <p>اینجا اطلاعاتی برای نمایش وجود ندارد</p>
            </div>
            <?php
        }
    }else{
        ?>
        <div class="degardc-container">
            <p>اینجا اطلاعاتی برای نمایش وجود ندارد</p>
        </div>
        <?php
    }
}



