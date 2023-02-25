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
use Tygh\Languages\Languages;
use Tygh\Enum\ObjectStatuses;
if (!defined('BOOTSTRAP')) {
die('Access denied');
}
foreach (glob(Registry::get('config.dir.addons') . '/ab__stickers/functions/fn.ab__s.*.php') as $functions) {
require_once $functions;
}

function fn_ab__stickers_get_enum_list($enum = 'StickerStyles')
{
$enum = 'Tygh\Enum\Addons\Ab_stickers\\' . $enum;
return $enum::getAll();
}

function fn_ab__stickers_update_sticker($sticker_id, $params, $lang_code = DESCR_SL)
{
$default_params = [];
$params = array_merge($default_params, $params);
$sticker_data = $params['sticker_data'];
foreach (['name_for_admin', 'name_for_desktop', 'name_for_mobile'] as $clearing_field) {
if (isset($sticker_data[$clearing_field])) {
$sticker_data[$clearing_field] = strip_tags($sticker_data[$clearing_field], implode('', fn_ab__stickers_get_available_tags()));
}
}
if (isset($sticker_data['appearance'])) {
$sticker_data['appearance'] = serialize($sticker_data['appearance']);
}
if (isset($sticker_data['display_on_lists'])) {
$sticker_data['display_on_lists'] = serialize($sticker_data['display_on_lists']);
}
if (isset($sticker_data['conditions'])) {
fn_ab__stickers_check_group_conditions($sticker_data['conditions']);
$sticker_data['conditions'] = serialize($sticker_data['conditions']);
}
$sticker_data['from_date'] = empty($sticker_data['from_date']) ? 0 : fn_parse_date($sticker_data['from_date']);
$sticker_data['to_date'] = empty($sticker_data['to_date']) ? 0 : fn_parse_date($sticker_data['to_date'], true);
if (isset($sticker_data['image_id'])) {
unset($sticker_data['image_id']);
}
if (empty($sticker_data['storefront_ids'])) {
if (empty(Tygh::$app['session']['auth']['company_id'])) {
$company_id = fn_get_runtime_company_id();
} else {
$company_id = Tygh::$app['session']['auth']['company_id'];
}
$storefronts = Tygh::$app['storefront.repository']->findByCompanyId($company_id, false);
if (empty($storefronts)) {
list($storefronts) = Tygh::$app['storefront.repository']->find();
}
$sticker_data['storefront_ids'] = implode(',', array_keys($storefronts));
}
if ($sticker_id == 0) {
$sticker_data['sticker_id'] = $sticker_id = db_query('INSERT INTO ?:ab__stickers ?e', $sticker_data);
$prev_image_id = 0;
foreach (Languages::getSimpleLanguages() as $sticker_data['lang_code'] => $v) {
db_query('INSERT INTO ?:ab__sticker_descriptions ?e', $sticker_data);
$sticker_image_id = db_query('INSERT INTO ?:ab__sticker_images ?e', ['image_id' => '',
'sticker_id' => $sticker_id,
'lang_code' => $sticker_data['lang_code'],
]);
if ($prev_image_id == 0) {
fn_attach_image_pairs('ab__sticker_img', 'ab__stickers', $sticker_image_id, $sticker_data['lang_code']);
$prev_image_id = $sticker_image_id;
} else {
fn_clone_image_pairs($sticker_image_id, $prev_image_id, 'ab__stickers', $sticker_data['lang_code']);
}
}
} else {
db_query('UPDATE ?:ab__stickers SET ?u WHERE sticker_id = ?i', $sticker_data, $sticker_id);
$descr_cond = db_quote('WHERE sticker_id = ?i AND lang_code = ?s', $sticker_id, $lang_code);
if (db_get_field('SELECT sticker_id FROM ?:ab__sticker_descriptions ?p', $descr_cond)) {
db_query('UPDATE ?:ab__sticker_descriptions SET ?u ?p', $sticker_data, $descr_cond);
} else {
$sticker_data['sticker_id'] = $sticker_id;
$sticker_data['lang_code'] = $lang_code;
db_query('INSERT INTO ?:ab__sticker_descriptions ?e', $sticker_data);
}
$sticker_image_id = db_get_field('SELECT image_id FROM ?:ab__sticker_images WHERE sticker_id = ?i AND lang_code = ?s', $sticker_id, $lang_code);
if (empty($sticker_image_id)) {
$sticker_image_id = db_query('INSERT INTO ?:ab__sticker_images ?e', [
'image_id' => '',
'sticker_id' => $sticker_id,
'lang_code' => $lang_code,
]);
}
fn_attach_image_pairs('ab__sticker_img', 'ab__stickers', $sticker_image_id, $lang_code);
}

$repository = Tygh::$app['addons.ab__stickers.repository'];
if (empty($sticker_data['hash'])) {
$repository->getHash($sticker_id, $sticker_data);
}
return $sticker_id;
}

