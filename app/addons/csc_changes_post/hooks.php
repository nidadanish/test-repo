<?php

function fn_csc_changes_post_vendor_payouts_get_list($instance, $params, $items_per_page, &$fields, $join, $condition, $date_condition, $sorting, $limit)
{
    if (AREA == 'A') {
        $fields['payout_amount'] = 'IF(payouts.order_id <> 0, payouts.order_amount, payouts.payout_amount)';
    }
}
function fn_csc_changes_post_get_orders_post($params, &$orders)
{
    if (empty($orders)) return;

    foreach ($orders as $key => $order){
        if(!empty($order['is_parent_order']) && $order['is_parent_order'] == 'Y' ){
            $childs = db_get_array("SELECT * FROM ?:orders WHERE parent_order_id =?i and is_sc_united_ship_order != ?s",$order['order_id'],"Y");
            $orders[$key]['childs'] = $childs;
        }
    }
}