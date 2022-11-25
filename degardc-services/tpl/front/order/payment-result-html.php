<div class="degardc-row">
    <div class="degardc-column degardc-main-content degardc-payment-result degardc-center">

        <?php
        if($status == 'succeed'){
            ?>
            <div class="degardc-payment-result-title">پرداخت موفق</div>
            <div class="degardc-title" style="margin-top: 0;">صورتحساب شما با موفقیت پرداخت شد</div>
            <p>شماره صورتحساب: <?php echo $invoice_id; ?>#</p>
            <?php
            if($try_new == 'camp'){
            ?>
            <p>سیستم مدیریت کمپین شما به آدرس <a href="<?php echo 'https://' . $domain; ?>"><?php echo $domain; ?></a> با موفقیت راه اندازی شد و اکنون در دسترس است</p>
            <a href="#camphelp2" class="degardc-payment-button-red">آموزش اتصال ربات به سیستم مدیریت کمپین</a>
            <div class="degardc-clear" style="margin:15px"></div>
            <a class="degardc-payment-button-blue" href="<?php echo 'https://' . $domain; ?>" target="_blank">رفتن به آدرس پنل سیستم مدیریت کمپین</a>
            <?php
            }
        }else{
            ?>
            <div class="degardc-payment-result-title">پرداخت ناموفق</div>
            <div class="degardc-title" style="margin-top: 0;">صورتحساب شما پرداخت نشد</div>
            <p>شماره صورتحساب: <?php echo $invoice_id; ?>#</p>
            <p>در صورت کسر مبلغ از حسابتان، مبلغ کسر شده تا 72 ساعت بعد، از طرف بانک صادر کننده کارت شما به حساب شما عودت داده خواهد شد</p>
            <?php
        }
        ?>



    </div>
    <div class="degardc-column degardc-center">

        <?php
        if($status == 'succeed'){
        ?>
            <img src="<?php echo DEGARDC_SERVICES_PLUGIN_URL.'assets/img/succeed.png' ?>">
        <?php
        }else{
        ?>
            <img src="<?php echo DEGARDC_SERVICES_PLUGIN_URL.'assets/img/failed.png' ?>">
        <?php
        }
        ?>

    </div>

</div>

<?php
if($status == 'succeed' && $try_new == 'camp'){
    ?>
<div class="degardc-row degardc-main-content" id="camphelp2" style="margin-top: 40px">
    <video class="elementor-video" src="https://dl.degardc.com/camp-assets/camp-helps/camphelp2.mp4" controls="" controlslist="nodownload" poster="https://degardc.com/wp-content/uploads/2020/09/مراحل-قبل-از-خرید-پنل-مدیریت-کمپین-دگردیسی.png"></video>
</div>
    <?php
}
?>


