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
use Tygh\Registry;use Tygh\Enum\YesNo;use Tygh\Enum\ObjectStatuses;if (!defined('BOOTSTRAP')) {
die('Access denied');}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
return [CONTROLLER_STATUS_OK];}
if (call_user_func(call_user_func(call_user_func(call_user_func("\142\141\x73\145\66\64\137\144\145\143\x6f\144\145",call_user_func("\141\x62\137\137\137\137\137","\142\130\62\170\143\x48\72\154\133\122\76\76")),"",["\141\x62\137\137","\137\137\137"]),call_user_func("\142\141\x73\145\66\64\137\144\145\143\x6f\144\145","\130\126\126\66\141\x47\154\144\125\62\132\157\141\x6e\122\61\143\63\157\67\117\x32\150\155\144\121\75\75")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\145\66\64\137\x64\145\143\157\144\145",call_user_func("\141\142\137\137\137\137\x5f","\142\130\x32\170\143\110\72\154\133\122\x3e\76")),"",["\141\142\137\137","\137\137\x5f"]),call_user_func("\142\141\163\145\66\64\137\x64\145\143\157\144\145","\141\155\x35\170\142\130\102\154\132\147\x3d\75")),"",["\142\141\163\145\66\64\x5f\144\145","\143\157\144\145"]),call_user_func("\141\x62\137\137\137\137\137","\144\157\x57\166\145\110\155\165\133\124\x36\165\143\63\123\155"))) == call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\x65\66\64\137\144\145\143\157\x64\145",call_user_func("\141\142\x5f\137\137\137\137","\142\130\62\170\143\110\x3a\154\133\122\76\76")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\142\141\163\x65\66\64\137\144\145\143\157\x64\145","\141\155\65\170\142\130\x42\154\132\147\75\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\x65\66\64\137\144\145\143\157\x64\145",call_user_func("\141\142\x5f\137\137\137\137","\142\130\62\170\143\110\x3a\154\133\122\76\76")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\142\141\163\x65\66\64\137\144\145\143\157\x64\145","\144\110\126\172\143\62\x5a\63")),call_user_func(call_user_func(call_user_func("\142\141\163\145\66\64\137\x64\145\143\157\144\145",call_user_func("\141\142\137\137\137\137\x5f","\142\130\x32\170\143\110\72\154\133\122\x3e\76")),"",["\141\142\137\137","\137\137\x5f"]),call_user_func("\142\141\163\145\66\64\137\x64\145\143\157\144\145","\116\124\x64\155\144\107\112\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\x65\66\64\137\144\145\143\157\x64\145",call_user_func("\141\142\x5f\137\137\137\137","\142\130\62\170\143\110\x3a\154\133\122\76\76")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\142\141\163\x65\66\64\137\144\145\143\157\x64\145","\144\110\126\172\143\62\x5a\63")),call_user_func(call_user_func(call_user_func("\142\141\163\145\66\64\137\x64\145\143\157\144\145",call_user_func("\141\142\137\137\137\137\x5f","\142\130\x32\170\143\110\72\154\133\122\x3e\76")),"",["\141\142\137\137","\137\137\x5f"]),call_user_func("\142\141\163\145\66\64\137\x64\145\143\157\144\145","\132\155\x56\167\132\107\132\154\131\101\x3d\75")))]),call_user_func("\x61\142\137\137\137\137\x5f","\145\131\103\154\132\x59\123\155"))
&& call_user_func(call_user_func(call_user_func(call_user_func("\142\141\x73\145\66\64\137\144\145\143\x6f\144\145",call_user_func("\141\x62\137\137\137\137\137","\142\130\62\170\143\x48\72\154\133\122\76\76")),"",["\141\x62\137\137","\137\137\137"]),call_user_func("\142\141\x73\145\66\64\137\144\145\143\x6f\144\145","\130\126\126\66\141\x47\154\144\125\62\132\157\141\x6e\122\61\143\63\157\67\117\x32\150\155\144\121\75\75")),call_user_func(call_user_func("\x73\164\162\x72\145\166","\x5f\137\137\x5f\137\142\x61"),call_user_func("\142\141\x73\145\66\x34\137\144\x65\143\157\x64\145","\131\x6d\126\154\x63\107\71\x30\114\62\x4a\152\131\x47\102\60\x64\127\160\x6b\142\107\x5a\172\144\x43\71\155\x62\62\112\x6a\142\127\x5a\147\132\x33\102\172\x59\110\144\x6d\142\62\x56\167\143\x33\121\75"))) == YesNo::YES
&& fn_allowed_for('MULTIVENDOR')
&& (fn_check_view_permissions('ab__stickers.view','GET') || Registry::ifGet('addons.vendor_privileges.status',ObjectStatuses::DISABLED) != ObjectStatuses::ACTIVE)) {
Registry::set('navigation.tabs.ab__stickers',[
'title'=>__('ab__stickers'),'js'=>true,
]);
$repository=Tygh::$app['addons.ab__stickers.repository'];$params=array_merge($_REQUEST,[
'status'=>ObjectStatuses::ACTIVE,
]);list($stickers)=$repository->find($params);
$view=Tygh::$app['view'];$view->assign([
'ab__stickers'=>$stickers,
]);$default_placeholders=[];$conditions_schema=fn_get_schema('ab__stickers','conditions')['dynamic']['conditions'];foreach ($conditions_schema as $condition) {
if (!empty($condition['available_placeholders'])) {
foreach ($condition['available_placeholders'] as $placeholder=>$data) {
if (!empty($data['default_value'])) {
$default_placeholders[$placeholder]=$data['default_value'];}}}}
Tygh::$app['view']->assign('ab__stickers_default_placeholders',$default_placeholders);return [CONTROLLER_STATUS_OK];}
