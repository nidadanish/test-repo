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
$(document).ready(function() {
if (_.abt__ut2.settings.general.push_history_on_popups[_.abt__ut2.device] === 'Y') {

var app = {
currentState: '',
statesStack: [ ],
originalPushState: false,
ignore_notice_close: false,
ignore_popup_close: false,

getLastOfType: function(type) {
return app.statesStack.reverse().find(
state => ~state.indexOf(type)
);
},
getCurrentState: function() {
return app.currentState;
},
setAbState: function(state) {
var _state = {};
_state[state] = true;
app.statesStack.push(state);
app.currentState = state;
history.pushState(_state, '');
},
pushState : function(state, title, href) {
app.originalPushState.call(history, state, title, href);
},
onPopState : function(event) {
var state = app.currentState;
if (state !== undefined && state.length) {
app.statesStack.splice(-1, 1);
app.currentState = app.statesStack[app.statesStack.length - 1];

if (!app.ignore_dialog_close) {
if (/abt__popup_opened/.test(state)) {
var id = state.replace('abt__popup_opened_', '');
$('#' + id).ceDialog('close');
}
}
app.ignore_dialog_close = false;
if (app.ignore_notice_close) {
app.ignore_notice_close = false;
app.statesStack.splice(-1, 1).push(state);
} else {
if (~state.indexOf('abt__notice_opened')) {
var _notification_container = $('.cm-notification-content-extended:visible');
if (_notification_container.length) {
$.ceNotification('close', _notification_container, false);
}
}
}
}
},
init : function() {
window.onpopstate = app.onPopState;
app.originalPushState = history.pushState;
history.pushState = app.pushState;
history.scrollRestoration = 'manual';
}
};
app.init();
_.abt__ut2.history_app = app;

$.ceEvent('on', 'ce.dialogshow', function(dialog) {
app.setAbState('abt__popup_opened_' + dialog.attr('id'));
});

$.ceEvent('on', 'ce.notificationshow', function(notification) {
if (notification.hasClass('cm-notification-content-extended')) {
app.setAbState('abt__notice_opened_' + notification.data('ca-notification-key'));
var vanilla = notification[0];
var ab_observer = new MutationObserver(function(mutationsList) {
var last_state = app.getLastOfType('abt__notice_opened');

for (var mutationRecord of mutationsList) {
if (mutationRecord.removedNodes.length) {
console.log(mutationRecord);
} else if (mutationRecord.attributeName !== undefined && mutationRecord.attributeName === 'style' && ~mutationRecord.oldValue.indexOf('display: none')) {
var target = mutationRecord.target;
if (target.classList.contains('cm-notification-content-extended') && last_state != void(0) && last_state === 'abt__notice_opened_' + target.getAttribute('data-ca-notification-key')) {
history.go(-1);
if ($.lastClickedElement != void(0)) {
var href = '';
if ($.lastClickedElement.hasClass('cm-notification-close')) {
href = $.lastClickedElement.attr('href');
}
var parent = $.lastClickedElement.parents('.cm-notification-close');
if (parent.length) {
href = parent.attr('href');
}
if (typeof href !== 'undefined' && href.length) {
window.location = href;
}
}
}
}
}
});
ab_observer.observe(vanilla, {
attributes: true,
attributeOldValue: true,
});
}
});

$.ceEvent('on', 'ce.dialogclose', function(dialog) {
var last_state = app.getLastOfType('abt__popup_opened');
setTimeout(function(){
if (last_state === 'abt__popup_opened_' + dialog.attr('id')) {
app.ignore_dialog_close = true;
history.back();
}
}, 1000)
});
}
});
}(Tygh, Tygh.$));