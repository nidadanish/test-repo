<?php
/*******************************************************************************************
*   ___  _          ______                     _ _                _                        *
*  / _ \| |         | ___ \                   | (_)              | |              © 2023   *
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
use Tygh\BlockManager\Block;
use Tygh\Languages\Languages;
use Tygh\Registry;
if (!defined('BOOTSTRAP')) {
die('Access denied');
}
function fn_ab__deal_of_the_day_install_promotions($show_notification = false, $place_into_blocks = false)
{
$path_part = 'ab__data/ab__deal_of_the_day/demodata/promotions';
$path = Registry::get('config.dir.var') . $path_part;
$data = fn_get_contents("{$path}/data.json");
if (empty($data)) {
$string = __('ab__dotd.autoinstall.no_demodata');
return $show_notification ? fn_set_notification('E', __('error'), $string) : $string;
}
$company_id = fn_allowed_for('ULTIMATE') ? fn_get_runtime_company_id() : 0;
$data = json_decode($data, true);
$lang_codes = Languages::getAll();
$img_path = fn_get_files_dir_path() . $path_part;
fn_rm($img_path);
fn_mkdir($img_path);
fn_copy($path, $img_path);
$test_products_ids = db_get_fields('SELECT p.product_id FROM ?:products AS p
INNER JOIN ?:product_descriptions AS pd ON pd.product_id = p.product_id AND pd.lang_code = ?s
INNER JOIN ?:product_prices AS pp ON pp.product_id = p.product_id AND pp.lower_limit = 1 AND pp.usergroup_id = 0
LEFT JOIN ?:products_categories AS pc ON pc.product_id = p.product_id
LEFT JOIN ?:categories AS c ON c.category_id = pc.category_id AND c.status = ?s
WHERE p.amount > 0 AND pp.price > 0 AND p.status = ?s AND c.category_id IS NOT NULL LIMIT 0,20', CART_LANGUAGE, 'A', 'A');
$sets = array_chunk($test_products_ids, 5);
$test_products_ids = [];
foreach ($sets as $set) {
$test_products_ids[] = implode(',', $set);
}
$test_categories_ids = db_get_fields('SELECT c.category_id FROM ?:categories AS c
LEFT JOIN ?:categories AS sub_c ON c.category_id = sub_c.parent_id
WHERE c.status = ?s AND sub_c.category_id IS NULL LIMIT 0,4', 'A');
$test_shippings_ids = db_get_fields('SELECT shipping_id FROM ?:shippings WHERE status = ?s', 'A');
foreach ($data as $promotion) {
$promotion['company_id'] = $company_id;
if (!empty($promotion['conditions']) && !empty($promotion['conditions']['conditions'])) {
foreach ($promotion['conditions']['conditions'] as $key => $condition) {
if ($condition['condition'] == 'products') {
if (($products_ids = next($test_products_ids)) === false) {
$products_ids = reset($test_products_ids);
}
$promotion['conditions']['conditions'][$key]['value'] = $products_ids;
} elseif ($condition['condition'] == 'categories') {
if (($category_id = next($test_categories_ids)) === false) {
$category_id = reset($test_categories_ids);
}
$promotion['conditions']['conditions'][$key]['value'] = $category_id;
}
}
}
if (!empty($promotion['bonuses'])) {
foreach ($promotion['bonuses'] as $key => $bonus) {
if ($bonus['bonus'] == 'discount_on_products') {
if (($products_ids = next($test_products_ids)) === false) {
$products_ids = reset($test_products_ids);
}
$promotion['bonuses'][$key]['value'] = $products_ids;
} elseif ($bonus['bonus'] == 'free_shipping' && !empty($test_shippings_ids)) {
$new_bonus = [];
foreach ($test_shippings_ids as $shipping_id) {
$new_bonus[] = [
'bonus' => 'free_shipping',
'value' => $shipping_id,
];
}
$promotion['bonuses'] = $new_bonus;
break;
}
}
}
if (!empty($promotion['ab__dotd_active'])) {
$promotion['to_date'] = strtotime('+2 week', TIME);
} elseif (!empty($promotion['ab__dotd_awaited'])) {
$promotion['from_date'] = strtotime('+1 week', TIME);
$promotion['to_date'] = strtotime('+1 month', TIME);
} elseif (!empty($promotion['ab__dotd_expired'])) {
$promotion['from_date'] = strtotime('-1 month', TIME);
$promotion['to_date'] = strtotime('-1 week', TIME);
}
$promotion['promotion_id'] = fn_update_promotion($promotion, 0, CART_LANGUAGE);
if (empty($promotion['promotion_id'])) {
continue;
}
if (!empty($promotion['image'])) {
$img = [
"promo_main_image_data" => [
[
'type' => 'M',
'is_new' => true,
'object_id' => $promotion['promotion_id'],
],
],
"file_promo_main_image_icon" => ["{$img_path}/{$promotion['image']}"],
"type_promo_main_image_icon" => ['server'],
];
$_REQUEST = array_merge($_REQUEST, $img);
fn_update_promotion($promotion, $promotion['promotion_id'], CART_LANGUAGE);
}
if (isset($lang_codes['ru'])) {
$promotion = array_merge($promotion, $promotion['ru']);
fn_update_promotion($promotion, $promotion['promotion_id'], 'ru');
}
unset($_REQUEST["promo_main_image_data"], $_REQUEST["file_promo_main_image_icon"], $_REQUEST["type_promo_main_image_icon"]);
$result[$promotion['promotion_id']] = '<a href="' . fn_url('promotions.update?promotion_id=' . $promotion['promotion_id'], 'A') . '">' . fn_get_promotion_name($promotion['promotion_id'], CART_LANGUAGE) . '</a>';
fn_allowed_for('ULTIMATE') && fn_ult_update_share_object($promotion['promotion_id'], 'promotions', $company_id);
}
if ($place_into_blocks) {
list($blocks) = Block::instance()->find([
'type' => 'ab__deal_of_the_day',
'layout_id' => Registry::get('runtime.layout.layout_id'),
]);
if (!empty($blocks)) {
$block = reset($blocks);
$promotion_id = db_get_field('SELECT promotion_id FROM ?:promotions WHERE zone = "catalog" ORDER BY promotion_id DESC LIMIT 1');
$block['content_data'] = [
'override_by_this' => 'Y',
'lang_code' => CART_LANGUAGE,
'content' => [
'promotion' => [
'filling' => 'manually',
'item_ids' => $promotion_id,
],
],
];
$block['apply_to_all_langs'] = 'Y';
Block::instance()->update($block);
}
}
if (empty($result)) {
$string = __('ab__dotd.autoinstall.promotions_not_created');
return $show_notification ? fn_set_notification('E', __('error'), $string) : $string;
}
$string = __('ab__dotd.autoinstall.promotions_created', ['[promotions]' => implode(', ', $result)]);
return $show_notification ? fn_set_notification('N', __('notice'), $string) : $string;
}
