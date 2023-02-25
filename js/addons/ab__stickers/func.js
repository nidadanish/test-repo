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
(function (_, $) {
$.ceEvent('on', 'ce.commoninit', function(context) {
var cache_key = _.ab__stickers.runtime.cache_key;
var items = context.find('[data-ab-sticker-id]');
for (var timeout in _.ab__stickers.timeouts) {
clearTimeout(_.ab__stickers.timeouts[timeout]);
}
if (items.length) {
var sticker_ids = [];
var stickers_storage = JSON.parse(localStorage.getItem(cache_key));
var ids_to_remove = [];
items.each(function () {
var item = $(this);
var item_sticker = item.attr('data-ab-sticker-id');
if (stickers_storage !== null) {
if (stickers_storage.html[item_sticker] != void (0)) {
create_sticker(item, stickers_storage.html[item_sticker]);
ids_to_remove.push(item_sticker);
}
}
sticker_ids.push(item_sticker);
});
sticker_ids = sticker_ids.filter(function (value, index, self) {
return self.indexOf(value) === index && !(~ids_to_remove.indexOf(value));
});
if (sticker_ids.length) {
var sticker_placeholders = [];
sticker_ids.forEach(function(id) {
sticker_placeholders.push({placeholders: $('[data-ab-sticker-id="' + id + '"]').data('placeholders'), id: id});
});
$.ceAjax('request', fn_url('ab__stickers.get_stickers?sl=' + _.cart_language), {
method: 'post',
hidden: true,
data: {
sticker_ids: sticker_ids,
sticker_placeholders: sticker_placeholders,
controller_mode: _.ab__stickers.runtime.controller_mode,
},
callback: function (data, params) {
if (!is_object_empty(data.stickers_html)) {
var html = data.stickers_html;
var local_storage_assign = {
html: {},
};
items.each(function () {
var item = $(this);
var item_sticker = item.attr('data-ab-sticker-id');
local_storage_assign.html[item_sticker] = html[item_sticker];
create_sticker(item, html[item_sticker]);
});
if (_.ab__stickers.runtime.caching === true) {
if (stickers_storage !== null) {
local_storage_assign.html = Object.assign(local_storage_assign.html, stickers_storage.html);
}
try {
localStorage.setItem(cache_key, JSON.stringify(local_storage_assign));
} catch (e) {
localStorage.clear();
localStorage.setItem(cache_key, JSON.stringify(local_storage_assign));
}
}
}
}
});
}
_.ab__stickers.close_tooltip = function(btn){
btn = $(btn);
var tooltip = btn.parent();
var id = tooltip.data('data-sticker-id');
clearTimeout(_.ab__stickers.timeouts[id]);
tooltip.css({
'display': 'none',
'top': '-1000px',
});
setTimeout(function(){
tooltip.css('display', '');
}, 50);
}
}
var wrapper = context.find('.ab-stickers-wrapper');
if (wrapper.length) {
var prev_w_size = 0;
var resize = function () {
if (prev_w_size !== window.innerWidth) {
prev_w_size = window.innerWidth;
var add_h = function () {
var image = context.find('.ty-product-img a.cm-image-previewer img').first();
if (image.length && image[0].complete && image[0].offsetHeight > 150) {
wrapper.css('max-height', image[0].offsetHeight + 'px');
} else {
setTimeout(function () {
add_h();
}, 100);
}
};
add_h();
}
};
$(window).on('resize', resize);
resize();
}
});

$.ceEvent('on', 'ab__vg.on_state_change', (info, state) => {
if (_.ab__video_gallery.settings.on_thumbnail_click === 'image_replace') {
var stickers = $('#' + info.iframe_id).parents('.ab_vg-images-wrapper').find('.ab-stickers-wrapper');
if (stickers.length) {
if (info.video_type === 'Y') {
if (state.data === 1) {
stickers.css('display', 'none');
} else if (state.data === 2) {
stickers.css('display', '');
}
} else if (info.video_type === 'V') {
if (info.event === 'play') {
stickers.css('display', 'none');
} else if (info.event === 'pause') {
stickers.css('display', '');
}
}
}
}
});

function create_sticker(item, sticker_html) {
item.html(sticker_html);
var sticker = item.find('[data-id]');
if (sticker.length) {
var id = sticker.data('id');
var tooltip = $("[data-sticker-id='" + id + "']").first();
sticker.on('touchstart mouseenter', function () {
var tooltip_pointer = tooltip.next();
if (!tooltip.hasClass('moved')) {
$("[data-sticker-id='" + id + "']:not(:first)").remove();
$("[data-sticker-p-id='" + id + "']:not(:first)").remove();
tooltip.appendTo('#' + _.container).addClass('moved');
tooltip_pointer.appendTo('#' + _.container);
}
clearTimeout(_.ab__stickers.timeouts[id]);
var s_height = sticker.outerHeight(true);
var s_width = sticker.outerWidth(true);
var s_pos = sticker.offset();
var tooltip_w = tooltip.outerWidth();
var tooltip_pos_y = (s_pos.top + s_height + 10);
var tooltip_pos_x = (s_pos.left + s_width / 2) - tooltip_w / 2;
var rectangle = {
top: tooltip_pos_y,
left: tooltip_pos_x,
right: tooltip_pos_x + tooltip_w,
};
if (rectangle.right > window.innerWidth) {
rectangle.left -= rectangle.right - window.innerWidth + 25;
} else if (rectangle.left < 0) {
rectangle.left = 25;
}
tooltip_pointer.css({
top: rectangle.top + 'px',
left: sticker.offset().left + sticker.outerWidth() / 2,
}).hover(function () {
clearTimeout(_.ab__stickers.timeouts[id]);
tooltip.addClass('hovered');
}, function () {
clearTimeout(_.ab__stickers.timeouts[id]);
_.ab__stickers.timeouts[id] = setTimeout(function () {
tooltip.removeClass('hovered');
}, 50);
});
tooltip.css({
top: rectangle.top + 'px',
left: rectangle.left + 'px',
}).addClass('hovered');
});
var hide_sticker = function () {
clearTimeout(_.ab__stickers.timeouts[id]);
_.ab__stickers.timeouts[id] = setTimeout(function () {
tooltip.removeClass('hovered');
}, 50);
};
sticker.on('mouseleave', hide_sticker);
}
}
var hide_active_sticker = function() {
$(".ab-sticker__tooltip.hovered").each(function(){
var id = this.getAttribute('data-sticker-id');
$('.ab-sticker[data-id="' + id + '"]').trigger('mouseleave');
});
};
$(_.doc).on('touchstart', function (e) {
var selectors = '.ab-sticker, .ab-sticker__tooltip';
var jelm = $(e.target);
if (!jelm.is(selectors) && !jelm.parents(selectors).length) {
hide_active_sticker();
}
});

function is_object_empty(obj) {
return obj == void(0) || Object.keys(obj).length === 0;
}
})(Tygh, Tygh.$);