function fn_ab__stickers_check_group_conditions(&$conditions)
{
if (!empty($conditions['conditions'])) {
$conditions['conditions'] = array_filter($conditions['conditions'], function ($value) {
return ($value['operator'] === 'not_empty') || (isset($value['value']) && !is_null($value['value']) && fn_string_not_empty($value['value']));
});
}
}

function fn_ab_stickers_clone_sticker($item_id)
{

$repository = Tygh::$app['addons.ab__stickers.repository'];
$old_data = $repository->findById($item_id);
if (empty($old_data)) {
return false;
}
unset($old_data['sticker_id'], $old_data['image_id']);
$old_data['status'] = ObjectStatuses::DISABLED;
$old_data['lang_code'] = DESCR_SL;
$old_data['name_for_admin'] .= ' ' . __('ab__stickers.cloned', [], DESCR_SL);
$new_id = fn_ab__stickers_update_sticker(0, ['sticker_data' => $old_data], DESCR_SL);
foreach (array_keys(Languages::getSimpleLanguages()) as $lang_code) {
if ($lang_code != DESCR_SL) {
$old_data = $repository->findById($item_id, $lang_code);
unset($old_data['sticker_id'], $old_data['image_id']);
$old_data['status'] = 'D';
$old_data['lang_code'] = $lang_code;
$old_data['name_for_admin'] .= ' ' . __('ab__stickers.cloned', [], DESCR_SL);
fn_ab__stickers_update_sticker($new_id, ['sticker_data' => $old_data], $lang_code);
}
}
foreach (['manual', 'generated'] as $filling) {
$product_ids = db_get_field("SELECT CONCAT(product_id) FROM ?:products WHERE FIND_IN_SET(?i, ab__stickers_{$filling}_ids)", $item_id);
fn_ab__stickers_attach_sticker_to_products($new_id, $product_ids, $filling);
}
return $new_id;
}

function fn_ab__stickers_attach_sticker_to_products($sticker_id, $product_ids = [], $filling = 'manual')
{
$query = "SELECT product_id, ab__stickers_{$filling}_ids FROM ?:products WHERE 1";
$old_products_with_current_sticker = db_get_array($query . " AND FIND_IN_SET(?i, ab__stickers_{$filling}_ids) AND product_id NOT IN (?n)", $sticker_id, $product_ids);
if (!empty($old_products_with_current_sticker)) {
for ($i = 0; $i < count($old_products_with_current_sticker); $i++) {
$sticker_ids = array_flip(explode(',', $old_products_with_current_sticker[$i]['ab__stickers_' . $filling . '_ids']));
unset($sticker_ids[$sticker_id]);
$old_products_with_current_sticker[$i]['ab__stickers_' . $filling . '_ids'] = implode(',', array_keys($sticker_ids));
}
db_query("INSERT INTO ?:products ?m ON DUPLICATE KEY UPDATE ab__stickers_{$filling}_ids=VALUES(ab__stickers_{$filling}_ids)", $old_products_with_current_sticker);
}
$new_products = db_get_array($query . " AND (NOT FIND_IN_SET(?i, ab__stickers_{$filling}_ids) OR ab__stickers_{$filling}_ids IS NULL) AND product_id IN (?n)", $sticker_id, $product_ids);
if (!empty($new_products)) {
for ($i = 0; $i < count($new_products); $i++) {
$temp = [];
if (strlen(trim($new_products[$i]['ab__stickers_' . $filling . '_ids'])) !== 0) {
$temp = explode(',', $new_products[$i]['ab__stickers_' . $filling . '_ids']);
}
$temp[] = $sticker_id;
$new_products[$i]['ab__stickers_' . $filling . '_ids'] = implode(',', $temp);
}
db_query("INSERT INTO ?:products ?m ON DUPLICATE KEY UPDATE ab__stickers_{$filling}_ids=VALUES(ab__stickers_{$filling}_ids)", $new_products);
}
if ($filling !== 'manual') {
db_query('UPDATE ?:ab__stickers SET last_update_time = ?i WHERE sticker_id = ?i', TIME, $sticker_id);
}
}

