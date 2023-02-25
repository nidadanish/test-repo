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
$(document).ready(function(){
$("#ab__stickers_style").on("change", function() {
var select = $(this);
var val = select.val();
$(".sticker-type-settings").addClass("hidden");
$('#' + val + "_sticker_settings").removeClass("hidden");
});
_.ab__stickers.functions.add_condition = function(id, skip_select, type) {
var new_group = false,
new_id = $('#container_' + id).cloneNode(0, true, true).str_replace('container_', ''),
$new_container = $('#container_' + new_id),
$input = null;
skip_select = skip_select || false;
$new_container.prevAll('[id^="container_"]').each(function() {
var $this = $(this);
$input = $('input[name^="sticker_data[conditions][conditions]"]:first', $this).clone();
if ($input.length !== 0) {
if ($input.val() !== "undefined" && $input.val() !== '') {
$input.val('');
}
return false;
}
});
if ($input === null || !$input.get(0)) {
$input = $('input[name^="sticker_data[conditions][conditions]"]:first', $new_container.parents('li:first')).clone();
$('.no-node.no-items', $new_container.parents('ul:first')).hide();
if (!$input.get(0)) {
var n = (type === "condition") ? "sticker_data[conditions][conditions][0][condition]" : '';
$input = $('<input type="hidden" name="'+ n +'" value="" />');
} else {
new_group = true;
}
}
var _name = $input.prop('name').length > 0 ? $input.prop('name') : $input.data('caInputName');
var val = parseInt(_name.match(/(.*)\[(\d+)\]/)[2]);
var name = new_group ? _name : _name.replace(/(.*)\[(\d+)\]/, '$1[' + (val + 1) +']');
$input.attr('name', name);
$new_container.append($input);
name = name.replace(/\[(\w+)\]$/, '');
if (new_group) {
name += '[conditions][1]';
}
$new_container.prev().removeClass('cm-last-item');
$new_container.addClass('cm-last-item').show();
if (skip_select == false) {
$('#container_' + new_id + ' select').prop('id', new_id).prop('name', name);
} else {
$new_container.empty();
return {
new_id: new_id,
name: name
};
}
};
_.ab__stickers.functions.add_group = function(id, sticker_id) {
var res = _.ab__stickers.functions.add_condition(id, true, 'condition');
$.ceAjax('request', fn_url("ab__stickers.dynamic?sticker_id=" + sticker_id + "&prefix=" + encodeURIComponent(res.name) + '&group=new&elm_id=' + res.new_id), {
result_ids: 'container_' + res.new_id
});
}
});
})(Tygh, Tygh.$);
