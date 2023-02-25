<?php

use Tygh\Registry;

//search functionality moved.
//@see fn_csc_changes_post_get_orders_post hook

if ($mode == 'details') {
    $order_info = Tygh::$app['view']->getTemplateVars('order_info');
    if (!empty($order_info['cp_is_need_return_parent_flag'])) {
        $order_info['is_parent_order'] = "Y";
    }

    Tygh::$app['view']->assign('order_info', $order_info);

}