function fn_ab__stickers_get_sticker_condition_variants($func_and_params = [])
{
$ret = [];
$f = array_shift($func_and_params);
if (function_exists($f)) {
$ret = call_user_func_array($f, $func_and_params);
}
return $ret;
}

function fn_ab__stickers_get_simple_tags()
{
return db_get_hash_single_array('SELECT tag_id, tag FROM ?:tags WHERE status = ?s AND company_id = ?i', ['tag_id', 'tag'], ObjectStatuses::ACTIVE, fn_get_runtime_company_id());
}

function fn_ab__stickers_get_simple_promotions()
{
return db_get_hash_single_array('SELECT p.promotion_id, name FROM ?:promotions AS p LEFT JOIN ?:promotion_descriptions AS pd ON p.promotion_id = pd.promotion_id AND lang_code = ?s WHERE status = ?s AND company_id = ?i AND zone = "catalog"', ['promotion_id', 'name'], DESCR_SL, ObjectStatuses::ACTIVE, fn_get_runtime_company_id());
}

function fn_ab__stickers_get_simple_vendor_plans()
{
return db_get_hash_single_array('SELECT v.plan_id, plan FROM ?:vendor_plans AS v LEFT JOIN ?:vendor_plan_descriptions AS vd ON v.plan_id = vd.plan_id AND lang_code = ?s WHERE status = ?s', ['plan_id', 'plan'], DESCR_SL, ObjectStatuses::ACTIVE);
}

function fn_ab__stickers_get_category_page_layout_template()
{
$selected_layout = fn_get_products_layout($_REQUEST);
$current_tmpl = '';
if ($selected_layout == 'products_multicolumns') {
$current_tmpl = 'blocks/products/products_multicolumns.tpl';
} elseif ($selected_layout == 'products_without_options') {
$current_tmpl = 'blocks/products/products.tpl';
} elseif ($selected_layout == 'short_list') {
$current_tmpl = 'blocks/products/short_list.tpl';
} else {

fn_set_hook('ab__stickers_get_custom_list_template', $selected_layout, $current_tmpl);
}

fn_set_hook('ab__stickers_get_category_page_layout_template', $selected_layout, $current_tmpl);
return $current_tmpl;
}

function fn_ab__stickers_get_sticker_string_value($string = '', $placeholders = [])
{
if (is_array($placeholders)) {
$placeholders = array_merge($placeholders, [
'[end_line]' => '<br/>',
]);
$string = str_replace(array_keys($placeholders), $placeholders, $string);
}

fn_set_hook('ab__stickers_get_sticker_string_value_post', $string, $placeholders);
return $string;
}

function fn_ab__stickers_prepare_sticker_to_frontend($sticker_data = [], $cache_name = '')
{
$html = Tygh::$app['view']->assign('sticker', $sticker_data)->fetch('addons/ab__stickers/views/ab__stickers/components/sticker.tpl');
$key = "{$cache_name}.{$sticker_data['sticker_id']}-{$sticker_data['hash']}";
Registry::set($key, ['data' => $sticker_data, 'html' => $html]);
$sticker_key = $sticker_data['sticker_id'] . '-' . $sticker_data['hash'] . '-' . CART_LANGUAGE . (empty($sticker_data['placeholders']) ? '' : '-' . md5(serialize($sticker_data['placeholders'])));
return [$html, $sticker_key];
}

