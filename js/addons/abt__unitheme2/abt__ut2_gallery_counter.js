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
$.ceEvent('one', 'ce.product_image_gallery.ready', function(){
function updateCounter () {
this.counterElem.innerHTML = Number(this.currentItem+1) + ' ' + _.tr('abt__ut2_of') + ' ' + Number(this.itemsAmount);
}
let changeMoveAction = () => {
let owlInstance = $('.ut2-pb__img-wrapper:not(.quick-view) .cm-preview-wrapper').data('owl-carousel');
if(owlInstance !== undefined && owlInstance.itemsAmount > 1){
let counterElem = _.doc.createElement('div');
counterElem.className = 'abt__ut2_pig_counter';
owlInstance.counterElem = counterElem;
owlInstance.wrapperOuter.append(counterElem)
updateCounter.bind(owlInstance)();
owlInstance.options.afterMove = updateCounter;
}
};
setTimeout(changeMoveAction,0);
});
}(Tygh, Tygh.$));