<?php
/***************************************************************************
 *                                                                          *
 *   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
 *                                                                          *
 * This  is  commercial  software,  only  users  who have purchased a valid *
 * license  and  accept  to the terms of the  License Agreement can install *
 * and use this program.                                                    *
 *                                                                          *
 ****************************************************************************
 * PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
 * "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
 ****************************************************************************/

namespace Tygh\Api\Entities\v40;

use Tygh\Addons\StorefrontRestApi\ASraEntity;
use Tygh\Api\Response;

/**
 * Class EcProfileFields provides means to get profile fields via RESTful API.
 *
 * @package Tygh\Api\Entities\v40
 */
class SraExtPages extends ASraEntity
{
 

    /** @inheritdoc */
    public function __construct(array $auth = [], $area = '')
    {
        parent::__construct($auth, $area);
    }

    /** @inheritdoc */
    public function index($id = 0, $params = [])
    {
        return [
            'status' => Response::STATUS_METHOD_NOT_ALLOWED,
        ];
    }

    /** @inheritdoc */
    public function privileges()
    {
        return [
            'create' => true,
        ];
    }

    /** @inheritdoc */
    public function privilegesCustomer()
    {
        return [
            'create' => true,
        ];
    }

    /** @inheritdoc */
    public function create($params)
    {
        $page_id = 46;
        $form_values=[];
        $form_values['27'] = $params['name'];
        $form_values['28'] = $params['topic'];
        $form_values['33'] = $params['email'];
        $form_values['34'] = $params['message'];
        $success = \fn_send_form($page_id, $form_values);
        return [
            'status' => Response::STATUS_OK,
            'data' => [
                'success' => true,
                'result' => $success
            ]
        ];
    }

    /** @inheritdoc */
    public function update($id, $params)
    {
        return [
            'status' => Response::STATUS_METHOD_NOT_ALLOWED,
        ];
    }

    /** @inheritdoc */
    public function delete($id)
    {
        return [
            'status' => Response::STATUS_METHOD_NOT_ALLOWED,
        ];
    }
}
