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
$(_.doc).ready(function () {
$('#content_ab__video_gallery .cm-row-item').each(function(){
on_create($(this));
});
_.ab__vg.change_required_fields = function(video_id, value) {
var inputs_wrapper = $('#box_' + video_id + '_ab__vg_video');
if (!inputs_wrapper.length) {
inputs_wrapper = $('#box_add_ab__vg_video');
}
var icon_types_inputs = inputs_wrapper.find('#ab__vg__icon_type__' + video_id + ' input');
if (value === 'H') {
icon_types_inputs.attr('disabled', '');
$('#ab__vg__icon_type__' + video_id + '__icon').attr('checked', '').removeAttr('disabled');
} else {
icon_types_inputs.removeAttr('disabled');
}
inputs_wrapper.find('.cm-ab-video-settings-wrapper').addClass('hidden');
inputs_wrapper.find('#ab__vg_video_settings_' + video_id + '_' + value + '_wrapper').removeClass('hidden');
}
});
var on_create = function(box) {
var inputs = box.find('input, textarea, select');
inputs.change(function(){
box.find('.cm-ab-vg-required').addClass('cm-required');
});
};
window.fn_ab__vg_remove_required_from_new = function() {
var tbodies = document.querySelectorAll("tbody[id^='box_add_ab__vg_video_']");
var last_created = undefined;
var prev_biggest_id = 0;
tbodies.forEach((elem) => {
var id = elem.id.split('_');
id = id[id.length - 1];
if (id > prev_biggest_id) {
last_created = elem;
}
});
last_created.querySelectorAll('.cm-required').forEach(elem => elem.classList.remove('cm-required'));
on_create($(last_created));
};
})(Tygh, Tygh.$);