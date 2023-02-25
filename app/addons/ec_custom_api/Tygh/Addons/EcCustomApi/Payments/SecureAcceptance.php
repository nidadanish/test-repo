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
namespace Tygh\Addons\EcCustomApi\Payments;

use Tygh\Common\OperationResult;
use \Tygh\Addons\StorefrontRestApi\Payments\IRedirectionPayment;
use \Tygh\Addons\StorefrontRestApi\Payments\RedirectionPaymentDetailsBuilder;
use Tygh\Tools\Url;

class SecureAcceptance implements IRedirectionPayment
{
    protected $order_info = array();

    protected $auth_info = array();

    protected $payment_info = array();

    /** @var \Tygh\Addons\StorefrontRestApi\Payments\RedirectionPaymentDetailsBuilder $details_builder */
    protected $details_builder;

    /** @var \Tygh\Common\OperationResult $preparation_result */
    private $preparation_result;

    /**
     * YandexCheckpoint constructor.
     */
    public function __construct()
    {
        $this->details_builder = new RedirectionPaymentDetailsBuilder();
        $this->preparation_result = new OperationResult();
    }

    /** @inheritdoc */
    public function setOrderInfo(array $order_info)
    {
        $this->order_info = $order_info;

        return $this;
    }

    /** @inheritdoc */
    public function setAuthInfo(array $auth_info)
    {
        $this->auth_info = $auth_info;

        return $this;
    }

    /** @inheritdoc */
    public function setPaymentInfo(array $payment_info)
    {
        $this->payment_info = $payment_info;

        return $this;
    }

    /** @inheritdoc */
    public function getDetails(array $request)
    {
        if (!empty($this->payment_info['msisdn']) && !empty($this->payment_info['channel'])){
            $this->preparation_result->setSuccess(true);
            $this->preparation_result->setData(
                $this->details_builder
                    ->setMethod(RedirectionPaymentDetailsBuilder::POST)
                    ->setPaymentUrl(fn_url("ec_secureacceptance.redirect&order_id=".$this->order_info['order_id'], 'C'))
                    ->setReturnUrl(fn_url("ec_secureacceptance.success&order_id=".$this->order_info['order_id'], 'C'))
                    ->setCancelUrl(fn_url("ec_secureacceptance.failed&order_id=".$this->order_info['order_id'], 'C'))
                    ->asArray()
            );
        }else{
            $this->preparation_result->setSuccess(false);
        }
        return $this->preparation_result;
    }


}