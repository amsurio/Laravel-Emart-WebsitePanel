@include('layouts.app')
@include('layouts.header')
@php
    $cityToCountry = file_get_contents(asset('tz-cities-to-countries.json'));
    $cityToCountry = json_decode($cityToCountry, true);
    $countriesJs = array();
    foreach ($cityToCountry as $key => $value) {
        $countriesJs[$key] = $value;
    }
@endphp
<div class="siddhi-checkout">
    <div class="container position-relative">
        <div class="py-5 row">
            <div class="col-md-8 mb-3 checkout-left">
                <div class="checkout-left-inner">
                    <div class="accordion mb-3 rounded shadow-sm bg-white checkout-left-box border"
                         id="accordionExample">
                        <!-- End Card -->
                        <!-- Net Banking -->
                        <div class="siddhi-card border-bottom overflow-hidden">
                            <div class="siddhi-card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="d-flex p-3 align-items-center btn btn-link w-100" type="button"
                                            data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                        <i class="feather-globe mr-3"></i>{{trans('lang.net_banking')}}
                                        <i class="feather-chevron-down ml-auto"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                 data-parent="#accordionExample">
                                <div class="siddhi-card-body border-top p-3">
                                    <form>
                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                            <label class="btn btn-outline-secondary active">
                                                <input type="radio" name="options" id="option1"
                                                       checked> {{trans('lang.hdfc')}}
                                            </label>
                                            <label class="btn btn-outline-secondary">
                                                <input type="radio" name="options" id="option2"> {{trans('lang.icici')}}
                                            </label>
                                            <label class="btn btn-outline-secondary">
                                                <input type="radio" name="options" id="option3"> {{trans('lang.axis')}}
                                            </label>
                                        </div>
                                        <hr>
                                        <div class="form-row">
                                            <div class="col-md-12 form-group mb-0">
                                                <label class="form-label small font-weight-bold">{{trans('lang.select_bank')}}</label><br>
                                                <select class="custom-select form-control">
                                                    <option>{{trans('lang.bank')}}</option>
                                                    <option>{{trans('lang.kotak')}}</option>
                                                    <option>{{trans('lang.sbi')}}</option>
                                                    <option>{{trans('lang.uco')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END Net Banking -->
                        <div class="siddhi-card overflow-hidden checkout-payment-options">
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                 id="cod_box">
                                <input type="radio" name="payment_method" id="cod" value="cod"
                                       class="custom-control-input" checked>
                                <label class="custom-control-label" for="cod">{{trans('lang.cash_on_delivery')}}</label>
                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                 id="razorpay_box">
                                <input type="radio" name="payment_method" id="razorpay" value="razorpay"
                                       class="custom-control-input">
                                <label class="custom-control-label" for="razorpay">{{trans('lang.razorpay')}}</label>
                                <input type="hidden" id="isEnabled">
                                <input type="hidden" id="isSandboxEnabled">
                                <input type="hidden" id="razorpayKey">
                                <input type="hidden" id="razorpaySecret">
                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                 id="stripe_box">
                                <input type="radio" name="payment_method" id="stripe" value="stripe"
                                       class="custom-control-input">
                                <label class="custom-control-label" for="stripe">{{trans('lang.stripe')}}</label>
                                <input type="hidden" id="isStripeSandboxEnabled">
                                <input type="hidden" id="stripeKey">
                                <input type="hidden" id="stripeSecret">
                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                 id="paypal_box">
                                <input type="radio" name="payment_method" id="paypal" value="paypal"
                                       class="custom-control-input">
                                <label class="custom-control-label" for="paypal">{{trans('lang.pay_pal')}}</label>
                                <input type="hidden" id="ispaypalSandboxEnabled">
                                <input type="hidden" id="paypalKey">
                                <input type="hidden" id="paypalSecret">
                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                 id="payfast_box">
                                <input type="radio" name="payment_method" id="payfast" value="payfast"
                                       class="custom-control-input">
                                <label class="custom-control-label" for="payfast">{{trans('lang.pay_fast')}}</label>
                                <input type="hidden" id="payfast_isEnabled">
                                <input type="hidden" id="payfast_isSandbox">
                                <input type="hidden" id="payfast_merchant_key">
                                <input type="hidden" id="payfast_merchant_id">
                                <input type="hidden" id="payfast_notify_url">
                                <input type="hidden" id="payfast_return_url">
                                <input type="hidden" id="payfast_cancel_url">
                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                 id="paystack_box">
                                <input type="radio" name="payment_method" id="paystack" value="paystack"
                                       class="custom-control-input">
                                <label class="custom-control-label" for="paystack">{{trans('lang.pay_stack')}}</label>
                                <input type="hidden" id="paystack_isEnabled">
                                <input type="hidden" id="paystack_isSandbox">
                                <input type="hidden" id="paystack_public_key">
                                <input type="hidden" id="paystack_secret_key">
                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                 id="flutterWave_box">
                                <input type="radio" name="payment_method" id="flutterwave" value="flutterwave"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="flutterwave">{{trans('lang.flutter_wave')}}</label>
                                <input type="hidden" id="flutterWave_isEnabled">
                                <input type="hidden" id="flutterWave_isSandbox">
                                <input type="hidden" id="flutterWave_encryption_key">
                                <input type="hidden" id="flutterWave_public_key">
                                <input type="hidden" id="flutterWave_secret_key">
                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                 id="mercadopago_box">
                                <input type="radio" name="payment_method" id="mercadopago" value="mercadopago"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="mercadopago">{{trans('lang.mercadopago')}}</label>
                                <input type="hidden" id="mercadopago_isEnabled">
                                <input type="hidden" id="mercadopago_isSandbox">
                                <input type="hidden" id="mercadopago_public_key">
                                <input type="hidden" id="mercadopago_access_token">
                                <input type="hidden" id="title">
                                <input type="hidden" id="quantity">
                                <input type="hidden" id="unit_price">
                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                 id="wallet_box">
                                <input type="radio" name="payment_method" disabled id="wallet" value="wallet"
                                       class="custom-control-input">
                                <label class="custom-control-label" for="wallet">{{trans('lang.wallet_available')}}
                                    <span id="wallet_amount"></span> )</label>
                                <input type="hidden" id="user_wallet_amount">
                            </div>
                        </div>
                    </div>
                    <div class="add-note" id="coupon-div">
                        <h3>{{trans('lang.available_coupon')}}</h3>
                        <div class="foodies-detail-coupon">
                            <div id="coupon_list"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="siddhi-cart-item rounded rounded shadow-sm overflow-hidden bg-white sticky_sidebar"
                     id="service_cart_list">
                    @include('providersService.service_charge.cart_item')
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
@include('layouts.nav')
<script src="https://unpkg.com/geofirestore/dist/geofirestore.js"></script>
<script type="text/javascript">
    var wallet_amount = 0;
    var fcmToken = '';
    var id_order = database.collection("tmp").doc().id;
    var authorName = '';
    var userId = "{{$id}}";
    var provider_id = $('#provider_id').val();
    var providerWallet = 0;
    var orderId = $('#orderId').val();
    var adminCommission = 0;
    var sub_total = 0;
    var couponCode = $("#coupon_code_main").val();
    var discount = $("#discount_amount").val();
    if (discount == null || discount == '' || discount == undefined) {
        discount = '0.0';
    }
    var discountType = $("#discountType").val();
    if (discountType == null || discountType == '' || discountType == undefined) {
        discountType = '';
    }
    var discountLabel = $("#discount").val();
    if (discountLabel == null || discountLabel == '' || discountLabel == undefined) {
        discountLabel = '0.0';
    }
    var cityToCountry = '<?php echo json_encode($countriesJs) ?>';
    cityToCountry = JSON.parse(cityToCountry);
    var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    var userCity = userTimeZone.split('/')[1];
    var userCountry = cityToCountry[userCity];
    var userDetailsRef = database.collection('users').where('id', "==", userId);
    var userproviderDetailsRef = database.collection('users');
    var AdminCommission = database.collection('sections').where('id', '==', section_id);
    var razorpaySettings = database.collection('settings').doc('razorpaySettings');
    var codSettings = database.collection('settings').doc('CODSettings');
    var stripeSettings = database.collection('settings').doc('stripeSettings');
    var paypalSettings = database.collection('settings').doc('paypalSettings');
    var MercadoPagoSettings = database.collection('settings').doc('MercadoPago');
    var walletSettings = database.collection('settings').doc('walletSettings');
    var payFastSettings = database.collection('settings').doc('payFastSettings');
    var payStackSettings = database.collection('settings').doc('payStack');
    var flutterWaveSettings = database.collection('settings').doc('flutterWave');
    var firestore = firebase.firestore();
    var geoFirestore = new GeoFirestore(firestore);
    var currentCurrency = '';
    var currencyAtRight = false;
    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    var currencyData = '';
    refCurrency.get().then(async function (snapshots) {
        currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        decimal_digit = currencyData.decimal_degits;
        currencyAtRight = currencyData.symbolAtRight;
        loadcurrencynew();
    });

    function loadcurrencynew() {
        if (currencyAtRight) {
            jQuery('.currency-symbol-left').hide();
            jQuery('.currency-symbol-right').show();
            jQuery('.currency-symbol-right').text(currentCurrency);
        } else {
            jQuery('.currency-symbol-left').show();
            jQuery('.currency-symbol-right').hide();
            jQuery('.currency-symbol-left').text(currentCurrency);
        }
    }

    var newdate = new Date();
    var refCoupons = database.collection('providers_coupons').where('isPublic', '==', true).where('isEnabled', '==', true).where('sectionId', '==', section_id).where('providerId', '==', provider_id).where("expiresAt", ">", newdate).orderBy("expiresAt").startAt(new Date());
    refCoupons.get().then(async function (snapshot) {
        var couponHtml = '';
        couponHtml += '<div class="copupon-list">';
        couponHtml += '<ul>';
        snapshot.docs.forEach((listval) => {
            var date = '';
            var time = '';
            var coupon = listval.data();
            if (coupon.expiresAt) {
                var date1 = coupon.expiresAt.toDate().toDateString();
                var date = new Date(date1);
                var dd = String(date.getDate()).padStart(2, '0');
                var mm = String(date.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = date.getFullYear();
                var expiresDate = yyyy + '-' + mm + '-' + dd;
            }
            if (coupon.discountType == 'Percentage') {
                var discount = coupon.discount + '%'
            } else {
                coupon.discount = parseFloat(coupon.discount);
                if (currencyAtRight) {
                    var discount = coupon.discount.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    var discount = currentCurrency + "" + coupon.discount.toFixed(decimal_degits);
                }
            }
            if (coupon.isEnabled == true) {
                couponHtml += '<li value="' + coupon.code + '"><span class="per-off">' + discount + ' OFF </span><span>' + coupon.code + ' | Valid till ' + expiresDate + '</span></li>';
            }
        })
        couponHtml += '</ul></div>';
        if (snapshot.docs.length > 0) {
            $('#coupon_list').html(couponHtml);
        } else {
            $('#coupon-div').remove();
        }
    })
    $(document).on("click", '#apply-coupon-code', function (event) {
        var serviceId = $(this).attr('data-id');
        var coupon_code = $("#coupon_code").val();
        var couponCodeRef = database.collection('providers_coupons').where('sectionId', '==', section_id).where('code', "==", coupon_code);
        couponCodeRef.get().then(async function (couponSnapshots) {
            if (couponSnapshots.docs && couponSnapshots.docs.length) {
                var coupondata = couponSnapshots.docs[0].data();
                if (coupondata.providerId == provider_id) {
                    discount = coupondata.discount;
                    discountType = coupondata.discountType;
                    $.ajax({
                        type: 'POST',
                        url: "{{route('apply-service-charge-coupon')}}",
                        data: {
                            _token: '{{csrf_token()}}',
                            coupon_code: coupon_code,
                            discount: discount,
                            discountType: discountType,
                            is_checkout: 1,
                            coupon_id: coupondata.id
                        },
                        success: function (data) {
                            data = JSON.parse(data);
                            $('#service_cart_list').html(data.html);
                            loadcurrencynew();
                            getAdminCommission(orderId);
                        }
                    });
                } else {
                    alert("{{trans('lang.coupon_code_not_valid')}}");
                    $("#coupon_code").val('');
                }
            } else {
                alert("{{trans('lang.coupon_code_not_valid')}}");
                $("#coupon_code").val('');
            }
        });
    });
    $(document).ready(function () {
        getUserDetails();
        getAdminCommission(orderId);
        getProviderDetail(provider_id);
    })
    codSettings.get().then(async function (codSettingsSnapshots) {
        codSettings = codSettingsSnapshots.data();
        if (codSettings.isEnabled) {
            $("#cod_box").show();
        } else {
            $("#cod_box").remove();
        }
    });
    razorpaySettings.get().then(async function (razorpaySettingsSnapshots) {
        razorpaySetting = razorpaySettingsSnapshots.data();
        if (razorpaySetting.isEnabled) {
            var isEnabled = razorpaySetting.isEnabled;
            $("#isEnabled").val(isEnabled);
            var isSandboxEnabled = razorpaySetting.isSandboxEnabled;
            $("#isSandboxEnabled").val(isSandboxEnabled);
            var razorpayKey = razorpaySetting.razorpayKey;
            $("#razorpayKey").val(razorpayKey);
            var razorpaySecret = razorpaySetting.razorpaySecret;
            $("#razorpaySecret").val(razorpaySecret);
            $("#razorpay_box").show();
        }
    });
    stripeSettings.get().then(async function (stripeSettingsSnapshots) {
        stripeSetting = stripeSettingsSnapshots.data();
        if (stripeSetting.isEnabled) {
            var isEnabled = stripeSetting.isEnabled;
            var isSandboxEnabled = stripeSetting.isSandboxEnabled;
            $("#isStripeSandboxEnabled").val(isSandboxEnabled);
            var stripeKey = stripeSetting.stripeKey;
            $("#stripeKey").val(stripeKey);
            var stripeSecret = stripeSetting.stripeSecret;
            $("#stripeSecret").val(stripeSecret);
            $("#stripe_box").show();
        }
    });
    paypalSettings.get().then(async function (paypalSettingsSnapshots) {
        paypalSetting = paypalSettingsSnapshots.data();
        if (paypalSetting.isEnabled) {
            var isEnabled = paypalSetting.isEnabled;
            var isLive = paypalSetting.isLive;
            if (isLive) {
                $("#ispaypalSandboxEnabled").val(false);
            } else {
                $("#ispaypalSandboxEnabled").val(true);
            }
            var paypalClient = paypalSetting.paypalClient;
            $("#paypalKey").val(paypalClient);
            var paypalSecret = paypalSetting.paypalSecret;
            $("#paypalSecret").val(paypalSecret);
            $("#paypal_box").show();
        }
    });
    walletSettings.get().then(async function (walletSettingsSnapshots) {
        walletSetting = walletSettingsSnapshots.data();
        if (walletSetting.isEnabled) {
            var isEnabled = walletSetting.isEnabled;
            if (isEnabled) {
                $("#walletenabled").val(true);
            } else {
                $("#walletenabled").val(false);
            }
            $("#wallet_box").show();
        }
    });
    payFastSettings.get().then(async function (payfastSettingsSnapshots) {
        payFastSetting = payfastSettingsSnapshots.data();
        if (payFastSetting.isEnable) {
            var isEnable = payFastSetting.isEnable;
            $("#payfast_isEnabled").val(isEnable);
            var isSandboxEnabled = payFastSetting.isSandbox;
            $("#payfast_isSandbox").val(isSandboxEnabled);
            var merchant_id = payFastSetting.merchant_id;
            $("#payfast_merchant_id").val(merchant_id);
            var merchant_key = payFastSetting.merchant_key;
            $("#payfast_merchant_key").val(merchant_key);
            var return_url = payFastSetting.return_url;
            $("#payfast_return_url").val(return_url);
            var cancel_url = payFastSetting.cancel_url;
            $("#payfast_cancel_url").val(cancel_url);
            var notify_url = payFastSetting.notify_url;
            $("#payfast_notify_url").val(notify_url);
            $("#payfast_box").show();
        }
    });
    payStackSettings.get().then(async function (payStackSettingsSnapshots) {
        payStackSetting = payStackSettingsSnapshots.data();
        if (payStackSetting.isEnable) {
            var isEnable = payStackSetting.isEnable;
            $("#paystack_isEnabled").val(isEnable);
            var isSandboxEnabled = payStackSetting.isSandbox;
            $("#paystack_isSandbox").val(isSandboxEnabled);
            var publicKey = payStackSetting.publicKey;
            $("#paystack_public_key").val(publicKey);
            var secretKey = payStackSetting.secretKey;
            $("#paystack_secret_key").val(secretKey);
            $("#paystack_box").show();
        }
    });
    flutterWaveSettings.get().then(async function (flutterWaveSettingsSnapshots) {
        flutterWaveSetting = flutterWaveSettingsSnapshots.data();
        if (flutterWaveSetting.isEnable) {
            var isEnable = flutterWaveSetting.isEnable;
            $("#flutterWave_isEnabled").val(isEnable);
            var isSandboxEnabled = flutterWaveSetting.isSandbox;
            $("#flutterWave_isSandbox").val(isSandboxEnabled);
            var encryptionKey = flutterWaveSetting.encryptionKey;
            $("#flutterWave_encryption_key").val(encryptionKey);
            var secretKey = flutterWaveSetting.secretKey;
            $("#flutterWave_secret_key").val(secretKey);
            var publicKey = flutterWaveSetting.publicKey;
            $("#flutterWave_public_key").val(publicKey);
            $("#flutterWave_box").show();
        }
    });
    MercadoPagoSettings.get().then(async function (MercadoPagoSettingsSnapshots) {
        MercadoPagoSetting = MercadoPagoSettingsSnapshots.data();
        if (MercadoPagoSetting.isEnabled) {
            var isEnable = MercadoPagoSetting.isEnabled;
            $("#mercadopago_isEnabled").val(isEnable);
            var isSandboxEnabled = MercadoPagoSetting.isSandboxEnabled;
            $("#mercadopago_isSandbox").val(isSandboxEnabled);
            var PublicKey = MercadoPagoSetting.PublicKey;
            $("#mercadopago_public_key").val(PublicKey);
            var AccessToken = MercadoPagoSetting.AccessToken;
            $("#mercadopago_access_token").val(AccessToken);
            var AccessToken = MercadoPagoSetting.AccessToken;
            $("#mercadopago_box").show();
        }
    });

    async function getUserDetails() {
        userDetailsRef.get().then(async function (userSnapshots) {
            var userDetails = userSnapshots.docs[0].data();
            authorName = userDetails.firstName + ' ' + userDetails.lastName;
            walletBalance = 0;
            if (userDetails.wallet_amount != undefined && userDetails.wallet_amount != '' && !isNaN(userDetails.wallet_amount)) {
                wallet_amount = userDetails.wallet_amount;
                if (currencyAtRight) {
                    walletBalance = wallet_amount.toFixed(decimal_degits) + '' + currentCurrency;
                } else {
                    walletBalance = currentCurrency + '' + wallet_amount.toFixed(decimal_degits);
                }
                $("#user_wallet_amount").val(walletBalance);
                $("#wallet_amount").html(walletBalance);
                wallet_amount = userDetails.wallet_amount;
                $("#wallet").attr('disabled', false);
            } else {
                if (currencyAtRight) {
                    walletBalance = wallet_amount.toFixed(decimal_degits) + '' + currentCurrency;
                } else {
                    walletBalance = currentCurrency + '' + wallet_amount.toFixed(decimal_degits);
                }
                $("#user_wallet_amount").val(walletBalance);
                $("#wallet_amount").text(walletBalance);
            }
        });
    }

    async function getProviderDetail(provider_id) {
        await database.collection('users').where('id', '==', provider_id).get().then(async function (userSnapshots) {
            var userDetails = userSnapshots.docs[0].data();
            if (userDetails.wallet_amount != undefined && userDetails.wallet_amount != '' && !isNaN(userDetails.wallet_amount)) {
                providerWallet = userDetails.wallet_amount;
            }
        });
    }

    async function getAdminCommission(orderId) {
        await database.collection('provider_orders').where('id', '==', orderId).get().then(async function (snapshot) {
            var orderDetails = snapshot.docs[0].data();
            var adminCommission_val = orderDetails.adminCommission;
            var adminCommissionType = orderDetails.adminCommissionType;
            sub_total = parseFloat(orderDetails.provider.price);
            if (orderDetails.provider.disPrice != null && orderDetails.provider.disPrice != undefined && orderDetails.provider.disPrice != '' && orderDetails.provider.disPrice != '0') {
                sub_total = parseFloat(orderDetails.provider.disPrice)
            }
            sub_total = parseFloat(orderDetails.quantity) * sub_total;
            var discountAmt = $("#discount_amount").val();
            if (discountAmt != null || discountAmt != '' || discountAmt != undefined) {
                sub_total = sub_total - discountAmt;
            }
            if (adminCommissionType == "percentage") {
                adminCommission = parseFloat(parseFloat(sub_total * adminCommission_val) / 100).toFixed(decimal_degits);
            } else {
                adminCommission = parseFloat(adminCommission_val).toFixed(decimal_degits);
            }
        })
    }

    async function payServiceCharge() {
        var total_pay = $('#total_pay').val();
        couponCode = $("#coupon_code_main").val();
        discount = $("#discount_amount").val();
        if (discount == null || discount == '' || discount == undefined) {
            discount = '0.0';
        }
        discountType = $("#discountType").val();
        if (discountType == null || discountType == '' || discountType == undefined) {
            discountType = '';
        }
        discountLabel = $("#discount").val();
        if (discountLabel == null || discountLabel == '' || discountLabel == undefined) {
            discountLabel = '0.0';
        }
        var payment_method = $('input[name="payment_method"]:checked').val();
        if (payment_method == "razorpay") {
            var razorpayKey = $("#razorpayKey").val();
            var razorpaySecret = $("#razorpaySecret").val();
            $.ajax({
                type: 'POST',
                url: "{{route('service-charge-proccessing')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    razorpaySecret: razorpaySecret,
                    razorpayKey: razorpayKey,
                    payment_method: payment_method,
                    authorName: authorName,
                    total_pay: total_pay,
                    orderId: orderId,
                    providerId: provider_id,
                    currencyData: currencyData,
                    couponCode: couponCode,
                    discount: discount,
                    discountLabel: discountLabel,
                    discountType: discountType,
                    adminCommission: adminCommission
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $('#service_cart_list').html(data.html);
                    loadcurrencynew();
                    window.location.href = "{{route('service-charge-pay')}}";
                }
            });
        } else if (payment_method == "mercadopago") {
            var mercadopago_public_key = $("#mercadopago_public_key").val();
            var mercadopago_access_token = $("#mercadopago_access_token").val();
            var mercadopago_isSandbox = $("#mercadopago_isSandbox").val();
            var mercadopago_isEnabled = $("#mercadopago_isEnabled").val();
            $.ajax({
                type: 'POST',
                url: "{{route('service-charge-proccessing')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    mercadopago_public_key: mercadopago_public_key,
                    mercadopago_access_token: mercadopago_access_token,
                    payment_method: payment_method,
                    authorName: authorName,
                    id: orderId,
                    total_pay: total_pay,
                    orderId: orderId,
                    providerId: provider_id,
                    mercadopago_isSandbox: mercadopago_isSandbox,
                    mercadopago_isEnabled: mercadopago_isEnabled,
                    address_line1: '',
                    address_line2: '',
                    address_zipcode: '',
                    address_city: '',
                    address_country: '',
                    currencyData: currencyData,
                    couponCode: couponCode,
                    discount: discount,
                    discountLabel: discountLabel,
                    discountType: discountType,
                    adminCommission: adminCommission
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $('#service_cart_list').html(data.html);
                    loadcurrencynew();
                    window.location.href = "{{route('service-charge-pay')}}";
                }
            });
        } else if (payment_method == "stripe") {
            var stripeKey = $("#stripeKey").val();
            var stripeSecret = $("#stripeSecret").val();
            var isStripeSandboxEnabled = $("#isStripeSandboxEnabled").val();
            $.ajax({
                type: 'POST',
                url: "{{route('service-charge-proccessing')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    stripeKey: stripeKey,
                    stripeSecret: stripeSecret,
                    payment_method: payment_method,
                    authorName: authorName,
                    total_pay: total_pay,
                    orderId: orderId,
                    providerId: provider_id,
                    isStripeSandboxEnabled: isStripeSandboxEnabled,
                    address_line1: '',
                    address_line2: '',
                    address_zipcode: '',
                    address_city: '',
                    address_country: '',
                    currencyData: currencyData,
                    couponCode: couponCode,
                    discount: discount,
                    discountLabel: discountLabel,
                    discountType: discountType,
                    adminCommission: adminCommission
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $('#service_cart_list').html(data.html);
                    loadcurrencynew();
                    window.location.href = "{{route('service-charge-pay')}}";
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        } else if (payment_method == "paypal") {
            var paypalKey = $("#paypalKey").val();
            var paypalSecret = $("#paypalSecret").val();
            var ispaypalSandboxEnabled = $("#ispaypalSandboxEnabled").val();
            $.ajax({
                type: 'POST',
                url: "{{route('service-charge-proccessing')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    paypalKey: paypalKey,
                    paypalSecret: paypalSecret,
                    payment_method: payment_method,
                    authorName: authorName,
                    total_pay: total_pay,
                    orderId: orderId,
                    providerId: provider_id,
                    ispaypalSandboxEnabled: ispaypalSandboxEnabled,
                    address_line1: '',
                    address_line2: '',
                    address_zipcode: '',
                    address_city: '',
                    address_country: '',
                    currencyData: currencyData,
                    couponCode: couponCode,
                    discount: discount,
                    discountLabel: discountLabel,
                    discountType: discountType,
                    adminCommission: adminCommission
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $('#service_cart_list').html(data.html);
                    loadcurrencynew();
                    window.location.href = "{{route('service-charge-pay')}}";
                }
            });
        } else if (payment_method == "payfast") {
            var payfast_merchant_key = $("#payfast_merchant_key").val();
            var payfast_merchant_id = $("#payfast_merchant_id").val();
            var payfast_return_url = $("#payfast_return_url").val();
            var payfast_notify_url = $("#payfast_notify_url").val();
            var payfast_cancel_url = $("#payfast_cancel_url").val();
            var payfast_isSandbox = $("#payfast_isSandbox").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('service-charge-proccessing')}}",
                data: {
                    _token: '{{csrf_token() }}',
                    payfast_merchant_key: payfast_merchant_key,
                    payfast_merchant_id: payfast_merchant_id,
                    payment_method: payment_method,
                    authorName: authorName,
                    total_pay: total_pay,
                    orderId: orderId,
                    providerId: provider_id,
                    payfast_isSandbox: payfast_isSandbox,
                    payfast_return_url: payfast_return_url,
                    payfast_notify_url: payfast_notify_url,
                    payfast_cancel_url: payfast_cancel_url,
                    address_line1: '',
                    address_line2: '',
                    address_zipcode: '',
                    address_city: '',
                    address_country: '',
                    currencyData: currencyData,
                    couponCode: couponCode,
                    discount: discount,
                    discountLabel: discountLabel,
                    discountType: discountType,
                    adminCommission: adminCommission
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $('#service_cart_list').html(data.html);
                    loadcurrencynew();
                    window.location.href = "{{route('service-charge-pay')}}";
                }
            });
        } else if (payment_method == "paystack") {
            var paystack_public_key = $("#paystack_public_key").val();
            var paystack_secret_key = $("#paystack_secret_key").val();
            var paystack_isSandbox = $("#paystack_isSandbox").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('service-charge-proccessing')}}",
                data: {
                    _token: '{{csrf_token() }}',
                    payment_method: payment_method,
                    authorName: authorName,
                    total_pay: total_pay,
                    orderId: orderId,
                    providerId: provider_id,
                    paystack_isSandbox: paystack_isSandbox,
                    paystack_public_key: paystack_public_key,
                    paystack_secret_key: paystack_secret_key,
                    address_line1: '',
                    address_line2: '',
                    address_zipcode: '',
                    address_city: '',
                    address_country: '',
                    currencyData: currencyData,
                    couponCode: couponCode,
                    discount: discount,
                    discountLabel: discountLabel,
                    discountType: discountType,
                    adminCommission: adminCommission
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $('#service_cart_list').html(data.html);
                    loadcurrencynew();
                    window.location.href = "{{route('service-charge-pay')}}";
                }
            });
        } else if (payment_method == "flutterwave") {
            var flutterwave_isenabled = $("#flutterWave_isEnabled").val();
            var flutterWave_encryption_key = $("#flutterWave_encryption_key").val();
            var flutterWave_public_key = $("#flutterWave_public_key").val();
            var flutterWave_secret_key = $("#flutterWave_secret_key").val();
            var flutterWave_isSandbox = $("#flutterWave_isSandbox").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('service-charge-proccessing')}}",
                data: {
                    _token: '{{csrf_token() }}',
                    payment_method: payment_method,
                    authorName: authorName,
                    total_pay: total_pay,
                    orderId: orderId,
                    providerId: provider_id,
                    flutterWave_isSandbox: flutterWave_isSandbox,
                    flutterWave_public_key: flutterWave_public_key,
                    flutterWave_secret_key: flutterWave_secret_key,
                    flutterwave_isenabled: flutterwave_isenabled,
                    flutterWave_encryption_key: flutterWave_encryption_key,
                    address_line1: '',
                    address_line2: '',
                    address_zipcode: '',
                    address_city: '',
                    address_country: '',
                    currencyData: currencyData,
                    couponCode: couponCode,
                    discount: discount,
                    discountLabel: discountLabel,
                    discountType: discountType,
                    adminCommission: adminCommission
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $('#service_cart_list').html(data.html);
                    loadcurrencynew();
                    window.location.href = "{{route('service-charge-pay')}}";
                }
            });
        } else {
            if (payment_method == "wallet") {
                if (wallet_amount < total_pay) {
                    alert("{{trans('lang.dont_have_sufficient_balance')}}");
                    return false;
                }
                var wId = database.collection('tmp').doc().id;
                database.collection('wallet').doc(wId).set({
                    "amount": total_pay.toString(),
                    "date": firebase.firestore.FieldValue.serverTimestamp(),
                    "id": wId,
                    "isTopUp": false,
                    "order_id": orderId,
                    "payment_method": 'Wallet',
                    "payment_status": "success",
                    "serviceType": "ondemand-service",
                    "user_id": userId
                }).then(function (result) {
                    wallet_amount = parseFloat(wallet_amount) - parseFloat(total_pay);
                    database.collection('users').doc(userId).update({'wallet_amount': wallet_amount}).then(async function (result) {
                        var wId = database.collection('tmp').doc().id;
                        providerAmount = parseFloat(total_pay) - parseFloat(adminCommission);
                        await database.collection('wallet').doc(wId).set({
                            "amount": providerAmount,
                            "date": firebase.firestore.FieldValue.serverTimestamp(),
                            "id": wId,
                            "isTopUp": true,
                            "order_id": orderId,
                            "payment_method": 'Wallet',
                            "payment_status": "success",
                            "serviceType": "ondemand-service",
                            "user_id": provider_id,
                            'note': 'Booking Amount',
                            'transactionUser': 'provider'
                        }).then(async function (result) {
                            providerWallet = parseFloat(providerWallet) + parseFloat(providerAmount);
                            await database.collection('users').doc(provider_id).update({'wallet_amount': providerWallet}).then(async function (result) {
                                await creditAdminCommision();
                                await updatePaymentStatus(payment_method);
                            })
                        })
                    })
                })
            } else {
                providerWallet = parseFloat(providerWallet) - parseFloat(adminCommission)
                await database.collection('users').doc(provider_id).update({'wallet_amount': providerWallet}).then(async function (result) {
                    await creditAdminCommision();
                    await updatePaymentStatus(payment_method);
                })
            }
        }
    }

    async function creditAdminCommision() {
        var wId = database.collection('tmp').doc().id;
        await database.collection('wallet').doc(wId).set({
            "amount": adminCommission,
            "date": firebase.firestore.FieldValue.serverTimestamp(),
            "id": wId,
            "isTopUp": false,
            "order_id": orderId,
            "payment_method": 'Wallet',
            "payment_status": "success",
            "serviceType": "ondemand-service",
            "user_id": provider_id,
            'note': 'Admin Commission debit',
            'transactionUser': 'provider',
        }).then(async function (result) {
        })
    }

    async function updatePaymentStatus(payment_method) {
        database.collection('provider_orders').doc(orderId).update({
            'paymentStatus': (payment_method == 'cod') ? false : true,
            'payment_method': payment_method,
            'couponCode': couponCode,
            'discount': discount,
            'discountLabel': discountLabel,
            'discountType': discountType,
            'extraPaymentStatus': true
        }).then(function (result) {
            window.location.href = "{{route('my-bookings')}}";
        })
    }

    $(document).on('click', '.copupon-list li', function (e) {
        var navSelectedValue = $(this).attr('value');
        $('#coupon_code').val(navSelectedValue);
    })
</script>