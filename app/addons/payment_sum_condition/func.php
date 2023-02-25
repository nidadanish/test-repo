<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

/**
 * The "prepare_checkout_payment_methods_after_get_payments" hook handler.
 *
 * Actions performed:
 *  - Excludes payments that do not meet the min/max conditions.
 *
 * @see \fn_prepare_checkout_payment_methods()
 */
function fn_payment_sum_condition_prepare_checkout_payment_methods_after_get_payments($cart, $auth, $lang_code, $get_payment_groups, &$payment_methods, $get_payments_params, $cache_key)
{
    if (!$cart['products']) {
        return;
    }
    foreach ($payment_methods as &$cart_id) {
        $cart_id = array_filter($cart_id, function ($payment_method) use ($cart) {
            if (
                ((float) $payment_method['min_value']
                    && $cart['subtotal'] < (float) $payment_method['min_value'])
                || ((float) $payment_method['max_value']
                    && $cart['subtotal'] > (float) $payment_method['max_value'])
            ) {
                return false;
            } else {
                return true;
            }
        });
    }
}