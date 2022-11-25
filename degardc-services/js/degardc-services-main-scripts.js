jQuery(document).ready(function($) {



    /*START checking domain page*/
    $('#degardc-checking-domain-submit').click(function (e) {

        e.preventDefault();

        domain_name = $('#degardc-checking-domain-input').val();
        var $billingcycle = $('#degardc-billingcycle').val();
        var english = /^[A-Za-z0-9!@#$%^&*]*$/;
        var $security = $('#_wpnonce').val();

        if(domain_name.endsWith('bot')){

            if(domain_name.indexOf('_') != -1) {

                $('#degardc-domain-input-div').removeClass('degardc-form-is-success');
                $('#degardc-domain-input-div').addClass('degardc-form-has-error');
                $('#degardc-domain-lockup-error').show().text('خطا : لطفا یک آیدی ربات که فاقد _ (آندرلاین) باشد برای ربات خودتان از botfather انتخاب کنید و اینجا وارد کنید.');

            } else if (!english.test(domain_name)) {

                $('#degardc-domain-input-div').removeClass('degardc-form-is-success');
                $('#degardc-domain-input-div').addClass('degardc-form-has-error');
                $('#degardc-domain-lockup-error').show().text('خطا : استفاده از حروف فارسی یا علائم یا فاصله مجاز نمی باشد - صرفا حروف انگلیسی و اعداد استفاده شود.');

            } else {

                $('#degardc-domain-lockup-error').addClass('degardc-hide')
                $('#degardc-domain-input-div').removeClass('degardc-form-has-error');
                $('#degardc-checking-domain-notice').removeClass('degardc-hide');

                $.ajax({
                    url: degardc_services_ajax_object.ajax_url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'degardc_services_campaign_check_domain_ajax',
                        checking_domain: domain_name,
                        billingcycle: $billingcycle,
                        security: $security,
                    },
                    statusCode: {
                        200: function(result) {
                            if(result.error){

                                $('#degardc-checking-domain-notice').addClass('degardc-hide');
                                $('#degardc-domain-input-div').removeClass('degardc-form-is-success');
                                $('#degardc-domain-input-div').addClass('degardc-form-has-error');
                                $('#degardc-domain-lockup-error').show().text('این آیدی قبلا ثبت شده است، لطفا یک آیدی دیگر برای ربات خود انتخاب کنید');

                            } else{

                                $('#degardc-checking-domain-notice').addClass('degardc-hide');
                                $('#degardc-domain-lockup-error').hide();
                                $('#degardc-domain-input-div').removeClass('degardc-form-has-error');
                                $('#degardc-domain-input-div').addClass('degardc-form-is-success');
                                //$('#campaign-domain').val(domain_name);
                                //$('#degardc-campaign-domain-form').submit();
                                window.location = result.redirect;

                            }
                        },
                        400: function(result) {

                            $('#degardc-checking-domain-notice').addClass('degardc-hide');
                            $('#degardc-domain-input-div').addClass('degardc-form-has-error');
                            $('#degardc-domain-lockup-error').show().text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                            console.log(result.responseText);

                        },
                        404: function(result) {

                            $('#degardc-checking-domain-notice').addClass('degardc-hide');
                            $('#degardc-domain-input-div').addClass('degardc-form-has-error');
                            $('#degardc-domain-lockup-error').show().text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                            console.log(result);

                        },
                        500: function(result) {

                            $('#degardc-checking-domain-notice').addClass('degardc-hide');
                            $('#degardc-domain-input-div').addClass('degardc-form-has-error');
                            $('#degardc-domain-lockup-error').show().text('خطایی رخ داده است، لطفا چند دقیقه بعد مجددا تلاش کنید');
                            console.log(result.responseText);

                        },
                        401: function(result) {

                            $('#degardc-checking-domain-notice').addClass('degardc-hide');
                            $('#degardc-domain-input-div').addClass('degardc-form-has-error');
                            $('#degardc-domain-lockup-error').show().text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                            console.log(result);

                        }
                    }
                });
            }
        } else {

            $('#degardc-domain-input-div').removeClass('degardc-form-is-success');
            $('#degardc-domain-input-div').addClass('degardc-form-has-error');
            $('#degardc-domain-lockup-error').show().text('خطا : آیدی ربات باید به عبارت bot ختم شود.');

        }

    });
    /*END checking domain page*/





    /*START login register page*/
    $('#degardc-campaign-login-register-form').on('submit',function (event) {

        event.preventDefault();
        var $this = $(this);
        var $email = $this.find('#degardc-email-input').val();
        var $password = $this.find('#degardc-password-input').val();
        var $security = $('#_wpnonce').val();

            $.ajax({
                url: degardc_services_ajax_object.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'degardc_services_campaign_login_register_ajax',
                    email: $email,
                    password: $password,
                    security: $security,
                },
                statusCode: {
                    200: function(result) {
                        if(result.error){
                            $('#degardc-login-register-message').html(result.message);
                            $('#degardc-login-register-notice').addClass('error');
                            setTimeout(function() {
                                $('#degardc-login-register-notice').removeClass('error');
                            }, 8000);
                        }else{

                            $('#degardc-login-register-message').html(result.message);
                            $('#degardc-login-register-notice').addClass('success');
                            window.location.replace(result.redirect);
                            setTimeout(function() {
                                $('#degardc-login-register-notice').removeClass('success');
                            }, 8000);


                        }
                    },
                    400: function(result) {

                        $('#degardc-login-register-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                        $('#degardc-login-register-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-login-register-notice').removeClass('error');
                        }, 8000);
                        console.log(result.responseText);

                    },
                    404: function(result) {

                        $('#degardc-login-register-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                        $('#degardc-login-register-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-login-register-notice').removeClass('error');
                        }, 8000);
                        console.log(result.responseText);

                    },
                    500: function(result) {

                        $('#degardc-login-register-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                        $('#degardc-login-register-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-login-register-notice').removeClass('error');
                        }, 8000);
                        console.log(result.responseText);

                    },
                    401: function(result) {

                        $('#degardc-login-register-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                        $('#degardc-login-register-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-login-register-notice').removeClass('error');
                        }, 8000);
                        console.log(result.responseText);

                    }
                }
            });
    });
    /*END login register page*/





    /*START validation page*/

    $('#degardc-campaign-validation-inter-number-form').on('submit',function (event) {

        event.preventDefault();
        var $this = $(this);
        var $mobilenumber = $this.find('#degardc-mobile-number-input').val();
        var $security = $('#_wpnonce').val();

        $.ajax({
            url: degardc_services_ajax_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'degardc_services_campaign_send_validation_code_ajax',
                mobilenumber: $mobilenumber,
                security: $security,
            },
            statusCode: {
                200: function(result) {
                    if(result.error){
                        $('#degardc-validation-message').html(result.message);
                        $('#degardc-validation-notice').removeClass('success');
                        $('#degardc-validation-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-validation-notice').removeClass('error');
                        }, 8000);
                    }else{

                        $('#degardc-validation-message').html(result.message);
                        $('#degardc-validation-notice').removeClass('error');
                        $('#degardc-validation-notice').addClass('success');
                        setTimeout(function() {
                            $('#degardc-validation-notice').removeClass('success');
                        }, 8000);
                        $('#degardc-campaign-validation-inter-number-div').slideUp(500);
                        $('#degardc-campaign-validation-verify-number-div').slideDown(500);

                        $('#degardc-can-send-code-again').removeClass('degardc-hide');
                        $('#degardc-send-new-code').addClass('degardc-hide');
                        $('.degardc-countdown').html($('#countdown-initial').html()) ;
                        //stop previous interval if existing
                        var previous_interval = $('#previous-counter').html();
                        window.clearInterval(previous_interval);
                        var timer2 = $('#countdown-initial').html();
                        var interval = setInterval(function() {
                            var timer = timer2.split(':');
                            //by parsing integer, I avoid all extra string processing
                            var minutes = parseInt(timer[0], 10);
                            var seconds = parseInt(timer[1], 10);
                            --seconds;
                            minutes = (seconds < 0) ? --minutes : minutes;
                            seconds = (seconds < 0) ? 59 : seconds;
                            seconds = (seconds < 10) ? '0' + seconds : seconds;
                            console.log(minutes, seconds);

                            //minutes = (minutes < 10) ?  minutes : minutes;
                            $('.degardc-countdown').html(minutes + ':' + seconds);
                            if (minutes < 0) clearInterval(interval);
                            //check if both minutes and seconds are 0
                            if ((seconds <= 0) && (minutes <= 0)){
                                clearInterval(interval);
                                $('#degardc-can-send-code-again').addClass('degardc-hide');
                                $('#degardc-send-new-code').removeClass('degardc-hide');
                            }
                            timer2 = minutes + ':' + seconds;
                        }, 1000);
                        $('#previous-counter').html(interval);


                    }
                },
                400: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                404: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                500: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                401: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                }
            }
        });
    });





    $('#degardc-change-mobile-number').on('click',function (event) {
        $('#degardc-campaign-validation-verify-number-div').slideUp(500);
        $('#degardc-campaign-validation-inter-number-div').slideDown(500);
    });




    $('#degardc-send-new-code').on('click',function (event) {

        var $mobilenumber = $('#degardc-campaign-validation-inter-number-form').find('#degardc-mobile-number-input').val()
        var $security = $('#_wpnonce').val();

        $.ajax({
            url: degardc_services_ajax_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'degardc_services_campaign_send_validation_code_ajax',
                mobilenumber: $mobilenumber,
                security: $security
            },
            statusCode: {
                200: function(result) {
                    if(result.error){
                        $('#degardc-validation-message').html(result.message);
                        $('#degardc-validation-notice').removeClass('success');
                        $('#degardc-validation-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-validation-notice').removeClass('error');
                        }, 8000);
                    }else{

                        $('#degardc-validation-message').html(result.message);
                        $('#degardc-validation-notice').removeClass('error');
                        $('#degardc-validation-notice').addClass('success');
                        setTimeout(function() {
                            $('#degardc-validation-notice').removeClass('success');
                        }, 8000);
                        $('#degardc-can-send-code-again').removeClass('degardc-hide');
                        $('#degardc-send-new-code').addClass('degardc-hide');
                        $('.degardc-countdown').html($('#countdown-initial').html());

                        //stop previous interval if existing
                        var previous_interval = $('#previous-counter').html();
                        window.clearInterval(previous_interval);

                        var timer2 = $('#countdown-initial').html();
                        var interval = setInterval(function() {
                            var timer = timer2.split(':');
                            //by parsing integer, I avoid all extra string processing
                            var minutes = parseInt(timer[0], 10);
                            var seconds = parseInt(timer[1], 10);
                            --seconds;
                            minutes = (seconds < 0) ? --minutes : minutes;
                            seconds = (seconds < 0) ? 59 : seconds;
                            seconds = (seconds < 10) ? '0' + seconds : seconds;
                            //minutes = (minutes < 10) ?  minutes : minutes;
                            $('.degardc-countdown').html(minutes + ':' + seconds);
                            if (minutes < 0) clearInterval(interval);
                            //check if both minutes and seconds are 0
                            if ((seconds <= 0) && (minutes <= 0)){
                                clearInterval(interval);
                                $('#degardc-can-send-code-again').addClass('degardc-hide');
                                $('#degardc-send-new-code').removeClass('degardc-hide');
                            }
                            timer2 = minutes + ':' + seconds;
                        }, 1000);
                        $('#previous-counter').html(interval);

                    }
                },
                400: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                404: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                500: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                401: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                }
            }
        });
    });










    $('#degardc-campaign-validation-verify-number-form').on('submit',function (event) {

        event.preventDefault();

        var $this = $(this);
        var $mobilenumber = $('#degardc-campaign-validation-inter-number-form').find('#degardc-mobile-number-input').val()
        var $verificationcode = $this.find('#degardc-verification-code-input').val();
        var $firstname = $('#degardc-first-name-input').val();
        var $lastname = $('#degardc-last-name-input').val();
        var $security = $('#_wpnonce').val();

        $.ajax({
            url: degardc_services_ajax_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'degardc_services_campaign_verify_code_ajax',
                mobilenumber: $mobilenumber,
                verificationcode: $verificationcode,
                firstname: $firstname,
                lastname: $lastname,
                security: $security,
            },
            statusCode: {
                200: function(result) {
                    if(result.error){
                        $('#degardc-validation-message').html(result.message);
                        $('#degardc-validation-notice').removeClass('success');
                        $('#degardc-validation-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-validation-notice').removeClass('error');
                        }, 8000);
                    }else{

                        $('#degardc-validation-message').html(result.message);
                        $('#degardc-validation-notice').removeClass('error');
                        $('#degardc-validation-notice').addClass('success');
                        setTimeout(function() {
                            $('#degardc-validation-notice').removeClass('success');
                        }, 8000);
                        window.location.replace(result.redirect);

                    }
                },
                400: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                404: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                500: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                401: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                }
            }
        });
    });



    $('#degardc-campaign-validation-inter-fullname-form').on('submit',function (event) {

        event.preventDefault();
        var $this = $(this);
        var $firstname = $('#degardc-first-name-input').val();
        var $lastname = $('#degardc-last-name-input').val();
        var $security = $('#_wpnonce').val();

        $.ajax({
            url: degardc_services_ajax_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'degardc_services_campaign_add_fullname_ajax',
                firstname: $firstname,
                lastname: $lastname,
                security: $security,
            },
            statusCode: {
                200: function(result) {
                    if(result.error){
                        $('#degardc-validation-message').html(result.message);
                        $('#degardc-validation-notice').removeClass('success');
                        $('#degardc-validation-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-validation-notice').removeClass('error');
                        }, 8000);
                    }else{

                        $('#degardc-validation-message').html(result.message);
                        $('#degardc-validation-notice').removeClass('error');
                        $('#degardc-validation-notice').addClass('success');
                        setTimeout(function() {
                            $('#degardc-validation-notice').removeClass('success');
                        }, 8000);
                        window.location.replace(result.redirect);

                    }
                },
                400: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                404: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                500: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                401: function(result) {

                    $('#degardc-validation-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-validation-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-validation-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                }
            }
        });
    });


    /*END validation page*/






    /* START checkout page */


    $('#degardc-apply-discount').on('click',function (event) {

        event.preventDefault();
        var $discountcode = $('#degardc-discount-code-input').val();
        var $billingcycle = $('#degardc-billingcycle').html();
        var $pid = $('#degardc-pid').html();
        var $totalprice = $('#degardc-order-total-price').html();
        var $security = $('#_wpnonce').val();


        $.ajax({
            url: degardc_services_ajax_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'degardc_services_check_discount_code_ajax',
                discountcode: $discountcode,
                billingcycle: $billingcycle,
                pid: $pid,
                totalprice: $totalprice,
                security: $security,
            },
            statusCode: {
                200: function(result) {
                    if(result.error){
                        $('#degardc-checkout-message').html(result.message);
                        $('#degardc-checkout-notice').removeClass('success');
                        $('#degardc-checkout-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-checkout-notice').removeClass('error');
                        }, 8000);
                    }else{

                        $('#degardc-checkout-message').html(result.message);
                        $('#degardc-checkout-notice').removeClass('error');
                        $('#degardc-checkout-notice').addClass('success');
                        setTimeout(function() {
                            $('#degardc-checkout-notice').removeClass('success');
                        }, 8000);
                        $('#degardc-discount-amount').html(result.discount);
                        $('#degardc-discount-code').html($discountcode);
                        if(result.newtotalprice == 0){
                            $('#degardc-total-price').html('رایگان');
                            $('#degardc-total-price-suffix').html('');
                        }else{
                            $('#degardc-total-price').html(result.newtotalprice);
                        }
                        $('#degardc-discount-code-input').attr("disabled", true);
                        $('#degardc-apply-discount').addClass('degardc-hide');
                        $('#degardc-discount-details').removeClass('degardc-hide');

                    }
                },
                400: function(result) {

                    $('#degardc-checkout-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-checkout-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-checkout-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                404: function(result) {

                    $('#degardc-checkout-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-checkout-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-checkout-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                500: function(result) {

                    $('#degardc-checkout-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-checkout-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-checkout-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                401: function(result) {

                    $('#degardc-checkout-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-checkout-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-checkout-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                }
            }
        });
    });




    $('#degardc-remove-discount-code').on('click',function (event) {
        event.preventDefault();
        var $absolutetotalprice = $('#degardc-absolute-total-price').html();
        $('#degardc-total-price').html($absolutetotalprice);
        $('#degardc-discount-code-input').attr("disabled", false);
        $('#degardc-discount-code-input').val('');
        $('#degardc-apply-discount').removeClass('degardc-hide');
        $('#degardc-discount-details').addClass('degardc-hide');
        $('#degardc-total-price-suffix').html(' هزار تومان');
    });



    //checkout add order and pay invoice
    $('#degardc-campaign-checkout-form').on('submit',function (event) {

        event.preventDefault();
        var $this = $(this);
        var $pid = $('#degardc-pid').html();
        var $billingcycle = $('#degardc-billingcycle').html();
        var $domain = $('#degardc-order-domain').html();
        var $paymentmethod = $('#degardc-order-paymentmethod').html();
        var $promotioncode = $('#degardc-discount-code-input').val();
        var $policycheckbox = $('#degardc-policy-checkbox:checked').length;
        var $security = $('#_wpnonce').val();


        $('#degardc-checkout-message').html('لطفا چند ثانیه صبر کنید، در حال انتقال به درگاه بانک');
        $('#degardc-checkout-notice').removeClass('error');
        $('#degardc-checkout-notice').addClass('success');
        setTimeout(function() {
            $('#degardc-checkout-notice').removeClass('success');
        }, 15000);

        $.ajax({
            url: degardc_services_ajax_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'degardc_services_add_order_and_pay_invoice_ajax',
                pid: $pid,
                billingcycle: $billingcycle,
                domain: $domain,
                paymentmethod: $paymentmethod,
                promotioncode: $promotioncode,
                policycheckbox: $policycheckbox,
                security: $security,
            },
            statusCode: {
                200: function(result) {
                    if(result.error){
                        $('#degardc-checkout-message').html(result.message);
                        $('#degardc-checkout-notice').removeClass('success');
                        $('#degardc-checkout-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-checkout-notice').removeClass('error');
                        }, 8000);
                    }else{

                        $('#degardc-checkout-message').html(result.message);
                        $('#degardc-checkout-notice').removeClass('error');
                        $('#degardc-checkout-notice').addClass('success');
                        window.location = result.redirect;
                        setTimeout(function() {
                            $('#degardc-checkout-notice').removeClass('success');
                        }, 8000);


                    }
                },
                400: function(result) {

                    $('#degardc-checkout-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-checkout-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-checkout-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                404: function(result) {

                    $('#degardc-checkout-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-checkout-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-checkout-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                500: function(result) {

                    $('#degardc-checkout-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-checkout-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-checkout-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                401: function(result) {

                    $('#degardc-checkout-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-checkout-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-checkout-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                }
            }
        });
    });

    /* END checkout page */



    /* START PAY INVOICE */
    $('#degardc-pay-invoice-form').on('submit',function (event) {

        event.preventDefault();
        var $this = $(this);
        var $invoiceid = $('#degardc-invoice-id').val();
        var $clientid = $('#degardc-client-id').val();
        var $paymentmethod = $('#degardc-payment-method').val();
        var $security = $('#_wpnonce').val();


        $('#degardc-pay-invoice-message').html('لطفا چند ثانیه صبر کنید، در حال انتقال به درگاه بانک');
        $('#degardc-pay-invoice-notice').addClass('success');
        setTimeout(function() {
            $('#degardc-pay-invoice-notice').removeClass('success');
        }, 15000);

        $.ajax({
            url: degardc_services_ajax_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'degardc_services_pay_invoice_ajax',
                clientid: $clientid,
                invoiceid: $invoiceid,
                paymentmethod: $paymentmethod,
                security: $security,
            },
            statusCode: {
                200: function(result) {
                    if(result.error){

                        $('#degardc-pay-invoice-notice').removeClass('success');
                        $('#degardc-pay-invoice-message').html(result.message);
                        $('#degardc-pay-invoice-notice').addClass('error');
                        setTimeout(function() {
                            $('#degardc-pay-invoice-notice').removeClass('error');
                        }, 8000);

                    }else{
                        window.location = result.redirect;
                    }
                },
                400: function(result) {

                    $('#degardc-pay-invoice-notice').removeClass('success');
                    $('#degardc-pay-invoice-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-pay-invoice-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-pay-invoice-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                404: function(result) {

                    $('#degardc-pay-invoice-notice').removeClass('success');
                    $('#degardc-pay-invoice-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-pay-invoice-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-pay-invoice-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                500: function(result) {

                    $('#degardc-pay-invoice-notice').removeClass('success');
                    $('#degardc-pay-invoice-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-pay-invoice-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-pay-invoice-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                },
                401: function(result) {

                    $('#degardc-pay-invoice-notice').removeClass('success');
                    $('#degardc-pay-invoice-message').text('خطایی رخ داده است، به پشتیبانی اطلاع دهید');
                    $('#degardc-pay-invoice-notice').addClass('error');
                    setTimeout(function() {
                        $('#degardc-pay-invoice-notice').removeClass('error');
                    }, 8000);
                    console.log(result.responseText);

                }
            }
        });
    });




    /* END PAY INVOICE */




    /*START used in all pages*/

    /* Taken from https://codepen.io/jonnitto/project/editor/XRPjxx
     Minimal Javascript (for Edge, IE and select box) */

    document.addEventListener("change", function (event) {
        let element = event.target;
        if (element && element.matches(".degardc-form-element-field")) {
            element.classList[element.value ? "add" : "remove"]("-hasvalue");
        }
    });


    /*progress bar scripts*/

    const progress = document.querySelector('.degardc-progress-done');

    setTimeout(() => {
        progress.style.opacity = 1;
        progress.style.width = progress.getAttribute('data-done') + '%';
    }, 500)

    /*END used in all pages*/


});






