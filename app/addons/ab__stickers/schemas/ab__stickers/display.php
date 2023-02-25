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
use Tygh\BlockManager\SchemesManager;
use Tygh\Enum\Addons\Ab_stickers\OutputPositions;
if (!defined('BOOTSTRAP')) {
die('Access denied');
}
$schema = [
'product_details' => [
'name' => '',
'display_on' => '[display_on_detailed_pages]',
'default_value' => 'full_size',
],
];
$product_templates_scheme = SchemesManager::getBlockScheme('products', [], true)['templates'];
$small_icons_templates = [
'blocks/products/products_scroller.tpl',
'blocks/products/products_small_items.tpl',
'blocks/products/products_links_thumb.tpl'
];
$do_not_show_templates = [
'blocks/products/short_list.tpl'
];
foreach ($product_templates_scheme as $tmpl_path => $product_template) {
if (!in_array($tmpl_path, [
'blocks/products/products_text_links.tpl',
'addons/product_variations/blocks/products/variations_list.tpl'
])) {
$def_val = 'full_size';
if (in_array($tmpl_path, $small_icons_templates)) {
$def_val = 'small_size';
} elseif (in_array($tmpl_path, $do_not_show_templates)) {
$def_val = 'not_display';
}
$schema[$product_template['name']] = [
'display_on' => '[display_on_lists][' . $tmpl_path . ']',
'default_value' => $def_val,
];
if ($tmpl_path == 'blocks/products/products_scroller.tpl') {
$schema[$product_template['name']]['prohibited_list_positions'] = [OutputPositions::BOTTOM];
}
}
}
return $schema;
