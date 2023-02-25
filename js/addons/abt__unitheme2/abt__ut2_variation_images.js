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
let getMainImage = () => {
return _.doc.querySelector('.cm-preview-wrapper .owl-item.active img');
}
$(_.doc).on({
mouseenter:changeMainImage,
mouseleave:restoreMainImage
},'.cm-picker-product-variation-features a[data-ca-variation-image]');
function changeMainImage (ev){
let mainImage = getMainImage()
,variationLink = ev.target.closest('a');
if(mainImage){
mainImage.parentNode.classList.add('ab__clear_image');
['src','srcset'].map(function (e){
if (mainImage[e] !== undefined){
let postfix = e === 'srcset' && variationLink.dataset['caVariationImageHidpi'] !== undefined ? 'Hidpi' :'';
mainImage.dataset[e+'_old'] = mainImage[e];
mainImage[e] = variationLink.dataset['caVariationImage'+postfix];
}
});
}
};
function restoreMainImage (){
let mainImage = getMainImage();
if(mainImage ) {
['src','srcset'].map(function (e){
if(mainImage.dataset[e+'_old'] !== undefined){
mainImage[e] = mainImage.dataset[e+'_old'];
}
})
mainImage.parentNode.classList.remove('ab__clear_image');
}
}
}(Tygh, Tygh.$));