<?php
/*******************************************************************************************
*   ___  _          ______                     _ _                _                        *
*  / _ \| |         | ___ \                   | (_)              | |              © 2021   *
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
use Tygh\Enum\YesNo;
use Tygh\Registry;
$menu_settings = [
'abt__ut2_filling_type' => [
'type' => 'template',
'default_value' => 'column_filling',
'template' => 'addons/abt__unitheme2/views/abt__ut2/components/block_manager/menu_filling_type.tpl',
'values' => [
'column_filling' => [
'show_fields' => [
'abt__ut2_columns_count',
],
],
'row_filling' => [
'show_fields' => [
'abt__ut2_columns_count',
],
],
],
],
'abt__ut2_columns_count' => [
'type' => 'selectbox',
'default_value' => '4',
'values' => [
'2' => 'abt__ut2_columns_count.2',
'3' => 'abt__ut2_columns_count.3',
'4' => 'abt__ut2_columns_count.4',
'5' => 'abt__ut2_columns_count.5',
'6' => 'abt__ut2_columns_count.6',
],
],
'abt_menu_icon_items' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
'tooltip' => __('abt_menu_icon_items.tooltip'),
],
'no_hidden_elements_second_level_view' => [
'type' => 'input',
'default_value' => '5',
'tooltip' => __('no_hidden_elements_second_level_view.tooltip'),
],
'elements_per_column_third_level_view' => [
'type' => 'input',
'default_value' => '10',
'tooltip' => __('elements_per_column_third_level_view.tooltip'),
],
'dropdown_second_level_elements' => [
'type' => 'input',
'default_value' => '12',
],
'dropdown_third_level_elements' => [
'type' => 'input',
'default_value' => '6',
],
'abt_menu_ajax_load' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
'tooltip' => __('abt_menu_ajax_load.tooltip'),
],
'abt__ut2_view_more_btn_behavior' => [
'type' => 'selectbox',
'values' => [
'view_items' => 'abt__ut2_view_more_btn_behavior_view_items',
'trigger_parent_link' => 'abt__ut2_view_more_btn_behavior_trigger_parent_link',
],
'tooltip' => __('abt__ut2_view_more_btn_behavior.tooltip'),
'default_value' => 'view_items',
],
'abt__ut2_menu_min_height' => [
'option_name' => 'abt__ut2.settings.general.menu_min_height',
'tooltip' => __('abt__ut2.settings.general.menu_min_height.tooltip'),
'type' => 'input',
'default_value' => Registry::ifGet('settings.abt__ut2.general.menu_min_height', 490),
],
];
$schema['blocks/menu/abt__ut2_dropdown_horizontal_mwi.tpl'] = [
'settings' => array_merge([
'abt_menu_long_names' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
'tooltip' => __('abt_menu_long_names.tooltip'),
],
'abt_menu_long_names_max_width' => [
'type' => 'input',
'default_value' => '100',
'tooltip' => __('abt_menu_long_names_max_width.tooltip'),
],
'abt__menu_add_horizontal_scroll_sections' => [
'type' => 'checkbox',
'default_value' => YesNo::YES,
'tooltip' => __('abt__menu_add_horizontal_scroll_sections.tooltip'),
],
], $menu_settings),
];
$schema['blocks/menu/abt__ut2_dropdown_vertical_mwi.tpl'] = [
'settings' => array_merge([], $menu_settings),
];
$tmpls = [
'blocks/products/products_multicolumns.tpl',
'blocks/products/products_without_options.tpl',
];
if (!empty($tmpls)) {
foreach ($tmpls as $tmpl) {
$schema[$tmpl]['bulk_modifier']['fn_abt__ut2_add_products_features_list'] = ['products' => '#this'];
}
}

$schema['blocks/products/products_scroller_advanced.tpl'] = [
'settings' => [
'show_price' => [
'type' => 'checkbox',
'default_value' => YesNo::YES,
],
'enable_quick_view' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
],
'not_scroll_automatically' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
],
'scroll_per_page' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
],
'thumbnail_width' => [
'type' => 'input',
'default_value' => Registry::get('settings.Thumbnails.product_lists_thumbnail_width'),
],
'abt__ut2_thumbnail_height' => [
'type' => 'input',
'default_value' => Registry::get('settings.Thumbnails.product_lists_thumbnail_height'),
],
'speed' => [
'type' => 'input',
'default_value' => 400,
],
'pause_delay' => [
'type' => 'input',
'default_value' => 3,
],
'item_quantity' => [
'type' => 'input',
'default_value' => 5,
],
'outside_navigation' => [
'type' => 'checkbox',
'default_value' => YesNo::YES,
],
],
'bulk_modifier' => [
'fn_gather_additional_products_data' => [
'products' => '#this',
'params' => [
'get_icon' => true,
'get_detailed' => true,
'get_options' => true,
'get_additional' => true,
],
],
],
];


$schema['addons/blog/blocks/abt_ut2_recent_posts.tpl']['params'] = [
'limit' => 7,
];
return $schema;
