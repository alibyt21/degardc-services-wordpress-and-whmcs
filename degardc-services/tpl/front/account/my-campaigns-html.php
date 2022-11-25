<div class="degardc-container">

    <div class="degardc-row">
        <div class="degardc-column degardc-panel-card">
            <a href="?action=campaign-services">
                <div class="degardc-panel-big-number blue degardc-right">
                    <p class="degardc-right">
                        <?php echo $total_campaigns; ?>
                    </p>
                    <p class="degardc-clear degardc-panel-sub-heading">
                        تعداد کمپین‌های فعال و غیرفعال
                    </p>
                </div>
                <div class="degardc-panel-img degardc-left">
                    <div class="degardc-img-circle blue">
                        <img src="<?php echo DEGARDC_SERVICES_PLUGIN_URL.'assets/img/campaigns.png' ?>" alt="">
                    </div>
                </div>
                <div class="degardc-clear">
                    <hr class="degardc-hr">
                    <div class="degardc-panel-see-all">
                        مشاهده همه کمپین‌ها
                        <i aria-hidden="true" class="fas fa-reply" style="margin-right: 5px"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="degardc-column degardc-panel-card">
            <a href="?action=campaign-invoices">
                <div class="degardc-panel-big-number yellow degardc-right">
                    <p class="degardc-right">
                        <?php echo number_format($total_unpaid/1000) ?>
                    </p>
                    <p style="font-size: 0.35em;margin-top: 25px;">هزار تومان</p>
                    <p class="degardc-clear degardc-panel-sub-heading">
                        مجموع صورتحساب‌های پرداخت نشده
                    </p>
                </div>
                <div class="degardc-panel-img degardc-left">
                    <div class="degardc-img-circle yellow">
                        <img src="<?php echo DEGARDC_SERVICES_PLUGIN_URL.'assets/img/invoices.png' ?>" alt="">
                    </div>
                </div>

                <div class="degardc-clear">
                    <hr class="degardc-hr">
                    <div class="degardc-panel-see-all">
                        مشاهده همه صورتحساب‌ها
                        <i aria-hidden="true" class="fas fa-reply" style="margin-right: 5px"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>


    <div class="degardc-notice">
        <p class="degardc-message"></p>
    </div>

</div>