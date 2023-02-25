<?php

use Tygh\Registry;
use Tygh\Enum\SiteArea;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

/** @var string $mode */

/*
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($mode === 'bulk_print' && !empty($_REQUEST['order_ids'])) {
        foreach ($_REQUEST['order_ids'] as $key => $order_id) {
            $order_info = fn_get_order_info($order_id);
            if (empty($order_info['parent_order_id'])) {
                $order_ids = db_get_fields('select order_id from ?:orders where parent_order_id = ?i', $order_id);
            }
        }
    }
}*/

if ($mode == 'details') {


    $auth = Tygh::$app['session']['auth'];
    //$ccc = Registry::get('config.current_url');

    if($auth['user_type'] =="V"){
        return true;
    }


    if (!empty($_REQUEST['order_id'])) {
        $parent_order_id = db_get_field('SELECT parent_order_id FROM ?:orders WHERE order_id = ?i ', $_REQUEST['order_id']);
        
        if (!empty($parent_order_id) && empty($_REQUEST['an_show_order'])) {
           // return array(CONTROLLER_STATUS_REDIRECT, 'orders.details?order_id=' . $parent_order_id);
        }
    }

}