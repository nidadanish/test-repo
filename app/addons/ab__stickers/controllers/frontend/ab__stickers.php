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
if (!defined('BOOTSTRAP')) {
die('Access denied');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if ($mode == 'get_stickers') {
if (!empty($_REQUEST['sticker_ids']) && !empty($_REQUEST['controller_mode'])) {
$stickers_html = [];
$position = $_REQUEST['controller_mode'] === 'products.view' ? 'output_position_detailed_page' : 'output_position_list';
$cache_name = 'stickers_' . CART_LANGUAGE . '_' . $position;
Registry::registerCache(['ab__stickers', $cache_name], ['ab__stickers', 'ab__sticker_descriptions'], Registry::cacheLevel('static'));
$ids_keys = array_flip($_REQUEST['sticker_ids']);
foreach ($_REQUEST['sticker_ids'] as $sticker_id) {
$key = "{$cache_name}.$sticker_id";
if (Registry::isExist($key)) {
$stickers_html[$sticker_id] = Registry::get($key)['html'];
unset($_REQUEST['sticker_ids'][$ids_keys[$sticker_id]]);
}
}
if (!empty($_REQUEST['sticker_ids'])) {
$params_sticker = [];
foreach ($_REQUEST['sticker_ids'] as $sticker) {
$params_sticker[] = explode('-', $sticker)[0];
}

$repository = Tygh::$app['addons.ab__stickers.repository'];
list($stickers) = $repository->find([
'item_ids' => $params_sticker,
]);
if (!empty($stickers)) {
$stickers_with_placeholders = [];
if (!empty($_REQUEST['sticker_placeholders'])) {
foreach ($_REQUEST['sticker_placeholders'] as $_placeholders_arr) {
if (isset($_placeholders_arr['placeholders'])) {
$placeholders_arr = unserialize($_placeholders_arr['placeholders']);
$_id = explode('-', $_placeholders_arr['id'])[0];
$stickers_with_placeholders[$_placeholders_arr['id']] = array_merge($stickers[$_id], ['placeholders' => $placeholders_arr, 'html_id' => $_placeholders_arr['id']]);
}
}
}
if (!empty($stickers_with_placeholders)) {
foreach ($stickers_with_placeholders as $sticker) {
if (!empty($stickers[$sticker['sticker_id']])) {
unset($stickers[$sticker['sticker_id']]);
}
list($html, $sticker_key) = fn_ab__stickers_prepare_sticker_to_frontend($sticker, $cache_name);
$stickers_html[$sticker_key] = $html;
}
}
if (!empty($stickers)) {
foreach ($stickers as $sticker) {
list($html, $sticker_key) = fn_ab__stickers_prepare_sticker_to_frontend($sticker, $cache_name);
$stickers_html[$sticker_key] = $html;
}
}
}
}
Tygh::$app['ajax']->assign('stickers_html', $stickers_html);
}
}
return [CONTROLLER_STATUS_NO_CONTENT];
}
