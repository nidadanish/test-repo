<?php
require 'hooks.php';

function fn_get_vendor_profit($order_id)
{
    $profit = 0;
    $order_info = fn_get_order_info($order_id);
    foreach ($order_info['products'] as $product) {
        $price = db_get_field('select price from ?:product_prices where product_id = ?i', $product['product_id']);
        $product = fn_ec_vendor_cost_get_custom_price_data($product, []);
        $profit += $product['price'] - $price;
    }

    return $profit;
}