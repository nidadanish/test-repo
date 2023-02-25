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
use Tygh\Enum\ObjectStatuses;
$schema['abt__ut2_advanced_subcategories_menu'] = [
'templates' => 'addons/abt__unitheme2/blocks/abt__ut2_advanced_subcategories_menu.tpl',
'content' => [
'abt__ut2_subcategories' => [
'type' => 'function',
'function' => ['fn_abt__ut2_get_sub_or_parent_categories'],
],
],
'settings' => [
'abt__ut2_show_parents' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
],
'abt__ut2_show_siblings' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
],
'abt__ut2_show_children' => [
'type' => 'checkbox',
'default_value' => YesNo::YES,
],
],
'wrappers' => 'blocks/wrappers',
'cache' => [
'update_handlers' => [
'categories',
'category_descriptions',
],
'request_handlers' => ['current_category_id' => '%CATEGORY_ID%'],
],
];
if (!empty($schema['banners'])) {
$schema['banners']['templates']['addons/abt__unitheme2/blocks/abt__ut2_banner_carousel_combined.tpl'] = [
'settings' => [
'margin' => [
'option_name' => 'abt__ut2.option.margin',
'type' => 'input',
'default_value' => '0',
],
'height' => [
'option_name' => 'abt__ut2.option.height',
'type' => 'input',
'default_value' => '400px',
],
'navigation' => [
'type' => 'selectbox',
'values' => [
'N' => 'none',
'D' => 'dots',
'P' => 'pages',
'A' => 'arrows',
],
'default_value' => 'D',
],
'delay' => [
'type' => 'input',
'default_value' => '3',
],
],
];
$schema['banners']['templates']['addons/abt__unitheme2/blocks/abt__ut2_banner_combined.tpl'] = [
'settings' => [
'margin' => [
'option_name' => 'abt__ut2.option.margin',
'type' => 'input',
'default_value' => '0',
],
'height' => [
'option_name' => 'abt__ut2.option.height',
'type' => 'input',
'default_value' => '400px',
],
],
];
$schema['banners']['cache']['callable_handlers']['date'] = ['date', ['Y-m-d']];
}
$schema['abt__ut2_light_menu'] = [
'content' => array(
'items' => [
'type' => 'function',
'function' => ['fn_abt__ut2_get_light_menu_content'],
],
'settings_link' => [
'type' => 'template',
'template' => 'addons/abt__unitheme2/views/abt__ut2/components/light_menu_settings_link.tpl',
'remove_indent' => true,
'hide_label' => true,
],
),
'templates' => [
'addons/abt__unitheme2/blocks/abt__ut2_light_menu.tpl' => [
'settings' => [
'abt_menu_icon_items' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
'tooltip' => __('abt_menu_icon_items.tooltip'),
],
'elements_per_column_third_level_view' => [
'type' => 'input',
'default_value' => '5',
'tooltip' => __('elements_per_column_third_level_view.tooltip'),
],
'abt__ut2_show_title' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
],
'abt_menu_ajax_load' => [
'type' => 'checkbox',
'default_value' => YesNo::NO,
'tooltip' => __('abt_menu_ajax_load.tooltip'),
],
],
],
],
'cache' => [
'update_handlers' => ['menus', 'menu_descriptions', 'static_data', 'static_data_descriptions'],
],
'multilanguage' => false,
];
return $schema;
