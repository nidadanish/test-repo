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
function fn_abt__ut2_calc_cell(context){
if (fn_abt__ut2_calc_cell.timers === undefined) {
fn_abt__ut2_calc_cell.timers = [];
}
context.each((k,elem) => {
if (fn_abt__ut2_calc_cell.timers[elem]) {
clearTimeout(fn_abt__ut2_calc_cell.timers[elem]);
}
fn_abt__ut2_calc_cell.timers[elem] = setTimeout(fn_abt__ut2_calc_cell_execute, 100, $(elem));
})
}
function fn_abt__ut2_calc_cell_execute(context){
var min_width = 215;
var mid_width = 260;
$('div.grid-list:visible', context).each(function(){
var cell = $(this).find('div[class*="ut2-gl__item"]:first');
if (cell.length && cell.outerWidth() < min_width){
$(this).addClass('ut2-min-narrow');
$(this).removeClass('ut2-mid-narrow');
$(this).find('.ut2-gl__control').addClass('view');
}else if (cell.length && cell.outerWidth() > min_width && cell.outerWidth() < mid_width){
$(this).addClass('ut2-mid-narrow');
$(this).removeClass('ut2-min-narrow');
$(this).find('.ut2-gl__control').addClass('view');
}else{
$(this).removeClass('ut2-min-narrow ut2-mid-narrow');
$(this).find('.ut2-gl__control').addClass('view');
}
});
}
(function(_, $) {
$(document).ready(function() {
$.extend(_.abt__ut2, {
functions: {
in_array: function (val, arr) {
var answ = 0;
if (Array.isArray(arr)) {
answ = ~arr.indexOf(val);
} else {
answ = ~Object.keys(arr).indexOf(val);
}
return Boolean(answ);
},
detect_class_changes: function (elem, callback, add_old_val) {
var vanilla_elem = elem[0];
var observer = new MutationObserver(callback);
observer.observe(vanilla_elem, {
attributes: true,
attributeOldValue: add_old_val || false,
attributeFilter: ['class']
});
},
toggle_class_on_scrolling: function (element_to_manipulate, element_to_add_class, class_name, add_to_offset, conditions) {
var additional_offset = add_to_offset;
if (_.abt__ut2.settings.general.enable_fixed_header_panel === 'Y') {
additional_offset += $('.top-menu-grid').outerHeight();
}
$(window).on('scroll resize', function () {
var scroll_top = $(window).scrollTop() - additional_offset;
var scroll_bot = scroll_top + window.innerHeight;
var element_coords = element_to_manipulate.offset();
element_coords.bottom = element_coords.top + element_to_manipulate.outerHeight();
if (scroll_bot >= element_coords.bottom) {
if (conditions != void(0) && typeof conditions.add === 'function' && !conditions.add())
return false;
element_to_add_class.addClass(class_name);
} else {
if (conditions != void(0) && typeof conditions.remove === 'function' && !conditions.remove())
return false;
element_to_add_class.removeClass(class_name);
}
});
}
}
});
if (_.abt__ut2.settings.general.enable_fixed_header_panel === 'Y') {

$('body').data('ca-scroll-to-elm-offset', 70);
}

if (_.abt__ut2.settings.product_list.show_fixed_filters_button[_.abt__ut2.device] === 'Y') {
var filters = $('.ty-dropdown-box.ut2-filters:not(.ty-sidebox-important)');
if (filters.length) {
var offset = filters.offset();
offset.bottom = offset.top + Number(filters.outerHeight());
var class_list = ['fixed-filters'];
var header_height = 0;
if (_.abt__ut2.settings.general.enable_fixed_header_panel === 'Y') {
var header = $('.header-grid .top-menu-grid');
if (header.length) {
header_height = Number(header.outerHeight());
}
}
var class_string = class_list.join(' ');
$(window).on('resize scroll', function () {
var scroll_top = window.scrollY + header_height;
if (scroll_top > offset.bottom) {
filters.addClass(class_string);
} else {
filters.removeClass(class_string);
}
});
}
}
if (_.abt__ut2.controller === 'checkout' && _.abt__ut2.mode === 'cart') {
$('.ty-dropdown-box__title:not(.open)').addClass('__cart-page');
}
});
$(document).ready(function(){
if(_.abt__ut2.settings.general.enable_fixed_header_panel === 'Y') {
var header_selector = '#tygh_main_container > .tygh-header > .header-grid';
if (document.documentElement.clientWidth > 768) {
header_selector += ':not(.fixed)';
}
var top_panel = $('#tygh_main_container > .tygh-top-panel'),
header = $(header_selector),
menu = $('.top-menu-grid'),
b = $('body'),
top_panel_height = top_panel.height(),
header_height = header.height(),
menu_height = menu.height(),
fixed = 'fixed-header';
var height = header_height;
if ( top_panel_height != void(0) ) {
height += top_panel_height;
}
$(window).on('resize scroll', function() {
var scroll = $(window).scrollTop();
if (scroll >= height && !b.hasClass(fixed)) {
header.css('padding-top', menu_height + 'px');
b.addClass(fixed);
} else if (scroll < (height - menu_height) && b.hasClass(fixed)) {
header.css('padding-top', '');
b.removeClass(fixed);
}
});
}
});
$(document).ready(function(){
fn_abt__ut2_calc_cell($(document));
$(window).on('resize', function(e){
fn_abt__ut2_calc_cell($(document));
});
$.ceEvent('on', 'ce.commoninit', function(context) {
fn_abt__ut2_calc_cell(context);
});
$.ceEvent('on', 'ce.tab.show', function(tab_id, tabs_elm) {
fn_abt__ut2_calc_cell(tabs_elm);
});
});
$.ceEvent('on', 'ce.commoninit', function(context) {
(function(){
if ( _.abt__ut2.device === 'mobile' || _.abt__ut2.device === 'tablet' ) {
var main_content_breadcrumbs = $('.main-content-grid');
var m_c_b_w = main_content_breadcrumbs.outerWidth();
var mobile_breadcrumbs = $('.ty-breadcrumbs').css('display', 'inline-block');
var m_b_w = mobile_breadcrumbs.outerWidth(true);
if (m_b_w >= m_c_b_w) {
mobile_breadcrumbs.addClass('long').css('display', '');
}
}
})();
});
$(document).ready(function () {
if (document.documentElement.clientWidth > 768) {
var m = $('.hpo-menu');
if (m.length) {
var menu_height = m.outerHeight();
m.addClass('open-menu').find('.ty-dropdown-box__title:first').addClass('open');
var last_first_level_item = m.find('li.ty-menu__item.first-lvl.last');
var m_height = parseInt(last_first_level_item.offset().top + last_first_level_item.outerHeight());
var fixed_header = function() {
var scroll = $(window).scrollTop();
if (scroll >= m_height) {
$('body').addClass('fixed-header').css('margin-top', menu_height + 'px');
m.removeClass('open-menu');
$('.hpo-menu > .ty-dropdown-box__title').removeClass('open');
} else {
$('body').removeClass('fixed-header').css('margin-top', '');
m.addClass('open-menu');
$('.hpo-menu > .ty-dropdown-box__title').addClass('open');
}
};
fixed_header();
$(window).scroll( fixed_header );
}
} else {
$('.ty-menu__item-link[href="javascript:void(0)"]').click(function() {
var link = $(this);
var toggler = link.prev();
if (toggler.length && toggler.hasClass('ty-menu__item-toggle')) {
toggler.click();
}
});
}
(function() {
if (_.abt__ut2.settings.products.view.show_sticky_add_to_cart[_.abt__ut2.device] === 'Y' && (_.abt__ut2.controller === 'products' && _.abt__ut2.mode === 'view') && $('.ty-product-block.sticky_add_to_cart').length) {
_.abt__ut2.functions.toggle_class_on_scrolling($('.ty-product-block'), $('.ty-product-block__button, .ut2-qty__wrap'), 'hide_add_to_cart by_scroll', 66, {
remove: function () {
return !$('.menu-grid .ty-dropdown-box__title').hasClass('open');
}
});
$('.menu-grid .ty-dropdown-box__title').on('click', function () {
var buttons = $('.ut2-pb__button, .ut2-qty__wrap');
if (!buttons.hasClass('by_scroll')) {
buttons.toggleClass('hide_add_to_cart');
} else {
setTimeout(function () {
$(window).trigger('scroll');
}, 100);
}
});
}
})();
});
document.querySelectorAll('.ut2-h__menu .ty-menu__item').forEach(item => {
item.onmouseenter = function() {
var submenu = item.getElementsByClassName('ty-menu__submenu-items')[0];
if (submenu !== undefined) {
var t = 300;
submenu.style.display = 'none';
setTimeout(function () {
submenu.style.display = '';
}, t);
}
}
});
(function() {
var clicks_counter = 0;
$.ceEvent('on', 'dispatch_event_pre', function (e, jelm, processed) {
if (e.type === 'click' && _.abt__ut2.settings.category.use_swipe_to_close_filters[_.abt__ut2.device] === 'N') {
if (clicks_counter === 2) {
processed.status = true;
processed.to_return = false;
clicks_counter = 0;
return false;
}
var visible_popup = $('.abt-ut2-draggable .cm-popup-box:visible');
if (visible_popup.length) {
var vanilla_visible_popup = visible_popup[0];
var id = vanilla_visible_popup.getAttribute('id');
if (!vanilla_visible_popup.contains(jelm[0]) && clicks_counter === 0) {
clicks_counter = 1;
}
if (clicks_counter === 1 && jelm.attr('id') === 'sw_' + id) {
clicks_counter = 2;
}
}
}
});
}());
}(Tygh, Tygh.$));