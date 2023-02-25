<?php
/**
 * Ecarter Technologies Pvt. Ltd.
 *
 * This source file is part of a commercial software. Only users who have purchased a valid license through
 * https://www.ecarter.co and accepted to the terms of the License Agreement can install this product.
 *
 * @category   Add-ons
 *
 * @copyright  Copyright (c) 2020 Ecarter Technologies Pvt. Ltd.. (https://www.ecarter.co)
 * @license    https://ecarter.co/legal/license-agreement/   License Agreement
 *
 * @version    $Id$
 */

use Tygh\Registry;


$order_id = (!empty($_REQUEST['order_id'])) ? $_REQUEST['order_id'] : 0;
if ($mode == 'success' || $mode == 'failed') {
    $order_info = fn_get_order_info($order_id);
    if ($mode == 'success'){
        fn_login_user($order_info['user_id']);
        $cart = &Tygh::$app['session']['cart'];
        $params = [];
        if (!empty($cart['storefront_id'])) {
            $params['storefront_id'] = $cart['storefront_id'];
        }
        if (defined('ORDER_MANAGEMENT') && !empty($cart['abandoned_cart_user_id'])) {
            $params['user_id'] = $cart['abandoned_cart_user_id'];
            $params['session_id'] = false;
            if (isset($cart['abandoned_cart_storefront_id'])) {
                $params['storefront_id'] = $cart['abandoned_cart_storefront_id'];
            }

            $abandoned_cart_conversion_cleanup_condition = fn_user_session_products_condition($params);
            db_query('DELETE FROM ?:user_session_products WHERE 1=1 AND ?p', $abandoned_cart_conversion_cleanup_condition);
        }

        $cart = [
            'user_data'  => !empty($cart['user_data']) ? $cart['user_data'] : [],
            'profile_id' => !empty($cart['profile_id']) ? $cart['profile_id'] : 0,
            'user_id'    => !empty($cart['user_id']) ? $cart['user_id'] : 0,
        ];
        Tygh::$app['session']['shipping_rates'] = [];
        unset(Tygh::$app['session']['shipping_hash']);

        $current_user_cart_cleanup_condition = fn_user_session_products_condition($params);
        db_query('DELETE FROM ?:user_session_products WHERE 1=1 AND ?p', $current_user_cart_cleanup_condition);
    }
    exit;
    // $processor_data = fn_get_processor_data($order_info['payment_id']);
    // if ($order_info['status'] != $processor_data['processor_params']['s_order_status']) {
    //     $pp_response['order_status'] = 'I';
    //     $pp_response['reason_text'] = __('text_transaction_cancelled');
    //     fn_finish_payment($order_id, $pp_response);
    // }
    // fn_order_placement_routines('route', $order_id, false);
}
// if ($mode == 'failed') {
//     $order_info = fn_get_order_info($order_id);
//     $processor_data = fn_get_processor_data($order_info['payment_id']);
//     if ($order_info['status'] != $processor_data['processor_params']['f_order_status']) {
//         $pp_response['order_status'] = 'I';
//         $pp_response['reason_text'] = __('text_transaction_cancelled');
//         fn_finish_payment($order_id, $pp_response);
//     }
//     fn_order_placement_routines('route', $order_id, false);
// }
if ($mode == 'redirect'){
    if (!defined('BOOTSTRAP')) {
        require './../../../payments/init_payment.php';
    }
    $order_info = fn_get_order_info($order_id);
    if ($order_info) {
        $processor_data = $order_info['payment_method'];
        $payment_timeout = !empty($processor_data['processor_params']['payment_timeout'])?$processor_data['processor_params']['payment_timeout']:30;
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.payna.co.tz/payment/auth/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{"email": "'.$processor_data['processor_params']['api_username'].'", "password": "'.$processor_data['processor_params']['api_password'].'"}  ',
        CURLOPT_HTTPHEADER => [
            'Authorization: '.$processor_data['processor_params']['api_key'],
            'Content-Type: application/json',
        ],
        ]);
        $order_info['payment_info']['channel'] = $order_info['payment_info']['channel'] == 'VODACOMO'?'VODACOM':$order_info['payment_info']['channel'];
        $response = curl_exec($curl);
        curl_close($curl);
        // fn_print_r($response, $processor_data);
        if (!empty($response)) {
            $response = json_decode($response, true);
            if (!empty($response['success'])) {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://api.payna.co.tz/client/request',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{"reference": "ND'.TIME.$order_info['order_id'].'", "msisdn": "'.str_replace("_", '',$order_info['payment_info']['msisdn']).'", "amount": "'.intval($order_info['total']).'", "channel": "'.$order_info['payment_info']['channel'].'"}',
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Bearer '.$response['token'],
                        'Content-Type: application/json',
                    ],
                ]);
                $response = curl_exec($curl);
                curl_close($curl);
                // fn_print_r($response, '{"reference": "ND'.TIME.$order_info['order_id'].'", "msisdn": "'.str_replace("_", '',$order_info['payment_info']['msisdn']).'", "amount": "'.intval($order_info['total']).'", "channel": "'.$order_info['payment_info']['channel'].'"}');
                if (!empty($response)) {
                    $payment_result = json_decode($response, true);
                    if (!empty($payment_result['success'])) {
                        fn_echo("<div style='margin:0 auto; text-align:center;height:90vh;display:flex;flex-direction:column;align-items:center;justify-content:center;'>");
                        fn_echo("<img src='images/spinner.gif'/><br/>");
                        fn_echo(__("ec_payna_payment.your_payment_request_send_to_your_number_please_keep_your_phone_activated", ['[phone]'=> str_replace("_", '',$order_info['payment_info']['msisdn'])]));
                        fn_echo("</div>");
                        while ((time() - TIME) < $payment_timeout) {
                            sleep(10);
                            $_oinfo = fn_get_order_short_info($order_info['order_id']);
                            if ($_oinfo['status'] == $processor_data['processor_params']['s_order_status']) {
                                fn_redirect(fn_url("ec_payna_payment.success&order_id=".$order_info['order_id'], 'C'));
                                // fn_create_payment_form(fn_url("ec_payna_payment.success&order_id=".$order_info['order_id'], 'C'), null, '', 'GET');
                                exit; 
                            } elseif ($_oinfo['status'] == $processor_data['processor_params']['f_order_status']) {
                                fn_redirect(fn_url("ec_payna_payment.failed&order_id=".$order_id, 'C'));
                                // fn_create_payment_form(fn_url("ec_payna_payment.failed&order_id=".$order_info['order_id'], 'C'), null, '', 'GET');
                                exit;
                            }
                        }
                    } elseif (!empty($response['error_code'])) {
                        $pp_response['reason_text'] = !empty($response['message']) ? $response['message'] : fn_get_payna_payment_error_code($response['error_code']);
                    }
                }
            }elseif (!empty($response['error_code'])) {
                $pp_response['reason_text'] = !empty($response['message']) ? $response['message'] : fn_get_payna_payment_error_code($response['error_code']);
            }
        }
    }
    // fn_print_die($order_id, $pp_response, $order_info);
    // fn_create_payment_form(fn_url("ec_payna_payment.failed&order_id=".$order_id, 'C'), null, '', 'GET');
    fn_redirect(fn_url("ec_payna_payment.failed&order_id=".$order_id, 'C'));
    exit;
}

