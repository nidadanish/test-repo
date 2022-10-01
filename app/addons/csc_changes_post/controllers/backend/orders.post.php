<?php

/** @var string $mode */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($mode === 'm_update' && !empty($_REQUEST['order_ids'])) {
        foreach ($_REQUEST['order_ids'] as $order_id) {
            $order_info = fn_get_order_info($order_id);
            if ($order_info['parent_order_id'] == 0) {
                $parent_order_ids = db_get_fields('select order_id from ?:orders WHERE parent_order_id = ?i ', $order_info['order_id']);
                foreach ($parent_order_ids as $parent_order_id) {
                    fn_change_order_status($parent_order_id, $_REQUEST['status'], '', fn_get_notification_rules($_REQUEST));
                }
            }
        }
    }
}