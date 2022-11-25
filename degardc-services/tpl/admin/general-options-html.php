<div class="wrap" >
    <h2>degardc services general settings</h2>
    <div class="error" style="padding: 10px;">hint: if you don't know whats this leave here and don't change anything</div>
</div>
<form action="" method="post">
    <table class="form-table">

        <tbody>
            <fieldset>
                <legend>api settings</legend>
                <tr>
                    <th class="degardc-th"><label for="api_identifier">api identifier</label></th>
                    <td>
                        <input type="text" class="regular-text degardc-blur-input" name="api_identifier" id="api_identifier" value="<?php echo isset($degardc_services_options['api_identifier']) ? $degardc_services_options['api_identifier'] : '' ; ?>">
                    </td>
                    <th class="degardc-th"><label for="api_secret">api secret</label></th>
                    <td>
                        <input type="text" class="regular-text degardc-blur-input" name="api_secret" id="api_secret" value="<?php echo isset($degardc_services_options['api_secret']) ? $degardc_services_options['api_secret'] : '' ; ?>">
                    </td>

                </tr>
                <tr>
                    <th class="degardc-th"><label for="api_address">api address</label></th>
                    <td>
                        <input type="text" class="regular-text degardc-blur-input" name="api_address" id="api_address" placeholder="https://manage.example.com/includes/api.php" value="<?php echo isset($degardc_services_options['api_address']) ? $degardc_services_options['api_address'] : '' ; ?>">
                    </td>
                    <th class="degardc-th"><label for="campaign_subdomain">campaign subdomain</label></th>
                    <td>
                        <input type="text" class="regular-text degardc-blur-input" name="campaign_subdomain" id="campaign_subdomain" placeholder="example.com" value="<?php echo isset($degardc_services_options['campaign_subdomain']) ? $degardc_services_options['campaign_subdomain'] : '' ; ?>">
                    </td>
                </tr>
                <tr>
                    <th class="degardc-th"><label for="campaign_product_id">campaign product id</label></th>
                    <td>
                        <input type="number" class="regular-text" name="campaign_product_id" id="campaign_product_id" placeholder="insert id of campaign product" value="<?php echo isset($degardc_services_options['campaign_product_id']) ? $degardc_services_options['campaign_product_id'] : '' ; ?>">
                    </td>
                    <th class="degardc-th"><label for="website_builder_product_id">website builder product id</label></th>
                    <td>
                        <input type="number" class="regular-text" name="website_builder_product_id" id="website_builder_product_id" placeholder="insert id of website builder product" value="<?php echo isset($degardc_services_options['website_builder_product_id']) ? $degardc_services_options['website_builder_product_id'] : '' ; ?>">
                    </td>
                </tr>
            </fieldset>
        </tbody>
    </table>
    <hr>
    <table class="form-table">
        <tbody>
            <fieldset>
                <legend>choosing pages</legend>
                <tr>
                    <th><label for="campaign_buy_new_campaign_page_id">campaign buy new campaign page</label></th>
                    <td>
                        <select name="campaign_buy_new_campaign_page_id">
                            <?php foreach($site_pages as $site_page): ?>
                                <option <?php echo $degardc_services_options['campaign_buy_new_campaign_page_id'] == $site_page->ID ? 'selected' : '' ?> value="<?php echo $site_page->ID ?>"><?php echo $site_page->post_title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <th><label for="campaign_check_domain_page_id">campaign check domain page</label></th>
                    <td>
                        <select name="campaign_check_domain_page_id">
                            <?php foreach($site_pages as $site_page): ?>
                                <option <?php echo $degardc_services_options['campaign_check_domain_page_id'] == $site_page->ID ? 'selected' : '' ?> value="<?php echo $site_page->ID ?>"><?php echo $site_page->post_title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                </tr>

                <tr>

                    <th><label for="campaign_login_register_page_id">campaign login register page</label></th>
                    <td>
                        <select name="campaign_login_register_page_id">
                            <?php foreach($site_pages as $site_page): ?>
                                <option <?php echo $degardc_services_options['campaign_login_register_page_id'] == $site_page->ID ? 'selected' : '' ?> value="<?php echo $site_page->ID ?>"><?php echo $site_page->post_title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <th><label for="campaign_validation_page_id">campaign validation page</label></th>
                    <td>
                        <select name="campaign_validation_page_id">
                            <?php foreach($site_pages as $site_page): ?>
                                <option <?php echo $degardc_services_options['campaign_validation_page_id'] == $site_page->ID ? 'selected' : '' ?> value="<?php echo $site_page->ID ?>"><?php echo $site_page->post_title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                </tr>
                <tr>
                    <th><label for="campaign_checkout_page_id">campaign checkout page</label></th>
                    <td>
                        <select name="campaign_checkout_page_id">
                            <?php foreach($site_pages as $site_page): ?>
                                <option <?php echo $degardc_services_options['campaign_checkout_page_id'] == $site_page->ID ? 'selected' : '' ?> value="<?php echo $site_page->ID ?>"><?php echo $site_page->post_title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <th><label for="payment_result_page_id">payment result page</label></th>
                    <td>
                        <select name="payment_result_page_id">
                            <?php foreach($site_pages as $site_page): ?>
                                <option <?php echo $degardc_services_options['payment_result_page_id'] == $site_page->ID ? 'selected' : '' ?> value="<?php echo $site_page->ID ?>"><?php echo $site_page->post_title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                </tr>
            </fieldset>
        </tbody>
    <table>

    <hr>
    <table class="form-table">
        <tbody>
            <fieldset>
                <legend>faraz sms api</legend>
                <tr>
                    <th class="degardc-th"><label for="sms_api_username">sms username</label></th>
                    <td>
                        <input type="text" class="regular-text degardc-blur-input" name="sms_api_username" id="sms_api_username" placeholder="username taken from farz sms" value="<?php echo isset($degardc_services_options['sms_api_username']) ? $degardc_services_options['sms_api_username'] : '' ; ?>">
                    </td>
                    <th class="degardc-th"><label for="sms_api_password">sms password</label></th>
                    <td>
                        <input type="text" class="regular-text degardc-blur-input" name="sms_api_password" id="sms_api_password" placeholder="password taken from farz sms" value="<?php echo isset($degardc_services_options['sms_api_password']) ? $degardc_services_options['sms_api_password'] : '' ; ?>">
                    </td>
                </tr>
                <tr>
                    <th class="degardc-th"><label for="sms_api_from">sender number</label></th>
                    <td>
                        <input type="text" class="regular-text degardc-blur-input" name="sms_api_from" id="sms_api_from" placeholder="inter the number that is used to send sms" value="<?php echo isset($degardc_services_options['sms_api_from']) ? $degardc_services_options['sms_api_from'] : '' ; ?>">
                    </td>
                    <th class="degardc-th"><label for="sms_api_url">sms api url(not used in pattern)</label></th>
                    <td>
                        <input type="text" class="regular-text degardc-blur-input" name="sms_api_url" id="sms_api_url" placeholder="url that request have to send to it" value="<?php echo isset($degardc_services_options['sms_api_url']) ? $degardc_services_options['sms_api_url'] : '' ; ?>">
                    </td>
                </tr>
            </fieldset>
            <tr>
                <td>
                    <input type="submit" name="degardc_services_save_changes" id="degardc_services_save_changes" class="button button-primary" value="save changes">
                </td>
            </tr>
        </tbody>
    <table>

</form>