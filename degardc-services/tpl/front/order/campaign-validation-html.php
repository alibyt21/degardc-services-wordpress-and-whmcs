<div class="degardc-container" id="degardc-campaign-validation-container">
    <div class="degardc-main-content" id="degardc-campaign-validation-main-content">
        <p class="degardc-progress-title">
            مرحله سوم - ورود مشخصات
        </p>
        <div class="degardc-progress">
            <div class="degardc-progress-done" data-done="60">
                60%
            </div>
        </div>

<?php   if(is_user_verified_mobile_number($user_id)){   ?>
        <div id="degardc-campaign-validation-inter-number-div">
            <p class="degardc-title">لطفا نام و نام خانوادگی خود را وارد نمایید</p>
            <p>مشخصات اولیه برای ارتباط بهتر با شماست</p>
            <form id="degardc-campaign-validation-inter-fullname-form">

                <div class="degardc-row">
                    <div class="degardc-section degardc-column">
                        <div class="degardc-form-element degardc-form-input" id="degardc-first-name-input-div">
                            <input id="degardc-first-name-input" class="degardc-form-element-field" placeholder="به عنوان مثال : علیرضا" type="text" required="required">
                            <div class="degardc-form-element-bar"></div>
                            <label class="degardc-form-element-label" for="degardc-first-name-input">نام</label>
                            <p class="degardc-form-element-hint" id="degardc-first-name-error"></p>
                        </div>
                    </div>
                    <div class="degardc-section degardc-column">
                        <div class="degardc-form-element degardc-form-input" id="degardc-email-input-div">
                            <input id="degardc-last-name-input" class="degardc-form-element-field" placeholder="به عنوان مثال : رمضانی" type="text" required="required">
                            <div class="degardc-form-element-bar"></div>
                            <label class="degardc-form-element-label" for="degardc-last-name-input">نام خانوادگی</label>
                            <p class="degardc-form-element-hint" id="degardc-last-name-error"></p>
                        </div>
                    </div>
                </div>


                <button class="degardc-button degardc-left"><span>تایید و ادامه</span></button>
            </form>
        </div>
<?php   }else{  ?>
        <div id="degardc-campaign-validation-inter-number-div">
            <p class="degardc-title">لطفا شماره موبایل خود را وارد نمایید</p>
            <p>با وارد کردن شماره موبایل کد تاییدی برای شما ارسال خواهد شد</p>
            <form id="degardc-campaign-validation-inter-number-form">

        <?php   if(!is_user_entered_full_name($user_id)){   ?>
                    <div class="degardc-row">
                        <div class="degardc-section degardc-column">
                            <div class="degardc-form-element degardc-form-input" id="degardc-first-name-input-div">
                                <input id="degardc-first-name-input" class="degardc-form-element-field" placeholder="به عنوان مثال : علیرضا" type="text" required="required" oninvalid="this.setCustomValidity('لطفا نام خود را وارد کنید')" oninput="setCustomValidity('')">
                                <div class="degardc-form-element-bar"></div>
                                <label class="degardc-form-element-label" for="degardc-first-name-input">نام</label>
                                <p class="degardc-form-element-hint" id="degardc-first-name-error"></p>
                            </div>
                        </div>
                        <div class="degardc-section degardc-column">
                            <div class="degardc-form-element degardc-form-input" id="degardc-email-input-div">
                                <input id="degardc-last-name-input" class="degardc-form-element-field" placeholder="به عنوان مثال : رمضانی" type="text" required="required" oninvalid="this.setCustomValidity('لطفا نام خانوادگی خود را وارد کنید')" oninput="setCustomValidity('')">
                                <div class="degardc-form-element-bar"></div>
                                <label class="degardc-form-element-label" for="degardc-last-name-input">نام خانوادگی</label>
                                <p class="degardc-form-element-hint" id="degardc-last-name-error"></p>
                            </div>
                        </div>
                    </div>
        <?php   }   ?>
                <div class="degardc-section">
                    <div class="degardc-form-element degardc-form-input" id="degardc-password-input-div">
                        <input id="degardc-mobile-number-input" class="degardc-form-element-field" placeholder="به عنوان مثال : 09123456789" type="tel" pattern="[0]{1}[9]{1}[0-9]{9}" required="required" oninvalid="this.setCustomValidity('لطفا شماره تلفن همراه خود را به صورت کامل و صحیح وارد کنید، به عنوان مثال : 09123456789')" oninput="setCustomValidity('')">
                        <div class="degardc-form-element-bar"></div>
                        <label class="degardc-form-element-label" for="degardc-mobile-number-input">شماره همراه خود را برای دریافت کد تایید وارد کنید</label>
                        <p class="degardc-form-element-hint" id="degardc-mobile-number-error"></p>
                    </div>
                </div>

                <button class="degardc-button degardc-left"><span>تایید و ادامه</span></button>


            </form>
        </div>
<?php   }   ?>




        <div id="degardc-campaign-validation-verify-number-div" style="display: none">
            <p class="degardc-title">کد تایید را وارد نمایید</p>
            <p>با وارد کردن شماره موبایل کد تاییدی برای شما ارسال خواهد شد</p>
            <form id="degardc-campaign-validation-verify-number-form">
                <input type="text" maxlength="5" class="degardc-verification-input" id="degardc-verification-code-input" autofocus>
                <div class="degardc-section degardc-center">
                    <div class="degardc-inline" id="degardc-can-send-code-again">
                        <div class="degardc-inline degardc-disable"> دریافت مجدد کد تا </div>
                        <div class="degardc-countdown degardc-inline degardc-disable">2:00</div>
                    </div>
                    <div class="degardc-inline degardc-pointer degardc-hide" id="degardc-send-new-code">دریافت مجدد کد</div>



                    <div class="degardc-inline" style="margin:0 5px;color:#4aaefe;font-size:1.5em;font-weight:900;pointer-events:none;"> / </div>
                    <div class="degardc-inline degardc-pointer" id="degardc-change-mobile-number"> اصلاح شماره موبایل </div>
                </div>
                <button class="degardc-button degardc-left"><span>تایید و ادامه</span></button>
            </form>

        </div>









        <div class="degardc-notice" id="degardc-validation-notice">
            <p class="degardc-message" id="degardc-validation-message"></p>
        </div>


        <div class="degardc-hide" id="countdown-initial">2:00</div>
        <div class="degardc-hide" id="previous-counter"></div>

        <?php wp_nonce_field( 'degardc_nonce' ); ?>


    </div>
</div>