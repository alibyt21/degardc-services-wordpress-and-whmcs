<?php
function degardc_services_whmcs_config() {
    $configarray = array(
    "name" => "degardc_services_whmcs",
    "description" => "افزونه مدیریت سرویس ها",
    "version" => "1.0.0",
    "author" => "ali bayat",
    "fields" => array(
        "wpsync" => array ("FriendlyName" => "آدرس برگه بازگشت از درگاه", "Type" => "text", "Size" => "25",
                              "Description" => "Textbox", "Placeholder" => "https://degardc.com/custom-thank-you-page", )
    ));
    return $configarray;
}



function degardc_services_whmcs_clientarea($vars)
{
}


function degardc_services_whmcs_output($vars)
{
}



function degardc_services_whmcs_activate()
{
}


function degardc_services_whmcs_deactivate()
{
}