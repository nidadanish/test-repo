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
const container = $('.cm-ab-similar-filter-container'),
baseUrl = container.data('caBaseUrl'),
HASH_SEPARATOR = '_',
HASH_FEATURE_SEPARATOR = '-';
let builFeaturesHash = (container) => {
var features = {};
var hash = [];
container.find('input.cm-ab-similar-filter:checked').each(function () {
var elm = $(this);
if (!features[elm.data('caFilterId')]) {
features[elm.data('caFilterId')] = [];
}
features[elm.data('caFilterId')].push(elm.val());
});
for (var k in features) {
hash.push(k + HASH_FEATURE_SEPARATOR + features[k].join(HASH_FEATURE_SEPARATOR));
}
return hash.join(HASH_SEPARATOR);
}
let loadCategory = (container) => {
let targetUrl = $.attachToUrl(baseUrl, 'features_hash=' + builFeaturesHash(container));
$.redirect(targetUrl);
};
let toggleButtonState = (container) =>{
let checkboxesState = !!container.find('.cm-ab-similar-filter:checked').length;
container.find('.abt__ut2_search_similar_in_category_btn').toggleClass('disabled',!checkboxesState);
};
container.on('change', '.cm-ab-similar-filter', function(e){
toggleButtonState(container);
});
container.on('click', '.abt__ut2_search_similar_in_category_btn:not(.disabled)', function(){
loadCategory(container);
});
$('.cm-ab-similar-filter').first().trigger('change');
}(Tygh, Tygh.$));