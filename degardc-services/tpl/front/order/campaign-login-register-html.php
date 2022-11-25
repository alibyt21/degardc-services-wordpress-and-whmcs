<div class="degardc-container" id="degardc-campaign-login-register-container">
    <div class="degardc-main-content" id="degardc-campaign-login-register-main-content">
        <p class="degardc-progress-title">
            مرحله دوم - ورود یا ثبت نام در سایت
        </p>
        <div class="degardc-progress">
            <div class="degardc-progress-done" data-done="40">
                40%
            </div>
        </div>
        <p class="degardc-title">ورود / ثبت نام</p>
        <p>درصورتی که از قبل حساب کاربری دارید، ایمیل و رمز عبور خود را وارد کنید، در غیر این صورت با ایمیل و رمز عبور وارد شده برای شما یک حساب کاربری ساخته خواهد شد</p>
        <form id="degardc-campaign-login-register-form">

            <div class="degardc-section">
                <div class="degardc-form-element degardc-form-input" id="degardc-email-input-div">
                    <input id="degardc-email-input" class="degardc-form-element-field" placeholder="به عنوان مثال : aliramezani@gmail.com" type="email" required="required" oninvalid="this.setCustomValidity('لطفا ایمیل خود را به صورت کامل و صحیح وارد کنید')" oninput="setCustomValidity('')">
                    <div class="degardc-form-element-bar"></div>
                    <label class="degardc-form-element-label" for="degardc-email-input">پست الکترونیک (ایمیل) خود را وارد کنید</label>
                    <p class="degardc-form-element-hint" id="degardc-email-error"></p>
                </div>
            </div>
            <div class="degardc-section">
                <div class="degardc-form-element degardc-form-input" id="degardc-password-input-div">
                    <input id="degardc-password-input" class="degardc-form-element-field" placeholder="حتما توجه کنید که صفحه کلید شما انگلیسی باشد" type="password" required="required" oninvalid="this.setCustomValidity('لطفا یک رمز عبور برای خود انتخاب کنید، دقت کنید که کیبورد شما به اشتباه فارسی نباشد')" oninput="setCustomValidity('')">
                    <div class="degardc-form-element-bar"></div>
                    <label class="degardc-form-element-label" for="degardc-password-input">رمز عبور خود را وارد کنید</label>
                    <p class="degardc-form-element-hint" id="degardc-password-error"></p>
                </div>
            </div>
            <button class="degardc-button degardc-left"><span>تایید و ادامه</span></button>
        </form>
        <div class="degardc-notice" id="degardc-login-register-notice">
            <p class="degardc-message" id="degardc-login-register-message"></p>
        </div>


        <?php wp_nonce_field( 'degardc_nonce' ); ?>

    </div>
</div>