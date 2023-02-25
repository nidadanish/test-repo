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
use Tygh\Registry;
use Tygh\Enum\YesNo;
$default_products_view = Registry::get('settings.Appearance.default_products_view');
$schema = [
'general' => [
'position' => 100,
'items' => [
'brand_feature_id' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 100,
'value' => 18,
'is_for_all_devices' => YesNo::YES,
],
'blog_page_id' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 150,
'value' => '',
'is_for_all_devices' => YesNo::YES,
],
'enable_fixed_header_panel' => [
'type' => 'checkbox',
'position' => 300,
'value' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
],
'check_clone_theme' => [
'type' => 'checkbox',
'position' => 10000,
'value' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
],
'price_format' => [
'type' => 'selectbox',
'position' => 400,
'value' => 'default',
'class' => 'input-large',
'is_for_all_devices' => YesNo::YES,
'variants' => [
'default' => ['tooltip' => 'abt__ut2.settings.general.price_format.variants.default.tooltip'],
'superscript_decimals' => ['tooltip' => 'abt__ut2.settings.general.price_format.variants.superscript_decimals.tooltip'],
'subscript_decimals' => ['tooltip' => 'abt__ut2.settings.general.price_format.variants.subscript_decimals.tooltip'],
],
],
'push_history_on_popups' => [
'type' => 'checkbox',
'position' => 100,
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::YES,
],
],
'change_main_image_on_variation_hover' => [
'type' => 'checkbox',
'position' => 200,
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
'disabled' => [
'mobile' => YesNo::YES,
'tablet' => YesNo::YES,
],
],
],
],
'category' => [
'position' => 150,
'items' => [
'show_subcategories' => [
'type' => 'checkbox',
'position' => 100,
'value' => YesNo::NO,
'is_for_all_devices' => YesNo::YES,
],
'description_position' => [
'type' => 'selectbox',
'position' => 200,
'class' => 'input-large',
'value' => 'bottom',
'variants' => [
'bottom',
'top',
'none',
],
'variants_as_language_variable' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
],
'use_swipe_to_close_filters' => [
'type' => 'checkbox',
'position' => 100,
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
'disabled' => [
'desktop' => YesNo::YES,
],
],
],
],
'features' => [
'position' => 175,
'items' => [
'description_position' => [
'type' => 'selectbox',
'position' => 200,
'class' => 'input-large',
'value' => 'bottom',
'variants' => [
'bottom',
'top',
'none',
],
'variants_as_language_variable' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
],
],
],
'product_list' => [
'position' => 200,
'items' => [
'show_gallery' => [
'type' => 'checkbox',
'position' => 10,
'value' => YesNo::NO,
'is_for_all_devices' => YesNo::YES,
],
'decolorate_out_of_stock_products' => [
'type' => 'checkbox',
'position' => 40,
'value' => YesNo::NO,
'is_for_all_devices' => YesNo::YES,
],
'show_fixed_filters_button' => [
'type' => 'checkbox',
'position' => 50,
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::YES,
],
'disabled' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
],
],
'max_features' => [
'type' => 'input',
'position' => 60,
'class' => 'input-small cm-value-integer',
'value' => [
'desktop' => 2,
'tablet' => 2,
'mobile' => 2,
],
],
'price_display_format' => [
'type' => 'selectbox',
'class' => 'input-large',
'position' => 70,
'value' => 'row',
'variants' => [
'col',
'row',
'mix',
],
'is_for_all_devices' => YesNo::YES,
],
'price_position_top' => [
'type' => 'checkbox',
'position' => 75,
'value' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
],
'show_rating' => [
'type' => 'checkbox',
'position' => 80,
'value' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
],
'default_products_view' => [
'type' => 'selectbox',
'position' => 90,
'class' => 'input-large',
'value' => [
'desktop' => $default_products_view,
'tablet' => $default_products_view,
'mobile' => $default_products_view,
],
'variants' => array_keys(fn_get_products_views(true, true)),
],
'products_multicolumns' => [
'is_group' => YesNo::YES,
'position' => 40,
'items' => [
'grid_item_height' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 100,
'value' => [
'desktop' => '',
'tablet' => '',
'mobile' => '',
],
],
'image_width' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 103,
'value' => [
'desktop' => '270',
'tablet' => '200',
'mobile' => '140',
],
],
'image_height' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 102,
'value' => [
'desktop' => '270',
'tablet' => '200',
'mobile' => '140',
],
],
'show_sku' => [
'type' => 'checkbox',
'position' => 110,
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
'show_amount' => [
'type' => 'checkbox',
'position' => 115,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_qty' => [
'type' => 'checkbox',
'position' => 120,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
'show_buttons' => [
'type' => 'checkbox',
'position' => 130,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
'show_buttons_on_hover' => [
'type' => 'checkbox',
'position' => 140,
'disabled' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
'grid_item_bottom_content' => [
'type' => 'selectbox',
'class' => 'input-large',
'position' => 150,
'disabled' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
'value' => [
'desktop' => 'features',
'tablet' => 'none',
'mobile' => 'none',
],
'variants' => [
'none',
'description',
'features',
'variations',
'features_and_description',
'features_and_variations',
],
'variants_as_language_variable' => YesNo::YES,
],
'show_content_on_hover' => [
'type' => 'checkbox',
'position' => 155,
'disabled' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
'show_brand_logo' => [
'type' => 'checkbox',
'position' => 160,
'disabled' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::YES,
],
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
'show_you_save' => [
'type' => 'checkbox',
'position' => 170,
'disabled' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
],
],
'products_without_options' => [
'is_group' => YesNo::YES,
'position' => 40,
'items' => [
'show_sku' => [
'type' => 'checkbox',
'position' => 170,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_amount' => [
'type' => 'checkbox',
'position' => 180,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_qty' => [
'type' => 'checkbox',
'position' => 190,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'grid_item_bottom_content' => [
'type' => 'selectbox',
'class' => 'input-large',
'position' => 200,
'value' => [
'desktop' => 'features_and_variations',
'tablet' => 'none',
'mobile' => 'none',
],
'variants' => [
'none',
'features',
'variations',
'features_and_variations',
],
'variants_as_language_variable' => YesNo::YES,
],
'show_options' => [
'type' => 'checkbox',
'position' => 210,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_brand_logo' => [
'type' => 'checkbox',
'position' => 220,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
],
],
'short_list' => [
'is_group' => YesNo::YES,
'position' => 40,
'items' => [
'show_sku' => [
'type' => 'checkbox',
'position' => 230,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::NO,
],
],
'show_amount' => [
'type' => 'checkbox',
'position' => 115,
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
'show_qty' => [
'type' => 'checkbox',
'position' => 240,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_button' => [
'type' => 'checkbox',
'position' => 250,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_button_quick_view' => [
'type' => 'checkbox',
'position' => 260,
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
'disabled' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::YES,
],
],
'show_button_wishlist' => [
'type' => 'checkbox',
'position' => 270,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::NO,
],
'is_addon_dependent' => YesNo::YES,
],
'show_button_compare' => [
'type' => 'checkbox',
'position' => 280,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::NO,
],
],
],
],
'product_variations' => [
'is_group' => YesNo::YES,
'position' => 50,
'items' => [
'limit' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 20,
'value' => '10',
'is_for_all_devices' => YesNo::YES,
],
'display_as_links' => [
'type' => 'checkbox',
'position' => 30,
'value' => YesNo::NO,
'is_for_all_devices' => YesNo::YES,
],
],
],
],
],
'products' => [
'position' => 300,
'items' => [
'custom_block_id' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 100,
'value' => '',
'is_for_all_devices' => YesNo::YES,
],
'search_similar_in_category' => [
'type' => 'checkbox',
'position' => 200,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::NO,
],
],
'view' => [
'is_group' => YesNo::YES,
'position' => 40,
'items' => [
'show_qty' => [
'type' => 'checkbox',
'position' => 100,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_sku' => [
'type' => 'checkbox',
'position' => 200,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_features' => [
'type' => 'checkbox',
'position' => 300,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_features_in_two_col' => [
'type' => 'checkbox',
'position' => 310,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
],
'show_short_description' => [
'type' => 'checkbox',
'position' => 400,
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
'show_sticky_add_to_cart' => [
'type' => 'checkbox',
'position' => 200,
'value' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::NO,
'mobile' => YesNo::YES,
],
'disabled' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
],
'show_brand_logo' => [
'type' => 'checkbox',
'position' => 500,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::YES,
'mobile' => YesNo::NO,
],
],
'brand_link_behavior' => [
'type' => 'selectbox',
'position' => 501,
'class' => 'input-large',
'value' => 'to_category_with_filter',
'variants' => [
'to_brand_page',
'to_category_with_filter',
],
'is_for_all_devices' => YesNo::YES,
],
],
],
'addon_buy_together' => [
'is_group' => YesNo::YES,
'position' => 200,
'items' => [
'view' => [
'type' => 'selectbox',
'class' => 'input-large',
'position' => 150,
'value' => 'as_block_above_tabs',
'variants' => [
'as_block_above_tabs',
'as_tab_in_tabs',
],
'variants_as_language_variable' => YesNo::YES,
'is_addon_dependent' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
],
],
],
'addon_required_products' => [
'is_group' => YesNo::YES,
'position' => 200,
'items' => [
'list_type' => [
'type' => 'selectbox',
'class' => 'input-large',
'position' => 150,
'disabled' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
'value' => [
'desktop' => 'grid_list',
'tablet' => 'grid_list',
'mobile' => 'grid_list',
],
'variants' => [
'grid_list',
'compact_list',
'product_list',
],
'variants_as_language_variable' => YesNo::YES,
'is_addon_dependent' => YesNo::YES,
],
'item_quantity' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 100,
'value' => [
'desktop' => 4,
'tablet' => 2,
'mobile' => 2,
],
'disabled' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
'is_addon_dependent' => YesNo::YES,
],
],
],
'addon_social_buttons' => [
'is_group' => YesNo::YES,
'position' => 300,
'items' => [
'view' => [
'type' => 'checkbox',
'position' => 100,
'value' => [
'desktop' => YesNo::YES,
'tablet' => YesNo::NO,
'mobile' => YesNo::NO,
],
'is_addon_dependent' => YesNo::YES,
],
],
],
],
],
'load_more' => [
'position' => 400,
'items' => [
'product_list' => [
'type' => 'checkbox',
'position' => 100,
'value' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
],
'blog' => [
'type' => 'checkbox',
'position' => 200,
'value' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
],
'mode' => [
'type' => 'selectbox',
'class' => 'input-large',
'position' => 300,
'value' => 'on_button_click',
'variants' => [
'auto',
'on_button_click',
],
'is_for_all_devices' => YesNo::YES,
],
'before_end' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 400,
'value' => 300,
'suffix' => 'px',
'is_for_all_devices' => YesNo::YES,
],
],
],
'addons' => [
'position' => 10000,
'items' => [
'wishlist_products' => [
'is_group' => YesNo::YES,
'position' => 100,
'items' => [
'item_quantity' => [
'type' => 'input',
'class' => 'input-small cm-value-integer',
'position' => 100,
'value' => [
'desktop' => 4,
'tablet' => 2,
'mobile' => 2,
],
'disabled' => [
'desktop' => YesNo::NO,
'tablet' => YesNo::YES,
'mobile' => YesNo::YES,
],
'is_addon_dependent' => YesNo::YES,
],
],
],
'call_requests' => [
'is_group' => YesNo::YES,
'position' => 200,
'items' => [
'item_button' => [
'type' => 'checkbox',
'position' => 200,
'value' => YesNo::NO,
'is_for_all_devices' => YesNo::YES,
'is_addon_dependent' => YesNo::YES,
],
],
],
'discussion' => [
'is_group' => YesNo::YES,
'position' => 300,
'items' => [
'highlight_administrator' => [
'type' => 'checkbox',
'position' => 100,
'value' => YesNo::NO,
'is_for_all_devices' => YesNo::YES,
'is_addon_dependent' => YesNo::YES,
],
'verified_buyer' => [
'type' => 'checkbox',
'position' => 200,
'value' => YesNo::YES,
'is_for_all_devices' => YesNo::YES,
'is_addon_dependent' => YesNo::YES,
],
],
],
],
],
];
return $schema;
