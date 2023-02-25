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
function ab__toggle_video(iframe_id) {
var player = _.ab__video_gallery.players[iframe_id];
if (player != void(0)) {
if (player.type === 'Y' && typeof player.player.pauseVideo === 'function') {
player.player.pauseVideo();
} else if (player.type === 'V' && typeof player.player.pause === 'function') {
player.player.pause();
} else {
$.ceEvent('trigger', 'ab__vg.toggle_custom_player', [iframe_id, player]);
}
}
}
function ab__vg_on_state_change (event) {
$.ceEvent('trigger', 'ab__vg.on_state_change', [this, ...arguments]);
}
$.ceEvent('on', 'ce.dialogshow', function(d) {
if (/ab__vg_video_/.test(d.attr('id'))) {
$('.ab__vg_loading', $(d)).trigger('click');
}
$(d).one('dialogclose', function(event) {
var iframe = $('iframe', $(this));
if (iframe.length) {
iframe.each(function() {
ab__toggle_video(this.getAttribute('id') || this.getAttribute('data-id'));
});
}
});
});
$.ceEvent('on', 'dispatch_event_pre', function (e, jelm, processed) {
if (jelm.hasClass('cm-previewer') || jelm.parent().hasClass('cm-previewer')) {
setTimeout(function(){
var previewer_images = $(_.doc).find('.ab-vg-video-image').not('.tygh-content .ab-vg-video-image');
if (previewer_images.length) {
previewer_images.each((index, elem) => {
$(elem).wrap($(`<div class="ab__vg_loading ab__vg-image_gallery_video" data-src="${elem.getAttribute('data-ab-vg-image-emded-url')}"></div>`)).parent();
});
}
}, 500);
}
});

$.ceEvent('on', 'ce.product_image_gallery.ready', function () {
var elem = $('.cm-thumbnails-mini.active');
if (elem.length) {
var c_id = elem.data('caGalleryLargeId');
var pos = elem.data('caImageOrder') || 0;
if (c_id !== undefined) {
$('#' + c_id).closest('.cm-preview-wrapper').trigger('owl.goTo', pos);
}
let gallery = elem.closest('.owl-carousel');
if (gallery.length) {
for (let i=2;i<pos;i++) {
gallery.trigger('owl.next');
}
}
}
});

$.ceEvent('on', 'ce.product_image_gallery.image_changed', function () {
$('iframe.ab__vg-image_gallery_video').each(function() {
ab__toggle_video(this.id);
});
});
$(_.doc).on('click', '.ab__vg_loading', function() {
var elem = $(this),
iframe = $('<iframe></iframe>');
var image = elem.find('img');
if (!image.length) {
image = elem.find('div[data-ab-vg-video-type]');
}
var iframe_id = elem.attr('id') || elem.attr('data-id');
iframe.attr('id', iframe_id);
iframe.addClass(elem.attr('class'));
$.each(elem.data(), function(i, val) {
iframe.attr(i, val);
});
elem.replaceWith(iframe);
iframe.removeClass('ab__vg_loading');
var video_type = image.data('abVgVideoType') || elem.data('abVgVideoType');
if (video_type === 'Y') {
if (_.ab__video_gallery.youtube_api_loaded === false) {
window.onYouTubeIframeAPIReady = function() {
_.ab__video_gallery.youtube_api_loaded = true;
add_youtube_listeners(iframe_id, video_type)
};
$.getScript('https://www.youtube.com/iframe_api');
} else {
add_youtube_listeners(iframe_id, video_type)
}
} else if (video_type === 'V') {
if (_.ab__video_gallery.vimeo_api_loaded === false) {
$.getScript('https://player.vimeo.com/api/player.js', function () {
_.ab__video_gallery.vimeo_api_loaded = true;
add_vimeo_listeners(iframe_id, video_type);
});
} else {
add_vimeo_listeners(iframe_id, video_type);
}
} else {
$.ceEvent('trigger', 'ab__vg.load_custom_player', [video_type, iframe, iframe_id]);
}
});
$(_.doc).on('click', '.ab__vg-image_gallery_video.cm-dialog-opener', function() {
var id = $(this).data('caTargetId');
if (id !== undefined) {
$('#' + id + ' .ab__vg_loading').trigger('click');
}
});
function add_youtube_listeners(iframe_id, video_type) {
_.ab__video_gallery.players[iframe_id] = {
player: new YT.Player(iframe_id, {
events: {
'onStateChange': ab__vg_on_state_change.bind({ iframe_id: iframe_id, video_type: video_type })
}
}),
type: video_type
};
}
function add_vimeo_listeners(iframe_id, video_type) {
var player = _.ab__video_gallery.players[iframe_id] = {
player: new Vimeo.Player(iframe_id),
type: video_type
};
player.player.on('play', ab__vg_on_state_change.bind({ iframe_id: iframe_id, video_type: video_type, event: 'play' }));
player.player.on('pause', ab__vg_on_state_change.bind({ iframe_id: iframe_id, video_type: video_type, event: 'pause' }));
}
})(Tygh, Tygh.$);