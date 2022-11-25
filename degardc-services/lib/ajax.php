<?php

function degardc_services_campaign_check_domain_ajax(){

    check_ajax_referer('degardc_nonce','security');
    global $degardc_services_options;
    $checking_domain = sanitize_text_field($_POST['checking_domain']);
    $billing_cycle = sanitize_text_field($_POST['billingcycle']);
    $domain = $checking_domain . '.' . $degardc_services_options['campaign_subdomain'];

    while($error && $try_num<3) {
        $encode_specific_client_product = whmcs_request('GetClientsProducts', [
            'domain' => $domain
        ]);
        $specific_client_product = json_decode($encode_specific_client_product);
        $specific_client_product_result = $specific_client_product->result;
        if (strtolower($specific_client_product_result) == 'success') {
            $error = false;
        } else {
            usleep( 200 * 1000 );
            $try_num++;
        }
    }

    if(!$error){
        $totalresults = $specific_client_product->totalresults;
        if ( intval($totalresults) > 0 ){
            $product = $specific_client_product->products->product;
            $order_id = $product[0]->orderid;

            while($error && $try_num<3) {
                $encode_specific_client_order = whmcs_request('GetOrders', [
                    'id' => $order_id
                ]);
                $specific_client_order = json_decode($encode_specific_client_order);
                $specific_client_order_result = $specific_client_order->result;
                if (strtolower($specific_client_order_result) == 'success') {
                    $error = false;
                } else {
                    usleep( 200 * 1000 );
                    $try_num++;
                }
            }

            if(!$error){
                $order = $specific_client_order->orders->order;
                $paymentstatus = $order[0]->paymentstatus;
                if(strtolower($paymentstatus) == 'unpaid'){
                    whmcs_request('CancelOrder', [
                        'orderid' => $order_id
                    ]);
                    whmcs_request('DeleteOrder', [
                        'orderid' => $order_id
                    ]);
                    if(is_user_logged_in()){
                        $user_id = get_current_user_id();
                        if(is_user_verified_mobile_number($user_id) && is_user_entered_full_name($user_id)){
                            $redirect_path = get_permalink($degardc_services_options['campaign_checkout_page_id']);
                        }else{
                            $redirect_path = get_permalink($degardc_services_options['campaign_validation_page_id']);
                        }
                    }else{
                        $redirect_path = get_permalink($degardc_services_options['campaign_login_register_page_id']);
                    }
                    $result = array(
                        'error' => false,
                        'redirect' => $redirect_path,
                    );
                    $camp_cookie['domain'] = $domain;
                    $camp_cookie['billingcycle'] = $billing_cycle;
                    if(is_user_logged_in()){
                        setcookie('camp'.$user_id , json_encode($camp_cookie) , time()+(30*86400) , '/');
                    }else{
                        setcookie('camp0' , json_encode($camp_cookie) , time()+(30*86400) , '/');
                    }
                    wp_send_json($result);
                }else{
                    $result = array(
                        'error' => true,
                    );
                    wp_send_json($result);
                }
            }else{
                $result = array(
                    'error' => true,
                );
                wp_send_json($result);
            }
        }else{
            //success
            if(is_user_logged_in()){
                $user_id = get_current_user_id();
                if(is_user_verified_mobile_number($user_id) && is_user_entered_full_name($user_id)){
                    $redirect_path = get_permalink($degardc_services_options['campaign_checkout_page_id']);
                }else{
                    $redirect_path = get_permalink($degardc_services_options['campaign_validation_page_id']);
                }
            }else{
                $redirect_path = get_permalink($degardc_services_options['campaign_login_register_page_id']);
            }
            $result = array(
                'error' => false,
                'redirect' => $redirect_path,
            );
            $camp_cookie['domain'] = $domain;
            $camp_cookie['billingcycle'] = $billing_cycle;
            if(is_user_logged_in()){
                setcookie('camp'.$user_id , json_encode($camp_cookie) , time()+(30*86400) , '/');
            }else{
                setcookie('camp0' , json_encode($camp_cookie) , time()+(30*86400) , '/');
            }
            wp_send_json($result);
        }
    }else{
        $result = array(
            'error' => true,
        );
        wp_send_json($result);
    }
    wp_die();
}
add_action('wp_ajax_degardc_services_campaign_check_domain_ajax', 'degardc_services_campaign_check_domain_ajax');
add_action('wp_ajax_nopriv_degardc_services_campaign_check_domain_ajax', 'degardc_services_campaign_check_domain_ajax');




