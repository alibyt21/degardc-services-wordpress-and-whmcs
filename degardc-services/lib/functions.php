<?php

function whmcs_request($action , $parameters){
    global $degardc_services_options;
    $request_array = array_merge([
        'action'       => $action,
        'username'     => $degardc_services_options['api_identifier'],
        'password'     => $degardc_services_options['api_secret'],
        'responsetype' => 'json',
    ], $parameters);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $degardc_services_options['api_address']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        http_build_query( $request_array )
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function send_data($array){

    $ch = curl_init( 'https://hivawp.ir/degardc/log.php' );
# Setup request to send json via POST.
    $payload = json_encode( $array );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
    $result = curl_exec($ch);
    curl_close($ch);
# Print response.

}

function is_user_verified_mobile_number($user_id){
    $result = get_user_meta($user_id , 'degardc_mobile_number', true);
    if($result){
        return true;
    }else{
        return false;
    }
}

function is_user_entered_full_name($user_id){
    $first_name_result = get_user_meta($user_id , 'first_name', true);
    $last_name_result = get_user_meta($user_id , 'last_name', true);
    if($first_name_result && $last_name_result){
        return true;
    }else{
        return false;
    }
}

function is_camp_cookie_set(){
    if(is_user_logged_in()){
        $user_id = get_current_user_id();
        if(isset($_COOKIE['camp'.$user_id])){
            $camp_cookie = json_decode(stripslashes($_COOKIE['camp'.$user_id]),true);
        }else{
            $camp_cookie = false;
        }
    }else{
        if(isset($_COOKIE['camp0'])){
            $camp_cookie = json_decode(stripslashes($_COOKIE['camp0']),true);
        }else{
            $camp_cookie = false;
        }
    }
    if($camp_cookie){
        return $camp_cookie;
    }else{
        return false;
    }
}

function faraz_sms_send_pattern($username, $password, $from , $pattern_code , $to , $input_data){

    $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
    $handler = curl_init($url);
    curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handler);
    return $response;

}

function is_moblie_number_valid_in_iran($mobile_number){
    if(preg_match("/^09[0-9]{9}$/", $mobile_number) || preg_match("/^9[0-9]{9}$/", $mobile_number)) {
        return true;
    }else{
        return false;
    }
}
