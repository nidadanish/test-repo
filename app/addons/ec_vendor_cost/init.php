<?php
/**
 * Ecarter Technologies Pvt. Ltd.
 *
 * This source file is part of a commercial software. Only users who have purchased a valid license through
 * https://store.ecarter.co and accepted to the terms of the License Agreement can install this product.
 *
 * @category   Add-ons
 * @package    Ecarter Technologies Pvt. Ltd.
 * @copyright  Copyright (c) 2020 Ecarter Technologies Pvt. Ltd.. (https://store.ecarter.co)
 * @license    https://ecarter.co/legal/license-agreement/   License Agreement
 * @version    $Id$
 */

if (!defined('BOOTSTRAP')) { die('Access denied'); }


DEFINE('EC_VENDOR_COST_ADDON_PATH', __DIR__);

fn_register_hooks(
    'get_product_data_post',
    'get_product_price_post',
    'get_products_post',
    'get_products',
    'update_product_post',
    'vendor_plans_calculate_commission_for_payout_post'
);