function degardc_services_campaign_login_register_ajax(){

    check_ajax_referer('degardc_nonce','security');
    global $degardc_services_options;
    $email = sanitize_text_field($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    if ( empty($email) || empty($password) ){
        $result = array(
            'error' => true,
            'message' => 'لطفا فرم را به صورت کامل تکمیل کنید'
        );
        wp_send_json($result);
    }
    if ( !filter_var( $email , FILTER_VALIDATE_EMAIL) ){
        $result = array(
            'error' => true,
            'message' => 'لطفا ایمیل خود را به صورت صحیح وارد کنید'
        );
        wp_send_json($result);
    }
    if ( email_exists($email) ){
        //it means that email is already registered in this site and we have to login

        $creds = array(
            'user_login'    => $email,
            'user_password' => $password,
            'remember'      => true
        );
        $wp_signon_result = wp_signon( $creds, false );
        if ( is_wp_error( $wp_signon_result ) ) {
            $result = array(
                'error' => true,
                'message' => $wp_signon_result->get_error_message(),
            );
            wp_send_json($result);
        }else{
            $user_id = $wp_signon_result->ID;
            $camp_cookie = is_camp_cookie_set();
            setcookie('camp'.$user_id , json_encode($camp_cookie) , time()+(30*86400) , '/');
            if(is_user_verified_mobile_number($user_id) && is_user_entered_full_name($user_id)){
                $redirect_path = get_permalink($degardc_services_options['campaign_checkout_page_id']);
            }else{
                $redirect_path = get_permalink($degardc_services_options['campaign_validation_page_id']);
            }
            $result = array(
                'error' => false,
                'message' => 'شما با موفقیت وارد سایت شدید',
                'redirect' => $redirect_path,
            );
            wp_send_json($result);
        }
    }else{
        //it means that email is new user and we have to register the user

        $user_login = substr($email, 0, strrpos($email, '@'));
        $creds = array(
            'user_login' => $user_login,
            'user_email' => $email,
            'user_pass'  => $password,
            'show_admin_bar_front' => 'false',
        );

        //in success return new user id
        $wp_insert_user_result = wp_insert_user($creds);

        if( is_wp_error($wp_insert_user_result) ){
            $result = array(
                'error' => true,
                'message' => $wp_insert_user_result->get_error_message(),
            );
            wp_send_json($result);
        }else{
            $creds = array(
                'user_login'    => $email,
                'user_password' => $password,
                'remember'      => true
            );
            $wp_signon_result = wp_signon( $creds, false );
            if( is_wp_error($wp_signon_result) ){
                $result = array(
                    'error' => true,
                    'message' =>  'حساب کاربری شما با موفقیت ایجاد شد، اما در ورود شما به سایت مشکلی رخ داده است، لطفا به پشتیبانی اطلاع دهید',
                );
                wp_send_json($result);
            }else{
                $user_id = $wp_signon_result->ID;
                $camp_cookie = is_camp_cookie_set();
                setcookie('camp'.$user_id , json_encode($camp_cookie) , time()+(30*86400) , '/');
                if(is_user_verified_mobile_number($user_id) && is_user_entered_full_name($user_id)){
                    $redirect_path = get_permalink($degardc_services_options['campaign_checkout_page_id']);
                }else{
                    $redirect_path = get_permalink($degardc_services_options['campaign_validation_page_id']);
                }
                $result = array(
                    'error' => false,
                    'message' => 'حساب کاربری شما با موفقیت ایجاد شد',
                    'redirect' => $redirect_path,
                );
                wp_send_json($result);
            }
        }
    }
    die();
}
add_action('wp_ajax_degardc_services_campaign_login_register_ajax', 'degardc_services_campaign_login_register_ajax');
add_action('wp_ajax_nopriv_degardc_services_campaign_login_register_ajax', 'degardc_services_campaign_login_register_ajax');




function degardc_services_campaign_send_validation_code_ajax(){

    check_ajax_referer('degardc_nonce','security');
    global $degardc_services_options;
    $user_id = get_current_user_id();
    $mobile_number = sanitize_text_field($_POST['mobilenumber']);

    if ( empty($mobile_number) ){
        $result = array(
            'error' => true,
            'message' =>  'لطفا شماره تلفن همراه خود را به صورت کامل وارد کنید',
        );
        wp_send_json($result);
    }
    if( is_moblie_number_valid_in_iran($mobile_number) ){


        $args = array(
            'meta_query' => array(
                array(
                    'key' => 'degardc_mobile_number',
                    'value' => $mobile_number,
                    'compare' => '='
                )
            )
        );
        $user_with_same_mobile_number = get_users($args);


        if($user_with_same_mobile_number){
            $result = array(
                'error' => true,
                'message' =>  'یک حساب کاربری فعال با شماره وارد شده در سیستم وجود دارد و این شماره قابل استفاده مجدد نیست',
            );
            wp_send_json($result);
        }


        $last_user_try = get_user_meta($user_id , 'degardc_validation_code');
        if( (empty($last_user_try)) || ($last_user_try[0]['number'] != $mobile_number) || ($last_user_try[0]['until']<time()) ){

            $random_number = rand(10000,99999);

            $response = faraz_sms_send_pattern( $degardc_services_options['sms_api_username'] , $degardc_services_options['sms_api_password'] , $degardc_services_options['sms_api_from'] , 'qncer227zn' , array($mobile_number) , array("verification-code" => $random_number));
            // return int in success

            if(is_numeric($response)){
                $degardc_validation_code['number'] = $mobile_number;
                $degardc_validation_code['code'] = $random_number;
                $degardc_validation_code['until'] = time() + 120;
                update_user_meta($user_id , 'degardc_validation_code', $degardc_validation_code);
                $result = array(
                    'error' => false,
                    'message' =>  "پیامک فعال سازی با موفقیت به شماره <strong>$mobile_number</strong> ارسال شد",
                );
                wp_send_json($result);
            }else{
                $result = array(
                    'error' => false,
                    'message' => 'در ارسال پیامک خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید',
                );
                wp_send_json($result);
            }
        }else{
            $result = array(
                'error' => true,
                'message' => 'لطفا صبر کنید، درخواست قبلی شما هنوز معتبر است',
            );
            wp_send_json($result);
        }
    }else{
        $result = array(
            'error' => true,
            'message' => 'شماره تلفن همراه وارد شده نامعتبر است',
        );
        wp_send_json($result);
    }
    die();
}
add_action('wp_ajax_degardc_services_campaign_send_validation_code_ajax', 'degardc_services_campaign_send_validation_code_ajax');
add_action('wp_ajax_nopriv_degardc_services_campaign_send_validation_code_ajax', 'degardc_services_campaign_send_validation_code_ajax');






function degardc_services_campaign_verify_code_ajax(){

    check_ajax_referer('degardc_nonce','security');
    global $degardc_services_options;
    $user_id = get_current_user_id();
    $mobile_number = sanitize_text_field($_POST['mobilenumber']);
    $user_verification_code = sanitize_text_field($_POST['verificationcode']);
    $first_name = sanitize_text_field($_POST['firstname']);
    $last_name = sanitize_text_field($_POST['lastname']);

    if ( empty($user_verification_code) ){
        $result = array(
            'error' => true,
            'message' =>  'لطفا کد ارسال شده را به صورت کامل وارد کنید',
        );
        wp_send_json($result);
    }
    $last_user_try = get_user_meta($user_id , 'degardc_validation_code');
    $system_verification_code = $last_user_try[0]['code'];
    if( $system_verification_code != $user_verification_code){
        $result = array(
            'error' => true,
            'message' =>  'کد وارد شده اشتباه است، لطفا مجددا تلاش کنید',
        );
        wp_send_json($result);
    }else{
        if($mobile_number != $last_user_try[0]['number']){
            $result = array(
                'error' => true,
                'message' =>  'شماره همراه وارد شده نامعتبر است، در صورت نیاز به پشتیبانی اطلاع دهید',
            );
            wp_send_json($result);
        }else{
            if(!update_user_meta($user_id , 'degardc_mobile_number', $mobile_number)){
                $result = array(
                    'error' => true,
                    'message' =>  'در ذخیره سازی شماره همراه شما خطایی رخ داده است، لطفا چند دقیقه بعد مجددا تلاش کنید',
                );
                wp_send_json($result);
            }else{
                delete_user_meta($user_id , 'degardc_validation_code');
                if(!empty($first_name) && !empty($last_name)){
                    wp_update_user(
                        array(
                            'ID' => $user_id, // this is the ID of the user you want to update.
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                        )
                    );
                }
                $redirect_path = get_permalink($degardc_services_options['campaign_checkout_page_id']);
                $result = array(
                    'error' => false,
                    'message' =>  'شماره شما با موفقیت تایید شد',
                    'redirect' => $redirect_path,
                );
                wp_send_json($result);
            }
        }
    }
}
add_action('wp_ajax_degardc_services_campaign_verify_code_ajax', 'degardc_services_campaign_verify_code_ajax');
add_action('wp_ajax_nopriv_degardc_services_campaign_verify_code_ajax', 'degardc_services_campaign_verify_code_ajax');






function degardc_services_campaign_add_fullname_ajax(){

    check_ajax_referer('degardc_nonce','security');
    global $degardc_services_options;
    $user_id = get_current_user_id();
    $first_name = sanitize_text_field($_POST['firstname']);
    $last_name = sanitize_text_field($_POST['lastname']);

    if ( empty($first_name) || empty($last_name) ){
        $result = array(
            'error' => true,
            'message' =>  'لطفا نام و نام خانوادگی خود را به صورت کامل وارد کنید',
        );
        wp_send_json($result);
    }
    $update_user_meta_result = wp_update_user(
        array(
            'ID' => $user_id, // this is the ID of the user you want to update.
            'first_name' => $first_name,
            'last_name' => $last_name,
        )
    );
    if(is_wp_error($update_user_meta_result)){
        $result = array(
            'error' => true,
            'message' =>  'در ذخیره سازی مشخصات شما خطایی رخ داده است، لطفا چند دقیقه بعد مجددا تلاش کنید',
        );
        wp_send_json($result);
    }else{
        $redirect_path = get_permalink($degardc_services_options['campaign_checkout_page_id']);
        $result = array(
            'error' => false,
            'message' =>  'مشخصات شما با موفقیت ذخیره شد',
            'redirect' => $redirect_path,
        );
        wp_send_json($result);
    }
}
add_action('wp_ajax_degardc_services_campaign_add_fullname_ajax', 'degardc_services_campaign_add_fullname_ajax');
add_action('wp_ajax_nopriv_degardc_services_campaign_add_fullname_ajax', 'degardc_services_campaign_add_fullname_ajax');







function degardc_services_check_discount_code_ajax(){

    check_ajax_referer('degardc_nonce','security');
    $pid = sanitize_text_field($_POST['pid']);
    $discount_code = sanitize_text_field($_POST['discountcode']);
    $billingcycle = sanitize_text_field($_POST['billingcycle']);
    $total_price = sanitize_text_field($_POST['totalprice']);
    if(!empty($discount_code)){

        $error = true;
        $try_num = 1;
        while($error && $try_num<3){
            $encode_promotions = whmcs_request('GetPromotions', [
                'code' => $discount_code
            ]);
            $promotions = json_decode($encode_promotions);
            $result = $promotions->result;
            if(strtolower($result) == 'success'){
                $error = false;
            } else {
                usleep( 200 * 1000 );
                $try_num ++;
            }
        }

        if(!$error){
            $totalresults = $promotions->totalresults;
            if($totalresults > 0){
                $promotion = $promotions->promotions->promotion[0];
                $promotion_applies_to_product_id = $promotion->appliesto;
                $is_useable_for_pid = strpos($promotion_applies_to_product_id , $pid);
                if( is_int($is_useable_for_pid) ){
                    $promotion_cycles = $promotion->cycles;
                    $is_useable_for_billingcycle = strpos(strtolower($promotion_cycles) , $billingcycle);
                    if( is_int($is_useable_for_billingcycle) ){
                        $promotion_expiration_date = $promotion->expirationdate;
                        if( (strtotime($promotion_expiration_date) < 0) || (strtotime($promotion_expiration_date) > time()) ){
                            $promotion_uses = $promotion->uses;
                            $promotion_max_uses = $promotion->maxuses;
                            if( ($promotion_uses <= $promotion_max_uses) || ($promotion_max_uses == 0) ){
                                $promotion_type = $promotion->type;
                                $promotion_value = $promotion->value;
                                //taghsim be hezarha bekhater hazf 3 ta sefr toomane
                                switch($promotion_type) {
                                    case 'Percentage':
                                        $discount = round((($total_price * $promotion_value)/100),3);
                                        $new_total_price = round(($total_price - $discount),3);
                                        break;
                                    case 'Fixed Amount':
                                        $discount = round(($promotion_value/1000),3);
                                        $new_total_price = ($total_price - $discount)>0?$total_price - $discount:0;
                                        $new_total_price = round($new_total_price,3);
                                        break;
                                    case 'Price Override':
                                        $discount = round(($total_price - ($promotion_value/1000)),3);
                                        $new_total_price = round(($promotion_value/1000),3);
                                        break;
                                }
                                $result = array(
                                    'error' => false,
                                    'message' =>  'کد تخفیف اعمال شد',
                                    'newtotalprice' => $new_total_price,
                                    'discount' => $discount
                                );
                                wp_send_json($result);
                            }else{
                                $result = array(
                                    'error' => true,
                                    'message' =>  'ظرفیت این کد تخفیف به اتمام رسیده است و دیگر قابل استفاده نیست',
                                );
                                wp_send_json($result);
                            }

                        }else{
                            $result = array(
                                'error' => true,
                                'message' =>  'این کد تخفیف منقضی شده است',
                            );
                            wp_send_json($result);
                        }
                    }else{
                        $result = array(
                            'error' => true,
                            'message' =>  'این کد تخفیف برای دوره انتخابی شما قابل استفاده نیست',
                        );
                        wp_send_json($result);
                    }
                }else{
                    $result = array(
                        'error' => true,
                        'message' =>  'این کد تخفیف برای محصول انتخابی شما قابل استفاده نیست',
                    );
                    wp_send_json($result);
                }
            }else{
                $result = array(
                    'error' => true,
                    'message' =>  'کد تخفیف معتبر نیست',
                );
                wp_send_json($result);
            }
        }else{
            $result = array(
                'error' => true,
                'message' =>  'در ارتباط با سرور خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید',
            );
            wp_send_json($result);
        }
    }else{
        $result = array(
            'error' => true,
            'message' =>  'لطفا یک کد تخفیف معتبر وارد کنید',
        );
        wp_send_json($result);
    }
}
add_action('wp_ajax_degardc_services_check_discount_code_ajax', 'degardc_services_check_discount_code_ajax');
add_action('wp_ajax_nopriv_degardc_services_check_discount_code_ajax', 'degardc_services_check_discount_code_ajax');




function degardc_services_pay_invoice_ajax(){

    check_ajax_referer('degardc_nonce','security');
    global $degardc_services_options;
    $client_id = sanitize_text_field($_POST['clientid']);
    $invoice_id = sanitize_text_field($_POST['invoiceid']);
    $payment_method = sanitize_text_field($_POST['paymentmethod']);
    $api_address = $degardc_services_options['api_address'];
    $whmcs_home_url = substr($api_address, 0, strrpos($api_address, 'includes'));
    $destination = $whmcs_home_url . 'clientarea.php';
    $sso_redirect_path = 'modules/addons/degardc_services_whmcs/degardc-gate.php?action=pay&invoice_id='. $invoice_id . '&client_id=' . $client_id . '&payment_method=' . $payment_method . '&destination=' . $destination;

    $error = true;
    $try_num = 1;
    while($error && $try_num<3){
        $encode_sso_token = whmcs_request('CreateSsoToken', [
            'client_id' => $client_id,
            'destination' => 'sso:custom_redirect',
            "sso_redirect_path" => $sso_redirect_path,
        ]);
        $sso_token = json_decode($encode_sso_token);
        $sso_token_result = $sso_token->result;
        if(strtolower($sso_token_result) == 'success'){
            $error = false;
        } else {
            usleep( 200 * 1000 );
            $try_num ++;
        }
    }

    if(!$error){
        $redirect_url = $sso_token->redirect_url;
        $result = array(
            'error' => false,
            'redirect' =>  $redirect_url,
        );
        wp_send_json($result);
    }else{
        $result = array(
            'error' => true,
            'message' =>  'در ارتباط با سرور خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید',
        );
        wp_send_json($result);
    }

}
add_action('wp_ajax_degardc_services_pay_invoice_ajax', 'degardc_services_pay_invoice_ajax');
add_action('wp_ajax_nopriv_degardc_services_pay_invoice_ajax', 'degardc_services_pay_invoice_ajax');




function degardc_services_add_order_and_pay_invoice_ajax(){

    check_ajax_referer('degardc_nonce','security');
    global $degardc_services_options;
    $pid = sanitize_text_field($_POST['pid']);
    $billingcycle = sanitize_text_field($_POST['billingcycle']);
    $order_domain = sanitize_text_field($_POST['domain']);
    $order_paymentmethod = sanitize_text_field($_POST['paymentmethod']);
    $promotion_code = sanitize_text_field($_POST['promotioncode']);
    $policy_checkbox = sanitize_text_field($_POST['policycheckbox']);
    $current_user = wp_get_current_user();
    $user_email = $current_user->user_email;
    $wp_user_id = get_current_user_id();

    if($policy_checkbox == 0){
        $result = array(
            'error' => true,
            'message' =>  'برای ادامه فرآیند خرید، لازم است که شرایط و قوانین خرید سیستم مدیریت کمپین دگردیسی را مطالعه کرده و بپذیرید',
        );
        wp_send_json($result);
    }

    $error = true;
    $try_num = 1;
    while($error && $try_num<3){
        $encode_client_details = whmcs_request('GetClientsDetails', [
            'email' => $user_email
        ]);
        $client_details = json_decode($encode_client_details);
        $client_details_result = $client_details->result;
        if(strtolower($client_details_result) == 'success'){
            $error = false;
        } else {
            usleep( 200 * 1000 );
            $try_num ++;
        }
    }

    if ($client_details_result == 'error'){
        //it means some error has happened
        $message = $client_details->message;
        if (strtolower($message) == 'client not found'){
            // it means there is no client with requested email address and we have to create new client in whmcs
            $first_name = get_user_meta($wp_user_id , 'first_name' , true);
            $last_name = get_user_meta($wp_user_id , 'last_name' , true);
            $mobile_number = get_user_meta($wp_user_id , 'degardc_mobile_number' , true);

            $error = true;
            $try_num = 1;
            while($error && $try_num<3){
                $encode_add_client_result = whmcs_request('AddClient', [
                    'firstname' => $first_name,
                    'lastname' => $last_name,
                    'email' => $user_email,
                    'address1' => 'unknown',
                    'city' => 'unknown',
                    'state' => 'unknown',
                    'postcode' => 'unknown',
                    'country' => 'IR',
                    'phonenumber' => $mobile_number,
                    'password2' => $mobile_number.'@21A',
                ]);
                $add_client_result = json_decode($encode_add_client_result);
                $add_client_result_result = $add_client_result->result;
                if(strtolower($add_client_result_result) == 'success'){
                    $error = false;
                } else {
                    usleep( 200 * 1000 );
                    $try_num ++;
                }
            }

            if(!$error){
                $whmcs_client_id = $add_client_result->clientid;
            }else{
                $result = array(
                    'error' => true,
                    'message' =>  'در ارتباط با سرور خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید',
                );
                wp_send_json($result);
            }
        }
        //this place we can insert new reaction to different condition by message
    }else {
        //it means there is no error and client already exists in whmcs
        $whmcs_client_id = $client_details->client_id;
    }

    $error = true;
    $try_num = 1;
    while($error && $try_num<3){
        $encode_specific_client_product = whmcs_request('GetClientsProducts', [
            'domain' => $order_domain
        ]);
        $specific_client_product = json_decode($encode_specific_client_product);
        $specific_client_product_result = $specific_client_product->result;
        if(strtolower($specific_client_product_result) == 'success'){
            $error = false;
        } else {
            usleep( 200 * 1000 );
            $try_num ++;
        }
    }

    if(!$error) {
        $totalresults = $specific_client_product->totalresults;
        if (intval($totalresults) > 0) {
            $product = $specific_client_product->products->product;
            $order_id = $product[0]->orderid;

            $error = true;
            $try_num = 1;
            while($error && $try_num<3){
                $encode_specific_client_order = whmcs_request('GetOrders', [
                    'id' => $order_id
                ]);
                $specific_client_order = json_decode($encode_specific_client_order);
                $specific_client_order_result = $specific_client_order->result;
                if(strtolower($specific_client_order_result) == 'success'){
                    $error = false;
                } else {
                    usleep( 200 * 1000 );
                    $try_num ++;
                }
            }

            if (!$error) {
                $order = $specific_client_order->orders->order;
                $paymentstatus = $order[0]->paymentstatus;
                if (strtolower($paymentstatus) == 'unpaid') {
                    whmcs_request('CancelOrder', [
                        'orderid' => $order_id
                    ]);
                    whmcs_request('DeleteOrder', [
                        'orderid' => $order_id
                    ]);
                }else{
                    $redirect_path = get_permalink($degardc_services_options['campaign_check_domain_page_id']);
                    $result = array(
                        'error' => true,
                        'message' =>  'آیدی انتخاب شده قبلا ثبت شده است، لطفا یک آیدی دیگر برای ربات خود انتخاب کنید',
                        'redirect' => $redirect_path
                    );
                    wp_send_json($result);
                }
            }else{
                $result = array(
                    'error' => true,
                    'message' =>  'در ارتباط با سرور خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید',
                );
                wp_send_json($result);
            }
        }
    }

    $error = true;
    $try_num = 1;
    while($error && $try_num<3){
        $encode_add_order_result = whmcs_request('AddOrder', [
            'clientid' => $whmcs_client_id,
            'paymentmethod' => $order_paymentmethod,
            'pid' => $pid,
            'domain' => $order_domain,
            'billingcycle' => $billingcycle,
            'promocode' => $promotion_code,
        ]);
        $add_order_result = json_decode($encode_add_order_result);
        $add_order_result_result = $add_order_result->result;
        if(strtolower($add_order_result_result) == 'success'){
            $error = false;
        } else {
            usleep( 200 * 1000 );
            $try_num ++;
        }
    }

    if(!$error){
        $order_invoice_id = $add_order_result->invoiceid;
        $api_address = $degardc_services_options['api_address'];
        $whmcs_home_url = substr($api_address, 0, strrpos($api_address, 'includes'));
        $destination = $whmcs_home_url . 'clientarea.php';
        $sso_redirect_path = 'modules/addons/degardc_services_whmcs/degardc-gate.php?action=pay&invoice_id='. $order_invoice_id . '&client_id=' . $whmcs_client_id . '&payment_method=' . $order_paymentmethod . '&destination=' . $destination;


        $error = true;
        $try_num = 1;
        while($error && $try_num<3){
            $encode_sso_token = whmcs_request('CreateSsoToken', [
                'client_id' => $whmcs_client_id,
                'destination' => 'sso:custom_redirect',
                "sso_redirect_path" => $sso_redirect_path,
            ]);
            $sso_token = json_decode($encode_sso_token);
            $sso_token_result = $sso_token->result;
            if(strtolower($sso_token_result) == 'success'){
                $error = false;
            } else {
                usleep( 200 * 1000 );
                $try_num ++;
            }
        }

        if(!$error){
            $camp_cookie['domain'] = $order_domain;
            $camp_cookie['billingcycle'] = $billingcycle;
            $camp_cookie['invoiceid'] = $order_invoice_id;
            setcookie('camp'.$wp_user_id , json_encode($camp_cookie) , time()+(30*86400) , '/');
            $redirect_url = $sso_token->redirect_url;
            $result = array(
                'error' => false,
                'redirect' =>  $redirect_url,
            );
            wp_send_json($result);
        }else{
            $result = array(
                'error' => true,
                'message' =>  'در ارتباط با سرور خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید',
            );
            wp_send_json($result);
        }
    }else{
        $result = array(
            'error' => true,
            'message' =>  'در ارتباط با سرور خطایی رخ داده است، لطفا به پشتیبانی اطلاع دهید',
        );
        wp_send_json($result);
    }
}
add_action('wp_ajax_degardc_services_add_order_and_pay_invoice_ajax', 'degardc_services_add_order_and_pay_invoice_ajax');
add_action('wp_ajax_nopriv_degardc_services_add_order_and_pay_invoice_ajax', 'degardc_services_add_order_and_pay_invoice_ajax');
