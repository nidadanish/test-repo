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
use Tygh\Enum\YesNo;
if (!defined('BOOTSTRAP')) {
die('Access denied');
}

function fn_ab__stickers_validate_dynamic_sticker($conditions = [], $product = [], $product_ids = [], $auth = [])
{
if (empty($conditions['conditions'])) {
return ['result' => false];
}
if (empty($conditions['set'])) {
$conditions['set'] = 'all';
}
$schema = fn_get_schema('ab__stickers', 'conditions')['dynamic'];
$res = $conditions['set'] == 'any' ? false : true;
$placeholders = [];
foreach ($conditions['conditions'] as $condition) {
if (!empty($schema['conditions'][$condition['condition']])) {
$condition_schema = $schema['conditions'][$condition['condition']];
list($_res, $_placeholders) = call_user_func_array($condition_schema['validate_function'][0], [$condition, &$product, $product_ids, $auth]);
$placeholders = array_merge($placeholders, $_placeholders);
} else {
$_res = false;
}
if ($conditions['set'] == 'any') {
$res = $res || $_res;
} else {
$res = $res && $_res;
}
}
return ['result' => $res, 'placeholders' => $placeholders];
}

function fn_ab__stickers_compare_numbers($number_1 = 0, $operator = '', $number_2 = 0)
{
$res = false;
switch ($operator) {
case 'eq':
$res = $number_1 == $number_2;
break;
case 'neq':
$res = $number_1 != $number_2;
break;
case 'lte':
$res = $number_1 <= $number_2;
break;
case 'gte':
$res = $number_1 >= $number_2;
break;
case 'lt':
$res = $number_1 < $number_2;
break;
case 'gt':
$res = $number_1 > $number_2;
break;
default:
fn_set_hook('ab__stickers_compare_numbers', $number_1, $operator, $number_2, $res);
}
return (bool) $res;
}

function fn_ab__stickers_validate_discount($condition, $product, $product_ids, $auth)
{
$res = false;
$discount = empty($product['discount_prc']) ? (empty($product['list_discount_prc']) ? 0 : $product['list_discount_prc']) : $product['discount_prc'];
if ($discount) {
$res = fn_compare_values_by_operator($discount, $condition['operator'], $condition['value']);
}
return [$res, [
'[discount]' => intval($discount),
]];
}

function fn_ab__stickers_validate_discount_sum($condition, $product, $product_ids, $auth)
{
$res = false;
$discount = empty($product['discount']) ? (empty($product['list_discount']) ? 0 : $product['list_discount']) : $product['discount'];
if ($discount) {
$res = fn_compare_values_by_operator($discount, $condition['operator'], $condition['value']);
}
return [$res, [
'[discount_sum]' => intval($discount),
]];
}

function fn_ab__stickers_validate_free_shipping($condition, $product, $product_ids, $auth)
{
return [$product['free_shipping'] === YesNo::YES, []];
}

