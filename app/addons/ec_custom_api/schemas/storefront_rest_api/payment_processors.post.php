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
use Tygh\Enum\Addons\StorefrontRestApi\PaymentTypes;
use Tygh\Registry;

defined('BOOTSTRAP') or die('Access denied');

/**
 * This schema describes payment processors that can be used to perform the order settlement via Storefront REST API.
 *
 * Structure:
 *
 * [
 *     payment_processor_script => [
 *       'type'  => Payment type.
 *                  @see \Tygh\Enum\Addons\StorefrontRestApi\PaymentTypes
 *       'class' => FQDN of the class to perform payment.
 *                  Must implement \Tygh\Addons\StorefrontRestApi\Payments\IRedirectionPayment or
 *                  \Tygh\Addons\StorefrontRestApi\Payments\IDirectPayment interface
 *     ]
 * ]
 */

$schema['ec_payna.php'] = array(
    'type'  => PaymentTypes::REDIRECTION,
    'class' => '\Tygh\Addons\EcCustomApi\Payments\PaynaPayment',
);
$schema['secure_acceptance.php'] = array(
    'type'  => PaymentTypes::REDIRECTION,
    'class' => '\Tygh\Addons\EcCustomApi\Payments\SecureAcceptance',
);
return $schema;