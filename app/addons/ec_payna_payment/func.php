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

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

/**
 * Function runs on installation of add-on.
 *
 * @return void
 */
function fn_ec_payna_payment_install()
{
    $data = [
        'processor' => 'Payna Payment Gateway (In-context)',
        'processor_script' => 'ec_payna.php',
        'processor_template' => 'addons/ec_payna_payment/views/orders/components/payments/ec_payna.tpl',
        'admin_template' => 'ec_payna.tpl',
        'callback' => 'Y',
        'type' => 'P',
        'addon' => 'ec_payna_payment',
    ];
    db_query('INSERT INTO ?:payment_processors ?e', $data);
}

/**
 * Function runs on unstallation of add-on.
 *
 * @return null
 */
function fn_ec_payna_payment_uninstall()
{
    $condition = [
        'addon' => 'ec_payna_payment',
    ];
    db_query('DELETE FROM ?:payment_processors WHERE ?w', $condition);
}

function fn_get_payna_payment_error_code($code)
{
    $errors = [
        100 => 'Trouble communicating with Vodacom M-Pesa',
        1000 => 'Failed to authenticate with MNO',
        1001 => 'Duplicate transaction request',
        1010 => 'MSISDN is missing in incorrect formatted',
        1020 => 'Reference number is missing',
        1021 => 'Biller account code does not exists',
        1030 => 'Amount is required',
        1032 => 'Amount required must be an integer',
        5001 => 'Email is missing',
        5002 => 'Password is missing',
        5005 => 'Wrong credentials when requesting token',
    ];

    return isset($errors[$code]) ? $errors[$code] : '';
}
