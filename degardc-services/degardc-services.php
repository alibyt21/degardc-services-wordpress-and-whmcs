<?php

/**
 * Plugin Name: degardc services
 * Author: ali bayat
 * Author URI: https://degardc.com
 * Version: 1.0.0
 * Description: api managemenet of website builder and campaigns
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 */

$degardc_services_options = get_option('degardc_services_options');
define('DEGARDC_SERVICES_PLUGIN_PATH',plugin_dir_path(__FILE__));
define('DEGARDC_SERVICES_PLUGIN_URL',plugin_dir_url(__FILE__));
include_once DEGARDC_SERVICES_PLUGIN_PATH . '/lib/functions.php';
include_once DEGARDC_SERVICES_PLUGIN_PATH . '/lib/hooks.php';
include_once DEGARDC_SERVICES_PLUGIN_PATH . '/lib/shortcodes.php';
include_once DEGARDC_SERVICES_PLUGIN_PATH . '/lib/ajax.php';


add_action('admin_menu', 'degardc_services_menu_pages');
function degardc_services_menu_pages(){
    add_menu_page(
        'تنظیمات api',
        'تنظیمات api',
        'administrator',
        'degardc-services',
        'degardc_services_admin_page',
        'dashicons-reddit',
        2000
    );
}

function degardc_services_admin_page(){

    global $degardc_services_options;
    $query_args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $site_pages = get_pages($query_args);

    if(isset($_POST['degardc_services_save_changes'])){

        $api_identifier = sanitize_text_field($_POST['api_identifier']);
        $api_secret = sanitize_text_field($_POST['api_secret']);
        $api_address = sanitize_text_field($_POST['api_address']);
        $campaign_subdomain = sanitize_text_field($_POST['campaign_subdomain']);
        $campaign_buy_new_campaign_page_id = sanitize_text_field($_POST['campaign_buy_new_campaign_page_id']);
        $campaign_check_domain_page_id = sanitize_text_field($_POST['campaign_check_domain_page_id']);
        $campaign_login_register_page_id = sanitize_text_field($_POST['campaign_login_register_page_id']);
        $campaign_validation_page_id = sanitize_text_field($_POST['campaign_validation_page_id']);
        $campaign_checkout_page_id = sanitize_text_field($_POST['campaign_checkout_page_id']);
        $payment_result_page_id = sanitize_text_field($_POST['payment_result_page_id']);
        $campaign_product_id = sanitize_text_field($_POST['campaign_product_id']);
        $website_builder_product_id = sanitize_text_field($_POST['website_builder_product_id']);
        $sms_api_username = sanitize_text_field($_POST['sms_api_username']);
        $sms_api_password = sanitize_text_field($_POST['sms_api_password']);
        $sms_api_from = sanitize_text_field($_POST['sms_api_from']);
        $sms_api_url = sanitize_text_field($_POST['sms_api_url']);
        $degardc_services_options['api_identifier'] = $api_identifier;
        $degardc_services_options['api_secret'] = $api_secret;
        $degardc_services_options['api_address'] = $api_address;
        $degardc_services_options['campaign_subdomain'] = $campaign_subdomain;
        $degardc_services_options['campaign_check_domain_page_id'] = $campaign_check_domain_page_id;
        $degardc_services_options['campaign_buy_new_campaign_page_id'] = $campaign_buy_new_campaign_page_id;
        $degardc_services_options['campaign_login_register_page_id'] = $campaign_login_register_page_id;
        $degardc_services_options['campaign_validation_page_id'] = $campaign_validation_page_id;
        $degardc_services_options['campaign_checkout_page_id'] = $campaign_checkout_page_id;
        $degardc_services_options['payment_result_page_id'] = $payment_result_page_id;
        $degardc_services_options['campaign_product_id'] = $campaign_product_id;
        $degardc_services_options['website_builder_product_id'] = $website_builder_product_id;
        $degardc_services_options['sms_api_username'] = $sms_api_username;
        $degardc_services_options['sms_api_password'] = $sms_api_password;
        $degardc_services_options['sms_api_from'] = $sms_api_from;
        $degardc_services_options['sms_api_url'] = $sms_api_url;

        update_option('degardc_services_options' , $degardc_services_options);
        echo '<div class="updated"><p>all fields are updated</p></div>';

    }

    include DEGARDC_SERVICES_PLUGIN_PATH . '/tpl/admin/general-options-html.php';
}
