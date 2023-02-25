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
(function(_, $) {
_.abt__ut2.temporary.menu_columns = {};
var prev_width = 0;
var resize = function(force) {
var one_col_width = 175;
var new_width = window.innerWidth;
if ((new_width === prev_width && force !== true) || new_width <= 767) {
return true;
}
prev_width = new_width;
$('.ty-menu__item.cm-menu-item-responsive').each(function (menu_id) {
var first_lvl_parent = $(this);
var parent = first_lvl_parent.find('.ty-menu__submenu-items:not(.tree-level-dropdown)');
if (parent.length) {
var settings_columns = first_lvl_parent.data('settingsCols');
var parent_width = parent.innerWidth();
var menu_banner = parent.find('.ut2-mwi-html:not(.bottom)');
if (menu_banner.length && menu_banner.css('display') !== 'none') {
parent_width -= menu_banner.outerWidth(true);
}
if (parent.attr('data-cols-count') === undefined) {
parent_width -= 20;
}
var columns = Math.floor(parent_width / one_col_width);
if (settings_columns >= columns) {
if (_.abt__ut2.temporary.menu_columns[menu_id] !== columns) {
_.abt__ut2.temporary.menu_columns[menu_id] = columns;
var subcols = parent.find('.ty-menu__submenu-col');
if (subcols.length >= columns) {
var subitems_count = first_lvl_parent.data('subitemsCount');
var items_in_cols = Math.ceil(subitems_count / columns);
var big_cols_count = subitems_count % columns;
var index = 0;
for (var i = 0; i < columns; i++) {
if (i === big_cols_count && big_cols_count !== 0) {
items_in_cols--;
}
var column = subcols.eq(i);
for (var j = 0; j < items_in_cols; j++) {
var li = parent.find('[data-elem-index=' + index++ + ']');
li.appendTo(column);
}
}
}
}
}
}
});
};

$.ceEvent('on', 'ce.ut2-hm-toggle', function(btn, parent, elem, is_prev){
resize(true);
});
$(window).on('resize', resize);
}(Tygh, Tygh.$));