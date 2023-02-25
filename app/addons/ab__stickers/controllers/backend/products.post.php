<?php
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
use Tygh\Registry;if (!defined('BOOTSTRAP')) {
die('Access denied');}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
return;}
if (call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\141\x73\145\x36\64\x5f\144\x65\143\x6f\144\x65",call_user_func("\141\x62\137\x5f\137\x5f\137","\142\x58\62\x78\143\x48\72\x6c\133\x52\76\x3e")),"",["\141\x62\137\137","\137\137\x5f"]),call_user_func("\142\141\163\145\x36\64\137\144\145\x63\157\144\145","\141\x6d\65\170\142\130\x42\154\132\147\75\x3d")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\x62\141\x73\145\x36\64\x5f\144\x65\143\x6f\144\x65",call_user_func("\141\x62\137\x5f\137\x5f\137","\142\x58\62\x78\143\x48\72\x6c\133\x52\76\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\144\110\x56\172\143\62\132\x33")),call_user_func(call_user_func(call_user_func("\x62\141\x73\145\x36\64\x5f\144\x65\143\x6f\144\x65",call_user_func("\141\x62\137\x5f\137\x5f\137","\142\x58\62\x78\143\x48\72\x6c\133\x52\76\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\116\124\x64\155\144\107\112\x6a"))),call_user_func(call_user_func(call_user_func(call_user_func("\x62\141\x73\145\x36\64\x5f\144\x65\143\x6f\144\x65",call_user_func("\141\x62\137\x5f\137\x5f\137","\142\x58\62\x78\143\x48\72\x6c\133\x52\76\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\144\110\x56\172\143\62\132\x33")),call_user_func(call_user_func(call_user_func("\x62\141\x73\145\x36\64\x5f\144\x65\143\x6f\144\x65",call_user_func("\141\x62\137\x5f\137\x5f\137","\142\x58\62\x78\143\x48\72\x6c\133\x52\76\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\132\155\x56\167\132\107\132\x6c\131\101\75\75")))]),call_user_func("\141\142\137\137\137\x5f\137","\131\107\123\66\133\x33\151\144\126\156\127\157\x62\131\117\61\144\157\154\x37\120\156\145\155\145\102\x3e\76")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\141\x73\145\x36\64\x5f\144\x65\143\x6f\144\x65",call_user_func("\141\x62\137\x5f\137\x5f\137","\142\x58\62\x78\143\x48\72\x6c\133\x52\76\x3e")),"",["\141\x62\137\137","\137\137\x5f"]),call_user_func("\142\141\163\145\x36\64\137\144\145\x63\157\144\145","\141\x6d\65\170\142\130\x42\154\132\147\75\x3d")),"",["\142\x61\163\145\66\64\137\144\145","\x63\157\144\145"]),call_user_func("\141\142\137\137\x5f\137\137","\144\157\127\166\145\x48\155\165\133\124\66\165\143\x33\123\155"))) == 'update' && fn_check_permissions('ab__stickers','view','admin')) {
$tabs=Registry::get('navigation.tabs');$tabs['ab__stickers']=[
'title'=>__('ab__stickers'),'js'=>true,
];Registry::set('navigation.tabs',$tabs);
$repository=Tygh::$app['addons.ab__stickers.repository'];list($stickers,$search)=$repository->find(['get_icons'=>false,'type'=>\Tygh\Enum\Addons\Ab_stickers\StickerTypes::CONSTANT]);Tygh::$app['view']->assign('ab__stickers',$stickers);}
