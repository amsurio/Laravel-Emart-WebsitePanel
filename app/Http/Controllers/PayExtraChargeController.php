<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VendorUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Session;
use Illuminate\Support\Facades\Storage;
use Google\Client as Google_Client;

class PayExtraChargeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!isset($_COOKIE['section_id']) && !isset($_COOKIE['address_name'])) {
            \Redirect::to('set-location')->send();
        }
        $this->middleware('auth');
    }

    public function proccesstopay()
    {
        $email = Auth::user()->email;
        $user = VendorUsers::where('email', $email)->first();
        $ondemand_cart = Session::get('ondemand_cart', []);
        if (@$ondemand_cart['cart_order']) {
            if ($ondemand_cart['cart_order']['payment_method'] == 'razorpay') {
                $razorpaySecret = $ondemand_cart['cart_order']['razorpaySecret'];
                $razorpayKey = $ondemand_cart['cart_order']['razorpayKey'];
                $authorName = $ondemand_cart['cart_order']['authorName'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                $amount = 0;
                return view('providersService.extra_charge.razorpay', ['is_checkout' => 1, 'cart' => $ondemand_cart, 'id' => $user->uuid, 'email' => $email, 'authorName' => $authorName, 'amount' => $total_pay, 'razorpaySecret' => $razorpaySecret, 'razorpayKey' => $razorpayKey, 'cart_order' => $ondemand_cart['cart_order']]);
            } else if ($ondemand_cart['cart_order']['payment_method'] == 'payfast') {
                $payfast_merchant_key = $ondemand_cart['cart_order']['payfast_merchant_key'];
                $payfast_merchant_id = $ondemand_cart['cart_order']['payfast_merchant_id'];
                $payfast_isSandbox = $ondemand_cart['cart_order']['payfast_isSandbox'];
                $payfast_return_url = route('extra-pay-success');
                $payfast_notify_url = route('notify');
                $payfast_cancel_url = route('extra-pay');
                $authorName = $ondemand_cart['cart_order']['authorName'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                $amount = 0;
                $token = uniqid();
                Session::put('payfast_payment_token', $token);
                Session::save();
                $payfast_return_url = $payfast_return_url . '?token=' . $token;
                return view('providersService.extra_charge.payfast', ['is_checkout' => 1, 'cart' => $ondemand_cart, 'id' => $user->uuid, 'email' => $email, 'authorName' => $authorName, 'amount' => $total_pay, 'payfast_merchant_key' => $payfast_merchant_key, 'payfast_merchant_id' => $payfast_merchant_id, 'payfast_isSandbox' => $payfast_isSandbox, 'payfast_return_url' => $payfast_return_url, 'payfast_notify_url' => $payfast_notify_url, 'payfast_cancel_url' => $payfast_cancel_url, 'cart_order' => $ondemand_cart['cart_order']]);
            } else if ($ondemand_cart['cart_order']['payment_method'] == 'paystack') {
                $paystack_public_key = $ondemand_cart['cart_order']['paystack_public_key'];
                $paystack_secret_key = $ondemand_cart['cart_order']['paystack_secret_key'];
                $paystack_isSandbox = $ondemand_cart['cart_order']['paystack_isSandbox'];
                $authorName = $ondemand_cart['cart_order']['authorName'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                $amount = 0;
                require_once(base_path() . '/paystack-php-master/vendor/autoload.php');
                define("PaystackPublicKey", $paystack_public_key);
                define("PaystackSecretKey", $paystack_secret_key);
                \Paystack\Paystack::init($paystack_secret_key);
                $payment = \Paystack\Transaction::initialize([
                    'email' => $email,
                    'amount' => (int)($total_pay * 100),
                    'callback_url' => route('extra-pay-success'),
                ]);
                Session::put('paystack_authorization_url', $payment->authorization_url);
                Session::put('paystack_access_code', $payment->access_code);
                Session::put('paystack_reference', $payment->reference);
                Session::save();
                if ($payment->authorization_url) {
                    $script = "<script>window.location = '" . $payment->authorization_url . "';</script>";
                    echo $script;
                    exit;
                } else {
                    $script = "<script>window.location = '" . url('') . "';</script>";
                    echo $script;
                    exit;
                }
            } else if ($ondemand_cart['cart_order']['payment_method'] == 'flutterwave') {
                $currency = "USD";
                if (@$ondemand_cart['cart_order']['currencyData']['code']) {
                    $currency = $ondemand_cart['cart_order']['currencyData']['code'];
                }
                $flutterWave_secret_key = $ondemand_cart['cart_order']['flutterWave_secret_key'];
                $flutterWave_public_key = $ondemand_cart['cart_order']['flutterWave_public_key'];
                $flutterWave_isSandbox = $ondemand_cart['cart_order']['flutterWave_isSandbox'];
                $flutterWave_encryption_key = $ondemand_cart['cart_order']['flutterWave_encryption_key'];
                $authorName = $ondemand_cart['cart_order']['authorName'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                Session::put('flutterwave_pay', 1);
                Session::save();
                $token = uniqid();
                Session::put('flutterwave_pay_tx_ref', $token);
                Session::save();
                return view('providersService.extra_charge.flutterwave', ['is_checkout' => 1, 'cart' => $ondemand_cart, 'id' => $user->uuid, 'email' => $email, 'authorName' => $authorName, 'amount' => $total_pay, 'flutterWave_secret_key' => $flutterWave_secret_key, 'flutterWave_public_key' => $flutterWave_public_key, 'flutterWave_isSandbox' => $flutterWave_isSandbox, 'flutterWave_encryption_key' => $flutterWave_encryption_key, 'token' => $token, 'cart_order' => $ondemand_cart['cart_order'], 'currency' => $currency]);
            } else if ($ondemand_cart['cart_order']['payment_method'] == 'stripe') {
                $stripeKey = $ondemand_cart['cart_order']['stripeKey'];
                $stripeSecret = $ondemand_cart['cart_order']['stripeSecret'];
                $authorName = $ondemand_cart['cart_order']['authorName'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                $address_line1 = $ondemand_cart['cart_order']['address_line1'];
                $address_line2 = $ondemand_cart['cart_order']['address_line2'];
                $address_zipcode = $ondemand_cart['cart_order']['address_zipcode'];
                $address_city = $ondemand_cart['cart_order']['address_city'];
                $address_country = $ondemand_cart['cart_order']['address_country'];
                $stripeSecret = $ondemand_cart['cart_order']['stripeSecret'];
                $stripeKey = $ondemand_cart['cart_order']['stripeKey'];
                $isStripeSandboxEnabled = $ondemand_cart['cart_order']['isStripeSandboxEnabled'];
                $authorName = $ondemand_cart['cart_order']['authorName'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                $amount = 0;
                return view('providersService.extra_charge.stripe', ['is_checkout' => 1, 'cart' => $ondemand_cart, 'id' => $user->uuid, 'email' => $email, 'authorName' => $authorName, 'amount' => $total_pay, 'stripeSecret' => $stripeSecret, 'stripeKey' => $stripeKey, 'cart_order' => $ondemand_cart['cart_order']]);
            } else if ($ondemand_cart['cart_order']['payment_method'] == 'paypal') {
                $paypalKey = $ondemand_cart['cart_order']['paypalKey'];
                $paypalSecret = $ondemand_cart['cart_order']['paypalSecret'];
                $authorName = $ondemand_cart['cart_order']['authorName'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                $address_line1 = $ondemand_cart['cart_order']['address_line1'];
                $address_line2 = $ondemand_cart['cart_order']['address_line2'];
                $address_zipcode = $ondemand_cart['cart_order']['address_zipcode'];
                $address_city = $ondemand_cart['cart_order']['address_city'];
                $address_country = $ondemand_cart['cart_order']['address_country'];
                $paypalSecret = $ondemand_cart['cart_order']['paypalSecret'];
                $paypalKey = $ondemand_cart['cart_order']['paypalKey'];
                $ispaypalSandboxEnabled = $ondemand_cart['cart_order']['ispaypalSandboxEnabled'];
                $authorName = $ondemand_cart['cart_order']['authorName'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                $amount = 0;
                return view('providersService.extra_charge.paypal', ['is_checkout' => 1, 'cart' => $ondemand_cart, 'id' => $user->uuid, 'email' => $email, 'authorName' => $authorName, 'amount' => $total_pay, 'paypalSecret' => $paypalSecret, 'paypalKey' => $paypalKey, 'cart_order' => $ondemand_cart['cart_order']]);
            } else if ($ondemand_cart['cart_order']['payment_method'] == 'mercadopago') {
                $currency = "USD";
                if (@$ondemand_cart['cart_order']['currencyData']['code']) {
                    $currency = $ondemand_cart['cart_order']['currencyData']['code'];
                }
                $mercadopago_public_key = $ondemand_cart['cart_order']['mercadopago_public_key'];
                $mercadopago_access_token = $ondemand_cart['cart_order']['mercadopago_access_token'];
                $mercadopago_isSandbox = $ondemand_cart['cart_order']['mercadopago_isSandbox'];
                $mercadopago_isEnabled = $ondemand_cart['cart_order']['mercadopago_isEnabled'];
                $id = $ondemand_cart['cart_order']['id'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                $items['title'] = $id;
                $items['quantity'] = 1;
                $items['unit_price'] = floatval($total_pay);
                $fields[] = $items;
                $item['items'] = $fields;
                $item['back_urls']['failure'] = route('extra-pay');
                $item['back_urls']['pending'] = route('notify');
                $item['back_urls']['success'] = route('extra-pay-success');
                $item['auto_return'] = 'all';
                Session::put('mercadopago_pay', 1);
                Session::save();
                $url = "https://api.mercadopago.com/checkout/preferences";
                $data = array('Accept: application/json', 'Authorization:Bearer ' . $mercadopago_access_token);
                $post_data = json_encode($item);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization:Bearer " . $mercadopago_access_token));
                $response = curl_exec($ch);
                $mercadopago = json_decode($response);
                Session::put('mercadopago_preference_id', $mercadopago->id);
                Session::save();
                if ($mercadopago === null) {
                    die(curl_error($ch));
                }
                $authorName = $ondemand_cart['cart_order']['authorName'];
                $total_pay = $ondemand_cart['cart_order']['total_pay'];
                if ($mercadopago_isSandbox == "true") {
                    $payment_url = $mercadopago->sandbox_init_point;
                } else {
                    $payment_url = $mercadopago->init_point;
                }
                echo "<script>location.href = '" . $payment_url . "';</script>";
                exit;
            }
        } else {
            return redirect()->route('pay-extra-charge');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function processStripePayment(Request $request)
    {
        $email = Auth::user()->email;
        $input = $request->all();
        $ondemand_cart = Session::get('ondemand_cart', []);
        if (@$ondemand_cart['cart_order'] && $input['token_id']) {
            if ($ondemand_cart['cart_order']['stripeKey'] && $ondemand_cart['cart_order']['stripeSecret']) {
                $currency = "usd";
                if (@$ondemand_cart['cart_order']['currency']) {
                    $currency = $ondemand_cart['cart_order']['currency'];
                }
                $stripeSecret = $ondemand_cart['cart_order']['stripeSecret'];
                $stripe = new \Stripe\StripeClient($stripeSecret);
                try {
                    $charge = $stripe->paymentIntents->create([
                        'amount' => ($ondemand_cart['cart_order']['total_pay'] * 1000),
                        'currency' => $currency,
                        'payment_method' => 'pm_card_visa',
                        'description' => 'Emart Order',
                    ]);
                    $ondemand_cart['paymentStatus'] = true;
                    Session::put('ondemand_cart', $ondemand_cart);
                    Session::put('success', 'Payment successful');
                    Session::save();
                    $res = array('status' => true, 'data' => $charge, 'message' => 'success');
                    echo json_encode($res);
                    exit;
                } catch (Exception $e) {
                    $ondemand_cart['paymentStatus'] = false;
                    Session::put('ondemand_cart', $ondemand_cart);
                    Session::put('error', $e->getMessage());
                    Session::save();
                    $res = array('status' => false, 'message' => $e->getMessage());
                    echo json_encode($res);
                    exit;
                }
            }
        }
    }

    public function processPaypalPayment(Request $request)
    {
        $email = Auth::user()->email;
        $input = $request->all();
        $ondemand_cart = Session::get('ondemand_cart', []);
        if (@$ondemand_cart['cart_order']) {
            if ($ondemand_cart['cart_order']) {
                $ondemand_cart['paymentStatus'] = true;
                Session::put('ondemand_cart', $ondemand_cart);
                Session::put('success', 'Payment successful');
                Session::save();
                $res = array('status' => true, 'data' => array(), 'message' => 'success');
                echo json_encode($res);
                exit;
            }
        }
        $ondemand_cart['paymentStatus'] = false;
        Session::put('ondemand_cart', $ondemand_cart);
        Session::put('error', 'Faild Payment');
        Session::save();
        $res = array('status' => false, 'message' => 'Faild Payment');
        echo json_encode($res);
        exit;
    }

    public function razorpaypayment(Request $request)
    {
        $input = $request->all();
        $email = Auth::user()->email;
        $ondemand_cart = Session::get('ondemand_cart', []);
        $api_secret = $ondemand_cart['cart_order']['razorpaySecret'];
        $api_key = $ondemand_cart['cart_order']['razorpayKey'];
        $api = new Api($api_key, $api_secret);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $ondemand_cart['paymentStatus'] = true;
                Session::put('ondemand_cart', $ondemand_cart);
                Session::save();
            } catch (Exception $e) {
                return $e->getMessage();
                Session::put('error', $e->getMessage());
                return redirect()->back();
            }
        }
        Session::put('success', 'Payment successful');
        return redirect()->route('extra-pay-success');
    }

    public function success()
    {
        $ondemand_cart = Session::get('ondemand_cart', []);
        $order_json = array();
        $email = Auth::user()->email;
        $user = VendorUsers::where('email', $email)->first();
        if (isset($_GET['token'])) {
            $payfast_payment = Session::get('payfast_payment_token');
            if ($payfast_payment == $_GET['token']) {
                $ondemand_cart['paymentStatus'] = true;
                Session::put('ondemand_cart', $ondemand_cart);
                Session::put('success', 'Payment successful');
                Session::save();
            }
        }
        if (isset($_GET['reference'])) {
            $paystack_reference = Session::get('paystack_reference');
            $paystack_access_code = Session::get('paystack_access_code');
            if ($paystack_reference == $_GET['reference']) {
                $ondemand_cart['paymentStatus'] = true;
                Session::put('ondemand_cart', $ondemand_cart);
                Session::put('success', 'Payment successful');
                Session::save();
            }
        }
        if (isset($_GET['transaction_id']) && isset($_GET['tx_ref']) && isset($_GET['status'])) {
            $flutterwave_pay_tx_ref = Session::get('flutterwave_pay_tx_ref');
            if ($_GET['status'] == 'successful' && $flutterwave_pay_tx_ref == $_GET['tx_ref']) {
                $ondemand_cart['paymentStatus'] = true;
                Session::put('ondemand_cart', $ondemand_cart);
                Session::put('success', 'Payment successful');
                Session::save();
            } else {
                return redirect()->route('pay-extra-charge');
            }
        }
        if (isset($_GET['preference_id']) && isset($_GET['payment_id']) && isset($_GET['status'])) {
            $mercadopago_preference_id = Session::get('mercadopago_preference_id');
            if ($_GET['status'] == 'approved' && $mercadopago_preference_id == $_GET['preference_id']) {
                $ondemand_cart['paymentStatus'] = true;
                Session::put('ondemand_cart', $ondemand_cart);
                Session::put('success', 'Payment successful');
                Session::save();
            } else {
                return redirect()->route('pay-extra-charge');
            }
        }
        $payment_method = (@$ondemand_cart['cart_order']['payment_method']) ? $ondemand_cart['cart_order']['payment_method'] : 'cod';
        return view('providersService.extra_charge.success', ['cart' => $ondemand_cart, 'id' => $user->uuid, 'email' => $email, 'payment_method' => $payment_method]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function orderProccessing(Request $request)
    {
        $ondemand_cart_order = $request->all();
        $ondemand_cart = Session::get('ondemand_cart', []);
        $ondemand_cart['cart_order'] = $ondemand_cart_order;
        Session::put('ondemand_cart', $ondemand_cart);
        Session::save();
        $res = array('status' => true);
        echo json_encode($res);
        exit;
    }

    public function failed()
    {
        echo "failed payment";
    }

    public function orderComplete(Request $request)
    {

        $cart = array();
        Session::put('ondemand_cart', $cart);
        Session::put('payfast_payment_token', '');
        Session::put('success', 'Your order has been successful!');

        if(Storage::disk('local')->has('firebase/credentials.json')){
            
            $client= new Google_Client();
            $client->setAuthConfig(storage_path('app/firebase/credentials.json'));
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->refreshTokenWithAssertion();
            $client_token = $client->getAccessToken();
            $access_token = $client_token['access_token'];

            $fcm_token = $request->fcm;
            
            if(!empty($access_token) && !empty($fcm_token)){

                $projectId = env('FIREBASE_PROJECT_ID');
                $url = 'https://fcm.googleapis.com/v1/projects/'.$projectId.'/messages:send';

                $data = [
                    'message' => [
                        'notification' => [
                            'title' => $request->subject,
                            'body' => $request->message,
                        ],
                        'data' => [
                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                            'id' => '1',
                            'status' => 'done',
                        ],
                        'token' => $fcm_token,
                    ],
                ];

                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$access_token
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                
                $result = curl_exec($ch);
                if ($result === FALSE) {
                    die('FCM Send Error: ' . curl_error($ch));
                }
                curl_close($ch);
                $result=json_decode($result);

                $response = array();
                $response['success'] = true;
                $response['message'] = 'Notification successfully sent.';
                $response['result'] = $result;

            }else{
                $response = array();
                $response['success'] = false;
                $response['message'] = 'Missing sender id or token to send notification.';
            }

        }else{
            $response = array();
            $response['success'] = false;
            $response['message'] = 'Firebase credentials file not found.';
        }

        Session::save();

        $order_response = array('status' => true, 'order_complete' => true, 'html' => view('providersService.extra_charge.extra_charge.cart_item', ['ondemand_cart' => $cart, 'order_complete' => true, 'is_checkout' => 1])->render(), 'response' => $response);
       
        return response()->json($order_response);
    }
}