<div class="degardc-container" id="degardc-campaign-check-domain-container">
    <div class="degardc-main-content" id="degardc-campaign-check-domain-main-content">
        <p class="degardc-progress-title">
            مرحله اول - وارد کردن آیدی ربات
        </p>
        <div class="degardc-progress">
            <div class="degardc-progress-done" data-done="25">
                25%
            </div>
        </div>
        <p class="degardc-title">
            مراحلی که قبل از خرید پنل مدیریت کمپین باید انجام بدهید را در این ویدیو حتما تماشا کنید
        </p>
        <video class="elementor-video" style="margin-bottom: 15px" src="https://dl.degardc.com/camp-assets/camp-helps/camphelp1.mp4" controls="" controlslist="nodownload" poster="https://degardc.com/wp-content/uploads/2020/09/مراحل-قبل-از-خرید-پنل-مدیریت-کمپین-دگردیسی.png"></video>

            <div class="degardc-section">
                <div class="degardc-form-element degardc-form-input" id="degardc-domain-input-div">
                    <input id="degardc-checking-domain-input" class="degardc-form-element-field" placeholder="به عنوان مثال : degardcbot" type="input" required="">
                    <div class="degardc-form-element-bar"></div>
                    <label class="degardc-form-element-label" for="subdomainsld">آیدی رباتی که در Botfather ساختید را وارد کنید</label>
                    <p class="degardc-form-element-hint" id="degardc-domain-lockup-error"></p>
                </div>
            </div>
            <div class="degardc-section degardc-hide" id="degardc-checking-domain-notice">
                <div class="on-load degardc-right" id="degardc-checking-domain-animation">
                    <div class="spinner"></div>
                </div>
                <p class="degardc-right" id="degardc-checking-domain-message">در حال بررسی آیدی ربات - لطفا چند ثانیه صبر کنید</p>
            </div>

            <button class="degardc-button degardc-left" id="degardc-checking-domain-submit"><span>تایید و ادامه</span></button>


        <input type="hidden" id="degardc-billingcycle" name="degardc-billingcycle" value="<?php echo $billingcycle ?>">

        <?php wp_nonce_field( 'degardc_nonce' ); ?>

    </div>
</div>