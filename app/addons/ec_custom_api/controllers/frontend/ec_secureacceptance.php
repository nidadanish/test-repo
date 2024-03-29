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
use Tygh\Http;
use Tygh\Registry;

if ($mode == 'succes' || $mode == 'failed') {
    exit;
// } elseif ($mode == "result") {
//     list($order_id,) = explode("_", $_REQUEST['req_reference_number']);
//     $order_info = fn_get_order_info($order_id);
//     $processor_data = fn_get_processor_data($order_info['payment_method']['payment_id']);
//     if (isset($_REQUEST['transaction_id']) && !empty($_REQUEST['transaction_id']) && isset($_REQUEST['req_reference_number']) && !empty($_REQUEST['req_reference_number']) && isset($_REQUEST['decision'])  && !empty($_REQUEST['decision']) && $_REQUEST['decision']=='ACCEPT' ) {
//         $cyber_source_transaction_id=$_REQUEST['transaction_id'];
//         $pp_response['transaction_id'] = $_REQUEST['transaction_id'];
//         $pp_response['transacttion_uuid']=$_REQUEST['req_transaction_uuid'];
//         $pp_response['response_message'] = $_REQUEST['message'];
//         $pp_response['trans_date'] = isset($_REQUEST['auth_time'])?$_REQUEST['auth_time']:"";
//         $pp_response['decision']=$_REQUEST['decision'];
//         $pp_response['order_status'] = $processor_data['processor_params']['s_order_status'];
//     } else if (isset($_REQUEST['transaction_id']) && !empty($_REQUEST['transaction_id']) && isset($_REQUEST['req_reference_number']) && !empty($_REQUEST['req_reference_number']) && isset($_REQUEST['decision'])  && !empty($_REQUEST['decision']) && $_REQUEST['decision']=='ERROR' ){
//         $cyber_source_transaction_id=$_REQUEST['transaction_id'];
//         $pp_response['transaction_id'] = $_REQUEST['transaction_id'];
//         $pp_response['transacttion_uuid']=$_REQUEST['req_transaction_uuid'];
//         $pp_response['response_message'] = $_REQUEST['message'];
//         $pp_response['trans_date'] = isset($_REQUEST['auth_time'])?$_REQUEST['auth_time']:"";
//         $pp_response['decision']=$_REQUEST['decision'];
//         $pp_response['order_status'] = 'O';
//     }else {
//         $pp_response['order_status'] = $processor_data['processor_params']['f_order_status'];
//         $pp_response['transacttion_uuid']=$_REQUEST['req_transaction_uuid'];
//         $pp_response['response_message'] = $_REQUEST['message'];
//         $pp_response['decision']=$_REQUEST['decision'];
//         fn_update_order_payment_info($order_id, $pp_response);
//         return [CONTROLLER_STATUS_REDIRECT, fn_url("ec_secureacceptance.failed&order_id=".$this->order_info['order_id'], 'C')];
//     }
//     fn_update_order_payment_info($order_id, $pp_response);
//     return [CONTROLLER_STATUS_REDIRECT, fn_url("ec_secureacceptance.success&order_id=".$this->order_info['order_id'], 'C')];
} elseif ($mode == 'redirect') {
    $product="";
    $category="";
    $count=0;
    foreach ($order_info['products'] as $k=>$v) {
        $product = $product.$v['product'].",";
        $count++;
    }
    foreach ($order_info['product_groups'] as $k=>$v) {
        foreach ($v['products'] as $key=>$value) {
            $category=$category.fn_get_category_name($value['main_category']).",";
        }
    }
    $amount=fn_Cyber_Source_get_price_by_currency($order_info['total'], CART_SECONDARY_CURRENCY);
    $account_data = fn_get_processor_data($order_info['payment_method']['payment_id']);  
    $signed_date_time = gmdate("Y-m-d\TH:i:s\Z");
    $card_expiry_date = $order_info['payment_info']['expiry_month']."-".$order_info['payment_info']['expiry_year'];
    $post = array();
    $post['access_key'] = $account_data['processor_params']['wk_cybersource_access_key'];
    $post['profile_id'] = $account_data['processor_params']['wk_cybersource_profileid'];
    $post['transaction_uuid'] = uniqid();
    $post['signed_field_names'] = "access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,bill_to_forename,bill_to_surname,bill_to_email,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,bill_to_address_postal_code,ship_to_phone,customer_ip_address,consumer_id,ship_to_address_line1,ship_to_address_city,ship_to_address_country,ship_to_address_postal_code,ship_to_address_state,ship_to_forename,ship_to_surname,merchant_defined_data1,merchant_defined_data2,merchant_defined_data4,merchant_defined_data5,merchant_defined_data6,merchant_defined_data7,merchant_defined_data8,merchant_defined_data20";
    $post['unsigned_field_names'] =  "card_type,card_number,card_expiry_date";
    $post['signed_date_time'] = $signed_date_time;
    $post['transaction_type'] = "sale";
    $post['reference_number'] = $order_info['order_id']."_".rand(1000, 9999)."_MOBILE";
    $post['amount'] = $amount;
    $post['currency'] = $order_info['secondary_currency'];
    $post['payment_method'] = 'card';
    $post['bill_to_forename'] = $order_info['b_firstname'];
    $post['bill_to_surname'] = $order_info['b_lastname'];
    $post['bill_to_email'] = $order_info['email'];
    $post['bill_to_address_line1'] = $order_info['b_address'];
    $post['bill_to_address_city'] = $order_info['b_city'];
    $post['bill_to_address_state'] = $order_info['b_state'];
    $post['bill_to_address_country'] = $order_info['b_country'];
    $post['bill_to_address_postal_code'] = $order_info['b_zipcode'];
    $post['locale']=$order_info['lang_code'];
    $post['ship_to_phone']=preg_replace('/[^0-9]/', '', $order_info['phone']);
    $post['customer_ip_address']=$_SESSION['auth']['ip'];
    $post['consumer_id']=$order_info['user_id'];
    $post['ship_to_address_line1']=$order_info['s_address'];
    $post['ship_to_address_city']=$order_info['s_city'];
    $post['ship_to_address_country']=$order_info['s_county'];
    $post['ship_to_address_postal_code']=$order_info['s_zipcode'];
    $post['ship_to_address_state']=$order_info['s_state'];
    $post['ship_to_forename']=$order_info['s_firstname'];
    $post['ship_to_surname']=$order_info['s_lastname'];
    $post['merchant_defined_data1']="WC";
    $post['merchant_defined_data2']="YES";
    $post['merchant_defined_data4']= AREA."_".$product;
    $post['merchant_defined_data5']="NO";
    $post['merchant_defined_data6']="Standard";
    $post['merchant_defined_data7']=$count;
    $post['merchant_defined_data8']=$order_info['s_country'];
    $post['merchant_defined_data20']="NO";
    
    foreach ($post as $name => $value) {
        $params[$name] = $value;
    }
    $post['signature']=sign($params,$account_data['processor_params']['wk_cybersource_secret_key']);
    $card_type = fn_get_card_type($_REQUEST['card_type']);
    $post['card_type'] = $card_type;
    $post['card_number'] = $order_info['payment_info']['card_number'];
    $post['card_expiry_date'] = $card_expiry_date;
    if ($account_data['processor_params']['wk_cybersource_mode'] == "live") {
        $url = " https://secureacceptance.cybersource.com/silent/pay";
    } else {
        $url="https://testsecureacceptance.cybersource.com/silent/pay";
    }
    fn_create_payment_form($url, $post, 'Cybersource Secure Acceptance', false);
    exit;
}