function fn_ab__stickers_validate_qty_discount($condition, $product, $product_ids, $auth)
{
$res = false;
$placeholders = [];
static $prices = [];
$product_ids = implode(',', $product_ids);
if (empty($prices[$product_ids])) {
$prices[$product_ids] = db_get_hash_multi_array('SELECT * FROM ?:product_prices
WHERE product_id IN (?p) AND lower_limit > 1 AND usergroup_id IN (?n)', ['product_id', 'lower_limit'], $product_ids, array_merge([USERGROUP_ALL], $auth['usergroup_ids']));
}
$product_prices = isset($prices[$product_ids][$product['product_id']]) ? $prices[$product_ids][$product['product_id']] : [];
if (!empty($product_prices)) {
foreach ($product_prices as $product_price) {
if (fn_compare_values_by_operator($product_price['lower_limit'], $condition['operator'], $condition['value'])) {
$res = true;
break;
}
}
$min_qty_discount = array_shift($product_prices);
$placeholders = [
'[min_qty_discount_count]' => $min_qty_discount['lower_limit'],
'[min_qty_discount_price]' => $min_qty_discount['price'],
'[min_qty_discount_percentage]' => $min_qty_discount['percentage_discount'],
];
}
return [$res, $placeholders];
}

function fn_ab__stickers_validate_rating($condition, $product, $product_ids, $auth)
{
$res = false;
$placeholders = [];
if (Registry::get('addons.discussion.status') == ObjectStatuses::ACTIVE || Registry::get('addons.product_reviews.status') == ObjectStatuses::ACTIVE) {
if (empty($product['average_rating']) && is_callable('fn_get_discussion')) {
$product['discussion'] = fn_get_discussion($product['product_id'], \Tygh\Enum\Addons\Discussion\DiscussionObjectTypes::PRODUCT, true, $_REQUEST);
if (!empty($product['discussion'])) {
$product['average_rating'] = $product['discussion']['average_rating'];
}
}
if (!empty($product['average_rating'])) {
$res = fn_compare_values_by_operator(sprintf('%.2f', $product['average_rating']), $condition['operator'], sprintf('%.2f', $condition['value']));
$placeholders = [
'[rating]' => sprintf('%.1f', $product['average_rating']),
];
}
}
return [$res, $placeholders];
}

function fn_ab__stickers_validate_pre_order($condition, $product, $product_ids, $auth)
{
$res = false;
$placeholders = [];
if (!empty($product['avail_since']) && $product['avail_since'] > TIME
&& $product['out_of_stock_actions'] == \Tygh\Enum\OutOfStockActions::BUY_IN_ADVANCE
&& fn_compare_values_by_operator($product['avail_since'], $condition['operator'], strtotime($condition['value']))
) {
$res = true;
$placeholders = [
'[avail_since]' => fn_date_format($product['avail_since'], Registry::get('settings.Appearance.date_format')),
];
}
return [$res, $placeholders];
}

function fn_ab__stickers_validate_promotions($condition, $product, $product_ids, $auth)
{
$res = false;
if (!empty($product['promotions'])) {
foreach (explode(',', $condition['value']) as $promotion) {
$in_array = isset($product['promotions'][$promotion]);
$res = $res || ($condition['operator'] == 'in' ? $in_array : !$in_array);
}
}
return [$res, []];
}

function fn_ab__stickers_validate_price($condition, $product, $product_ids, $auth)
{
return [fn_compare_values_by_operator($product['price'], $condition['operator'], $condition['value']), [
'[price]' => fn_format_price($product['price']),
]];
}

function fn_ab__stickers_validate_categories($condition, $product, $product_ids, $auth)
{
$res = $condition['operator'] === 'in' ? false : true;
$sticker_cats = explode(',', $condition['value']);
if (!empty($condition['include_subcats']) && $condition['include_subcats'] == YesNo::YES) {
static $cats_list = [];
if (empty($cats_list)) {

$storefront = Tygh::$app['storefront'];
$company_ids = $storefront->getCompanyIds();
$query_part = '';
if (!empty($company_ids)) {
$query_part .= db_quote(' AND company_id IN (?n)', $company_ids);
}
$_ids = db_get_array('SELECT category_id, id_path FROM ?:categories WHERE status = ?s?p', ObjectStatuses::ACTIVE, $query_part);
for ($i = 0; $i < count($_ids); $i++) {
foreach (explode('/', $_ids[$i]['id_path']) as $id) {
$cats_list[$id][] = $_ids[$i]['category_id'];
}
}
}
foreach (explode(',', $condition['value']) as $sticker_cat) {
$sticker_cats = fn_array_merge($sticker_cats, $cats_list[$sticker_cat], false);
}
}
foreach ($sticker_cats as $category_id) {
if ($condition['operator'] === 'in' && in_array($category_id, $product['category_ids'])) {
$res = true;
break;
}
$res = $res && !in_array($category_id, $product['category_ids']);
}
return [$res, []];
}

function fn_ab__stickers_validate_amount($condition, $product, $product_ids, $auth)
{
return [fn_compare_values_by_operator($product['amount'], $condition['operator'], $condition['value']), [
'[amount]' => $product['amount'],
]];
}

function fn_ab__stickers_validate_weight($condition, $product, $product_ids, $auth)
{
return [fn_compare_values_by_operator($product['weight'], $condition['operator'], $condition['value']), [
'[weight]' => $product['weight'],
'[ceil_integer_weight]' => ceil($product['weight']),
]];
}

function fn_ab__stickers_validate_vendor_plans($condition, $product, $product_ids, $auth)
{
$res = false;
static $plans = [];
if (fn_allowed_for('MULTIVENDOR') && Registry::get('addons.vendor_plans.status') == ObjectStatuses::ACTIVE) {
if (empty($plans[$product['product_id']])) {
$plans[$product['product_id']] = db_get_field('SELECT plan_id FROM ?:companies WHERE company_id = ?i', $product['company_id']);
}
$res = fn_compare_values_by_operator($condition['value'], $condition['operator'], $plans[$product['product_id']]);
}
return [$res, []];
}

function fn_ab__stickers_validate_feature($condition, $product, $product_ids, $auth)
{
$res = false;
$placeholders = [];
static $features = [];
if (empty($features[$condition['condition_element']][$product['product_id']])) {
$features[$condition['condition_element']][$product['product_id']] = fn_get_product_features_list($product, Tygh\Enum\ProductFeaturesDisplayOn::ALL);
}
if (!empty($features[$condition['condition_element']][$product['product_id']][$condition['condition_element']]['variant'])) {
$res = true;
$placeholders = [
'[feature_' . $condition['condition_element'] . '_value]' => $features[$condition['condition_element']][$product['product_id']][$condition['condition_element']]['variant'],
];
} else if (!empty($features[$condition['condition_element']][$product['product_id']][$condition['condition_element']]['value'])) {
$res = true;
$placeholders = [
'[feature_' . $condition['condition_element'] . '_value]' => $features[$condition['condition_element']][$product['product_id']][$condition['condition_element']]['value'],
];
}
return [$res, $placeholders];
}
