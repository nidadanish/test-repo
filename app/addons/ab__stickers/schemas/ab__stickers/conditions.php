<?php
/*******************************************************************************************
*   ___  _          ______                     _ _                _                        *
*  / _ \| |         | ___ \                   | (_)              | |              © 2022   *
* / /_\ | | _____  _| |_/ /_ __ __ _ _ __   __| |_ _ __   __ _   | |_ ___  __ _ _ __ ___   *
* |  _  | |/ _ \ \/ / ___ \ '__/ _` | '_ \ / _` | | '_ \ / _` |  | __/ _ \/ _` | '_ ` _ \  *
* | | | | |  __/>  <| |_/ / | | (_| | | | | (_| | | | | | (_| |  | ||  __/ (_| | | | | | | *
* \_| |_/_|\___/_/\_\____/|_|  \__,_|_| |_|\__,_|_|_| |_|\__, |  \___\___|\__,_|_| |_| |_| *
*                                                         __/ |                            *
*                                                        |___/                             *
* ---------------------------------------------------------------------------------------- *
* This is commercial software, only users who have purchased a valid license and accept    *
* to the terms of the License Agreement can install and use this program.                  *
* ---------------------------------------------------------------------------------------- *
* website: https://cs-cart.alexbranding.com                                                *
*   email: info@alexbranding.com                                                           *
*******************************************************************************************/
use Tygh\Registry;
use Tygh\Enum\ObjectStatuses;
if (!defined('BOOTSTRAP')) {
die('Access denied');
}
$schema = [
'constant' => [
'conditions' => [
'price' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'format_function' => 'fn_format_price',
],
'feature' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt', 'in', 'nin'],
'type' => 'chained',
'chained_options' => [
'parent_url' => 'product_features.get_features_list',
],
],
'categories' => [
'operators' => ['in', 'nin'],
'type' => 'picker',
'template' => 'addons/ab__stickers/views/ab__stickers/components/conditions/include_subcats.tpl',
'picker_props' => [
'picker' => 'pickers/categories/picker.tpl',
'params' => [
'multiple' => true,
'use_keys' => 'N',
'view_mode' => 'table',
],
],
],
'amount' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'field' => 'amount',
'additional_classes' => 'cm-value-integer',
],
'popularity' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'additional_classes' => 'cm-value-integer',
],
'weight' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'additional_classes' => 'cm-value-decimal',
'decimal_format' => '%.3f',
],
'creating_date' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'additional_classes' => 'cm-value-integer',
'tooltip' => 'ab__stickers.conditions.names.creating_date.tooltip',
],
'free_shipping' => [
'type' => 'statement',
'template' => 'addons/ab__stickers/views/ab__stickers/components/conditions/free_shipping_additional_tmpl.tpl',
],
],
],
'dynamic' => [
'conditions' => [
'price' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'format_function' => 'fn_format_price',
'available_placeholders' => [
'[price]' => [
'title' => 'ab__stickers.conditions.placeholders.price',
'default_value' => random_int(10, 900),
],
],
'validate_function' => ['fn_ab__stickers_validate_price'],
],
'discount' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'additional_classes' => 'cm-value-integer',
'validate_function' => ['fn_ab__stickers_validate_discount'],
'available_placeholders' => [
'[discount]' => [
'title' => 'ab__stickers.conditions.placeholders.discount',
'default_value' => random_int(10, 90),
],
],
'template' => 'addons/ab__stickers/views/ab__stickers/components/conditions/discount_additional_tmpl.tpl',
],
'discount_sum' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'additional_classes' => 'cm-value-integer',
'validate_function' => ['fn_ab__stickers_validate_discount_sum'],
'available_placeholders' => [
'[discount_sum]' => [
'title' => 'ab__stickers.conditions.placeholders.discount_sum',
'default_value' => random_int(100, 900),
],
],
'template' => 'addons/ab__stickers/views/ab__stickers/components/conditions/discount_additional_tmpl.tpl',
],
'categories' => [
'operators' => ['in', 'nin'],
'type' => 'picker',
'template' => 'addons/ab__stickers/views/ab__stickers/components/conditions/include_subcats.tpl',
'validate_function' => ['fn_ab__stickers_validate_categories'],
'picker_props' => [
'picker' => 'pickers/categories/picker.tpl',
'params' => [
'multiple' => true,
'use_keys' => 'N',
'view_mode' => 'table',
],
],
],
'free_shipping' => [
'type' => 'statement',
'validate_function' => ['fn_ab__stickers_validate_free_shipping'],
'template' => 'addons/ab__stickers/views/ab__stickers/components/conditions/free_shipping_additional_tmpl.tpl',
],
'qty_discounts' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'validate_function' => ['fn_ab__stickers_validate_qty_discount'],
'available_placeholders' => [
'[min_qty_discount_count]' => [
'title' => 'ab__stickers.conditions.placeholders.min_qty_discount_count',
'default_value' => random_int(1, 10),
],
'[min_qty_discount_price]' => [
'title' => 'ab__stickers.conditions.placeholders.min_qty_discount_price',
'default_value' => random_int(10, 900),
],
'[min_qty_discount_percentage]' => [
'title' => 'ab__stickers.conditions.placeholders.min_qty_discount_percentage',
'default_value' => random_int(10, 90),
],
],
],
'pre_order' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'date',
'validate_function' => ['fn_ab__stickers_validate_pre_order'],
'available_placeholders' => [
'[avail_since]' => [
'title' => 'ab__stickers.conditions.placeholders.avail_since',
],
],
],
'promotion' => [
'operators' => ['in', 'nin'],
'type' => 'select',
'variants_function' => ['fn_ab__stickers_get_simple_promotions'],
'validate_function' => ['fn_ab__stickers_validate_promotions'],
],
'amount' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'field' => 'amount',
'additional_classes' => 'cm-value-integer',
'validate_function' => ['fn_ab__stickers_validate_amount'],
'available_placeholders' => [
'[amount]' => [
'title' => 'ab__stickers.conditions.placeholders.amount',
'default_value' => random_int(5, 15),
],
],
],
'weight' => [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'additional_classes' => 'cm-value-decimal',
'decimal_format' => '%.3f',
'validate_function' => ['fn_ab__stickers_validate_weight'],
'available_placeholders' => [
'[weight]' => [
'title' => 'ab__stickers.conditions.placeholders.weight',
'default_value' => random_int(5, 15),
],
'[ceil_integer_weight]' => [
'title' => 'ab__stickers.conditions.placeholders.ceil_integer_weight',
'default_value' => random_int(5, 15),
],
],
],
],
],
];
if (Registry::get('addons.tags.status') == ObjectStatuses::ACTIVE) {
$schema['constant']['conditions']['tags'] = [
'operators' => ['eq', 'neq'],
'type' => 'select',
'variants_function' => ['fn_ab__stickers_get_simple_tags'],
];
}
if (Registry::get('addons.bestsellers.status') == ObjectStatuses::ACTIVE) {
$schema['constant']['conditions']['sales_amount'] = [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'additional_classes' => 'cm-value-integer',
];
}
if (Registry::get('addons.discussion.status') == ObjectStatuses::ACTIVE
|| Registry::get('addons.product_reviews.status') == ObjectStatuses::ACTIVE) {
$schema['constant']['conditions']['comments'] = [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'tooltip' => 'ab__stickers.conditions.names.comments.tooltip',
'additional_classes' => 'cm-value-integer',
];
$schema['dynamic']['conditions']['rating'] = [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'tooltip' => 'ab__stickers.conditions.names.rating.tooltip',
'additional_classes' => 'cm-value-decimal',
'validate_function' => ['fn_ab__stickers_validate_rating'],
'available_placeholders' => [
'[rating]' => [
'title' => 'ab__stickers.conditions.placeholders.rating',
'default_value' => random_int(1, 5),
],
],
];
}
if (Registry::get('addons.age_verification.status') == ObjectStatuses::ACTIVE) {
$schema['constant']['conditions']['age_verification'] = [
'operators' => ['eq', 'neq', 'lte', 'gte', 'lt', 'gt'],
'type' => 'input',
'additional_classes' => 'cm-value-integer',
];
}
if (Registry::get('addons.buy_together.status') == ObjectStatuses::ACTIVE) {
$schema['constant']['conditions']['buy_together'] = [
'type' => 'statement',
'tooltip' => 'ab__stickers.conditions.names.buy_together.tooltip',
];
}
return $schema;
