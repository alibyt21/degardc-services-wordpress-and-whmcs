<div class="degardc-container" id="degardc-campaign-checkout-container">
    <div class="degardc-main-content" id="degardc-campaign-checkout-main-content">
        <p class="degardc-progress-title">
            مرحله نهایی - بررسی نهایی و پرداخت
        </p>
        <div class="degardc-progress">
            <div class="degardc-progress-done" data-done="100">
                100%
            </div>
        </div>
        <p class="degardc-title">بررسی نهایی و پرداخت</p>
        <p>لطفا سفارش خود را برای پرداخت، بررسی نهایی کنید</p>







        <div class="row row--top-20">
            <div class="col-md-12">
                <div class="table-container">
                    <table class="table" style="margin-bottom: 0;">
                        <thead class="table__thead">
                        <tr>
                            <th class="table__th">توضیحات</th>
                            <th class="table__th">عملیات</th>
                            <th class="table__th">هزینه / دوره</th>
                        </tr>
                        </thead>
                        <tbody class="table__tbody">
                            <tr class="table-row table-row--chris">
                                <td data-column="توضیحات" class="table-row__td">
                                    <div class="table-row__info">
                                        <p class="table-row__name"><?php echo $order_domain; ?></p>
                                        <span class="table-row__small"><?php echo $order_product_name; ?></span>
                                    </div>
                                </td>
                                <td data-column="عملیات" class="table-row__td">
                                    <div class="table-row__edit">
                                        <a href="<?php echo get_permalink($degardc_services_options['campaign_buy_new_campaign_page_id']); ?>">
                                            <i class="fas fa-pencil-alt" style="vertical-align:middle;"></i>
                                            تغییر نام ربات یا مدت دوره
                                        </a>
                                    </div>
                                </td>
                                <td data-column="هزینه / دوره" class="table-row__td">
                                    <div class="">
                                        <p class="table-row__policy" id="degardc-order-total-price"><?php echo $order_product_price ; ?></p>
                                        <span class="table-row__small"><?php echo $currency_suffix; ?> / <?php echo $billingcycle_translate[$billingcycle]; ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-row table-row--chris degardc-hide" id="degardc-discount-details">
                                <td data-column="توضیحات" class="table-row__td">
                                    <div class="table-row__info">
                                        <p class="table-row__name" id="degardc-discount-code"></p>
                                        <span class="table-row__small">کوپن تخفیف</span>
                                    </div>
                                </td>
                                <td data-column="عملیات" class="table-row__td">
                                    <div class="table-row__delete" id="degardc-remove-discount-code">
                                        <a href="#">
                                            <i class="fas fa-trash-alt" style="vertical-align:middle;"></i>
                                        حذف کد تخفیف
                                        </a>
                                    </div>
                                </td>
                                <td data-column="تخفیف" class="table-row__td">
                                    <div class="">
                                        <p class="table-row__policy" id="degardc-discount-amount"></p>
                                        <span class="table-row__small">هزار تومان تخفیف</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="degardc-invoice-footer degardc-row">

            <div class="degardc-inline degardc-column">
                <div class="degardc-inline">
                    <input type="text" id="degardc-discount-code-input" placeholder="کد تخفیف">
                </div>

                <div class="degardc-inline">
                    <button id="degardc-apply-discount">اعمال کد تخفیف</button>
                </div>
            </div>


            <div class="degardc-inline degardc-column degardc-invoice-total" id="degardc-total-price-div">
                <span class="degardc-inline">مبلغ قابل پرداخت :</span>
                <var class="degardc-inline" id="degardc-total-price"><?php echo $order_product_price ; ?></var>
                <span class="degardc-inline" id="degardc-total-price-suffix"> هزار تومان</span>
            </div>

        </div>


        <form id="degardc-campaign-checkout-form">
            <div class="section" style="margin: 30px 0">
                <label class="degardc-form-checkbox-label">
                    <input name="degardc-policy-checkbox" id="degardc-policy-checkbox" class="degardc-form-checkbox-field" type="checkbox" value="1" required="required" oninvalid="this.setCustomValidity('برای ادامه فرآیند خرید، لازم است که شرایط و قوانین خرید سیستم مدیریت کمپین دگردیسی را مطالعه کرده و بپذیرید')" oninput="setCustomValidity('')">
                    <i class="degardc-form-checkbox-button"></i>
                    <span>
                    <p>
                        <a href="#" target="_blank">
                            شرایط و قوانین خرید
                        </a>
                        سیستم مدیریت کمپین دگردیسی را مطالعه کرده و می پذیرم
                    </p>

                </span>
                </label>
            </div>


            <div class="degardc-section" style="text-align: center">
                <button class="degardc-button"><span>پرداخت سفارش</span></button>
            </div>
        </form>








        <div class="degardc-hide" id="degardc-billingcycle"><?php echo $billingcycle; ?></div>
        <div class="degardc-hide" id="degardc-pid"><?php echo $pid; ?></div>
        <div class="degardc-hide" id="degardc-order-domain"><?php echo $order_domain; ?></div>
        <div class="degardc-hide" id="degardc-order-paymentmethod"><?php echo $order_paymentmethod; ?></div>
        <div class="degardc-hide" id="degardc-absolute-total-price"><?php echo $order_product_price; ?></div>


        <div class="degardc-notice" id="degardc-checkout-notice">
            <p class="degardc-message" id="degardc-checkout-message"></p>
        </div>

        <?php wp_nonce_field( 'degardc_nonce' ); ?>

    </div>
</div>