function fn_ab__stickers_change_stickers_status($sticker_ids = [], $status = ObjectStatuses::ACTIVE)
{
return db_query('UPDATE ?:ab__stickers SET status = ?s WHERE sticker_id IN (?n)', $status, $sticker_ids);
}

function fn_ab__stickers_sticker_with_condition_exist($condition = '')
{
return !empty(db_get_field('SELECT sticker_id FROM ?:ab__stickers WHERE FIND_IN_SET(?i, storefront_ids) AND conditions LIKE "%?p%"', Tygh::$app['storefront']->storefront_id, $condition));
}

function fn_ab__stickers_sticker_is_cache_allowed()
{
return Tygh\BlockManager\RenderManager::allowCache();
}

function fn_ab__stickers_sticker_get_ts_appearance_styles()
{
$appearance_styles = [
'rectangular' => __('ab__stickers.appearance_style.rectangular'),
'rounded' => __('ab__stickers.appearance_style.rounded'),
'teardrop' => __('ab__stickers.appearance_style.teardrop'),
'beveled_angle' => __('ab__stickers.appearance_style.beveled_angle'),
'circle' => __('ab__stickers.appearance_style.circle'),
];

fn_set_hook('ab__stickers_get_appearance_styles', $appearance_styles);
return $appearance_styles;
}

function fn_ab__stickers_form_conditions_optgroups($conditions = [])
{
$conditions_optgroups = [];
foreach ($conditions as $name => $condition) {
$conditions_optgroups[isset($condition['group']) ? $condition['group'] : 'ab__stickers.condition_groups.default'][$name] = $condition;
}
return $conditions_optgroups;
}

function fn_ab__stickers_get_prohibited_list_positions()
{
static $prohibited_list_positions = [];
if (empty($prohibited_list_positions)) {
$prohibited_list_positions = [];
foreach (fn_get_schema('ab__stickers', 'display') as $tmpl_path => $product_template) {
if (!empty($product_template['prohibited_list_positions'])) {
$prohibited_list_positions[$tmpl_path] = $product_template['prohibited_list_positions'];
}
}

fn_set_hook('ab__stickers_get_prohibited_list_positions', $prohibited_list_positions);
}
return $prohibited_list_positions;
}

function fn_ab__stickers_get_available_tags()
{
$available_tags = [
'<span>',
'<rt>',
'<ins>',
'<sub>',
'<s>',
'<strike>',
'<sup>',
'<mark>',
'<strong>',
'<i>',
'<em>',
'<big>',
'<small>',
'<b>',
];
fn_set_hook('ab__stickers_get_available_tags', $available_tags);
return $available_tags;
}

function fn_ab__stickers_get_templates_display_size($key = '', array $sticker_data = [])
{
$tmp = substr(substr($key, 1), 0, strlen($key) - 2);
$tmp = explode('][', $tmp);
$val = '';
foreach ($tmp as $arr_key) {
if (!empty($sticker_data[$arr_key])) {
$sticker_data = $val = $sticker_data[$arr_key];
}
}
return $val;
}

function fn_ab__stickers_hex_to_rgba($color, $opacity = false) {
$default = 'rgb(0,0,0)';
if(empty($color))
return $default;
if (strpos($opacity, '%') !== false) {
$opacity = intval($opacity) / 100;
}
if ($color[0] == '#' ) {
$color = substr( $color, 1 );
}
if (strlen($color) == 6) {
$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
} else {
return $default;
}
$rgb = array_map('hexdec', $hex);
if ($opacity){
if (abs($opacity) > 1) {
$opacity = 1.0;
}
$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
} else {
$output = 'rgb('.implode(",",$rgb).')';
}
return $output;
}
