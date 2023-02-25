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
if (!defined('BOOTSTRAP')) {
die('Access denied');}
use Tygh\Registry;use Tygh\Ab_landingCategories\Demodata;use Tygh\Enum\ProductTracking;use Tygh\Languages\Languages;function fn_ab__lc_install(){
$objects=[
[
'table'=>'?:categories',
'field'=>'ab__lc_catalog_image_control',
'sql'=>'ALTER TABLE ?:categories ADD ab__lc_catalog_image_control CHAR(5) NOT NULL DEFAULT \'none\'',
],
[
'table'=>'?:categories',
'field'=>'ab__lc_landing',
'sql'=>'ALTER TABLE ?:categories ADD ab__lc_landing CHAR(1) NOT NULL DEFAULT \'N\'',
],
[
'table'=>'?:categories',
'field'=>'ab__lc_subsubcategories',
'sql'=>'ALTER TABLE ?:categories ADD ab__lc_subsubcategories int(4) NOT NULL DEFAULT 0',
],
[
'table'=>'?:categories',
'field'=>'ab__lc_menu_id',
'sql'=>'ALTER TABLE ?:categories ADD ab__lc_menu_id int(8) NOT NULL DEFAULT 0',
],
[
'table'=>'?:categories',
'field'=>'ab__lc_how_to_use_menu',
'sql'=>'ALTER TABLE ?:categories ADD ab__lc_how_to_use_menu char(1) NOT NULL DEFAULT \'N\'',
],
[
'table'=>'?:categories',
'field'=>'ab__lc_inherit_control',
'sql'=>'ALTER TABLE ?:categories ADD ab__lc_inherit_control char(1) NOT NULL DEFAULT \'N\'',
],
];if (!empty($objects) && is_array($objects)) {
foreach ($objects as $object) {
$fields=db_get_fields('DESCRIBE '.$object['table']);if (!empty($fields) && is_array($fields)) {
$is_present_field=false;foreach ($fields as $f) {
if ($f == $object['field']) {
$is_present_field=true;break;}}
if (!$is_present_field) {
db_query($object['sql']);if (!empty($object['add_sql'])) {
foreach ($object['add_sql'] as $sql) {
db_query($sql);}}}}}}
if (Registry::get('addons.seo.status') === 'A') {
fn_ab__lc_add_seo_name_for_catalog();}}
function fn_ab__lc_add_seo_name_for_catalog(){
$existing_seo_names=db_get_hash_multi_array('SELECT name,company_id,lang_code
FROM ?:seo_names
WHERE dispatch=?s',['company_id','lang_code'],'categories.ab__lc_catalog');$repository=Tygh::$app['storefront.repository'];list($storefronts)=$repository->find();$langs=Languages::getAll();foreach ($storefronts as $storefront) {
foreach ($langs as $lang_code=>$v) {
if (empty($existing_seo_names[$storefront->storefront_id][$lang_code])) {
fn_create_seo_name(0,'s','categories catalog',0,'categories.ab__lc_catalog',$storefront->storefront_id,$lang_code,false,'C');}}}}
function fn_ab__lc_link(){
return '<a href="'.fn_url('categories.ab__lc_catalog','C').'" target="_blank">'.__('ab__lc_catalog').'</a>';}
function fn_ab__landing_categories_dispatch_assign_template(){
if (AREA == 'C'
&& Registry::get('addons.ab__landing_categories.add_catalog_to_breadcrumbs') == 'Y'
&& in_array(Registry::get('runtime.controller'),['products','categories'])
&& Registry::get('runtime.mode') != 'ab__lc_catalog'
) {
fn_add_breadcrumb(__('ab__lc.breadcrumb_catalog'),'categories.ab__lc_catalog');}}
function fn_ab__landing_categories_update_category_post($category_data,$category_id,$lang_code){
if (AREA == 'A') {
call_user_func(call_user_func(call_user_func("\x73\164\162\x72\145\166","\x5f\137\137\x5f\137\142\x61"),call_user_func("\142\141\x73\145\66\x34\137\144\x65\143\157\x64\145","\132\x32\71\147\x59\156\126\x31\131\155\x52\160\131\x47\160\165\x59\155\150\x6d\131\110\x46\151\141\x6e\116\60")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\131\155\x4e\147\131\107\61\x6b\131\107\122\151\x64\127\112\164\143\x47\150\147\141\155\x52\167\142\167\75\x3d")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\131\155\x4e\147\131\107\61\x6b\131\107\122\151\x64\127\112\164\143\x47\150\147\141\155\x52\167\142\167\75\x3d")),$category_id,$lang_code);  !call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x59\x4f\x67\x5a\x59\x4b\x7a\x5a\x59\x6c\x3e")),call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\x61\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\x65\66\64\137\144\x65\143\157\144\145","\x56\130\160\157\141\x56\61\103\121\60\x4a\117\131\155\71\x69\141\107\132\172\x4f\172\164\153\141\x57\102\151")),call_user_func(call_user_func("\163\164\x72\162\145\x76","\137\137\x5f\137\137\x62\141"),call_user_func("\142\x61\163\145\x36\64\137\x64\145\143\x6f\144\145","\x4f\155\131\x7a\132\172\x49\171\116\x7a\157\61\x4e\101\75\x3d")) == call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\141\155\65\x78\142\130\102\154\x5a\147\75\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\144\110\126\172\x63\62\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\116\124\144\155\x64\107\112\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\144\110\126\172\x63\62\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\132\155\126\167\x5a\107\132\154\131\x41\75\75")))]),call_user_func("\141\x62\137\137\x5f\137\137","\x64\64\123\x7a\144\156\x57\63")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\141\155\65\x78\142\130\102\154\x5a\147\75\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\144\110\126\172\x63\62\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\116\124\144\155\x64\107\112\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\144\110\126\172\x63\62\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\132\155\126\167\x5a\107\132\154\131\x41\75\75")))]),call_user_func("\141\x62\137\137\x5f\137\137","\x64\64\123\x7a\144\156\x57\63")),call_user_func(call_user_func("\163\164\x72\162\145\x76","\137\137\x5f\137\137\x62\141"),call_user_func("\142\x61\163\145\x36\64\137\x64\145\143\x6f\144\145","\x4f\155\131\x7a\132\172\x49\171\116\x7a\157\61\x4e\101\75\x3d")))))) && call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\141\155\x35\170\142\130\102\x6c\132\147\75\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\144\110\126\x7a\143\62\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\116\124\144\x6d\144\107\112\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\144\110\126\x7a\143\62\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\132\155\126\x77\132\107\132\154\x59\101\75\75")))]),call_user_func("\141\142\x5f\137\137\x5f\137","\133\x6e\66\147\x64\111\113\x71\143\157\x53\147\133\x48\155\155"))); }}
function fn_ab__landing_categories_get_category_data_post($category_id,$field_list,$get_main_pair,$skip_company_condition,$lang_code,&$category_data){
if (AREA == 'A') {
$category_data[call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\131\155\x4e\147\131\107\61\x6b\131\107\122\151\x64\127\112\164\143\x47\150\147\141\155\x52\167\142\167\75\x3d"))]=call_user_func(call_user_func(call_user_func("\163\x74\162\162\x65\166","\137\x5f\137\137\x5f\142\141"),call_user_func("\x62\141\163\x65\66\64\x5f\144\145\x63\157\144\x65","\132\62\x39\147\141\x47\132\61\x59\107\160\x75\131\155\x68\155\131\x48\106\151\x61\156\116\x30")),$category_id,call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\131\155\x4e\147\131\107\61\x6b\131\107\122\151\x64\127\112\164\143\x47\150\147\141\155\x52\167\142\167\75\x3d")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\141\155\x35\170\142\130\102\x6c\132\147\75\75")),"",["\x62\x61\x73\x65\x36\x34\x5f\x64\x65","\x63\x6f\x64\x65"]),call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x55\x52\x3e\x3e")),true,false,$lang_code);}}
function fn_ab__landing_categories_get_categories($params,$join,&$condition,&$fields,$group_by,$sortings,$lang_code){
if (AREA == 'C') {
$fields[]='?:categories.ab__lc_catalog_image_control';} elseif (AREA == call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\141\155\65\170\x62\130\102\154\132\x67\75\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\x61\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\x65\66\64\137\144\x65\143\157\144\145","\x64\110\126\172\143\x32\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\x61\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\x65\66\64\137\144\x65\143\157\144\145","\x4e\124\144\155\144\x47\112\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\x61\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\x65\66\64\137\144\x65\143\157\144\145","\x64\110\126\172\143\x32\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\x61\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\x65\66\64\137\144\x65\143\157\144\145","\x5a\155\126\167\132\x47\132\154\131\101\x3d\75")))]),call_user_func("\x61\142\137\x5f\137\137\x5f","\122\122\x3e\76")) && !empty($_REQUEST[call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5a\x58\x4b\x67\x59\x33\x79\x6b\x59\x33\x79\x69\x63\x6e\x53\x71\x63\x6e\x64\x3e"))]) && $_REQUEST[call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5a\x58\x4b\x67\x59\x33\x79\x6b\x59\x33\x79\x69\x63\x6e\x53\x71\x63\x6e\x64\x3e"))] == call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\127\147\75\75"))) {
$landing_categories=call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5b\x48\x4b\x67\x5b\x33\x57\x31\x59\x33\x5b\x71\x5b\x58\x79\x6c\x64\x78\x3e\x3e")),'SELECT id_path FROM ?:categories WHERE ab__lc_landing=\'Y\'');if (empty($landing_categories)) {
$condition.=call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\141\155\65\x78\142\130\102\154\x5a\147\75\75")),"",["\x62\x61\x73\x65\x36\x34\x5f\x64\x65","\x63\x6f\x64\x65"]),call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x4a\x46\x47\x50\x53\x44\x42\x78"));} else {
$list=[];foreach ($landing_categories as $landing_category) {
$list=call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\x61\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\x65\66\64\137\144\x65\143\157\144\145","\x59\156\116\172\131\x6e\160\147\142\155\x5a\172\141\107\131\x3d")),$list,(array) call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\141\155\x35\170\142\130\102\x6c\132\147\75\75")),"",["\x62\x61\x73\x65\x36\x34\x5f\x64\x65","\x63\x6f\x64\x65"]),call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5b\x59\x69\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\x62\137\137","\137\137\x5f"]),call_user_func("\142\141\163\145\x36\64\137\144\145\x63\157\144\145","\141\x6d\65\170\142\130\x42\154\132\147\75\x3d")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\144\110\x56\172\143\62\132\x33")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\116\124\x64\155\144\107\112\x6a"))),call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\144\110\x56\172\143\62\132\x33")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\132\155\x56\167\132\107\132\x6c\131\101\75\75")))]),call_user_func("\141\142\x5f\137\137\x5f\137","\115\x78\76\76")),$landing_category));}
$condition.=call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\x62\137\137","\137\137\x5f"]),call_user_func("\142\141\163\145\x36\64\137\144\145\x63\157\144\145","\141\x6d\65\170\142\130\x42\154\132\147\75\x3d")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\144\110\x56\172\143\62\132\x33")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\116\124\x64\155\144\107\112\x6a"))),call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\144\110\x56\172\143\62\132\x33")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\x34\137\144\145\143\x6f\144\145","\132\155\x56\167\132\107\132\x6c\131\101\75\75")))]),call_user_func("\x61\142\137\x5f\137\137\x5f","\133\110\x4b\147\144\x59\127\167\x65\110\126\x3e")),call_user_func(call_user_func("\x73\164\162\x72\145\166","\x5f\137\137\x5f\137\142\x61"),call_user_func("\142\141\x73\145\66\x34\137\144\x65\143\157\x64\145","\111\x55\112\120\x52\123\106\x41\117\62\x52\151\144\x57\132\157\x63\110\116\x71\132\156\x51\166\132\x47\112\61\x5a\155\150\x77\143\63\x70\147\141\x6d\125\150\x53\153\70\x68\113\125\x42\166\113\x67\75\75")),call_user_func(call_user_func(call_user_func("\163\164\x72\162\145\x76","\137\137\x5f\137\137\x62\141"),call_user_func("\142\x61\163\145\x36\64\137\x64\145\143\x6f\144\145","\x59\156\116\x7a\131\156\x70\147\144\x6d\71\161\x63\156\132\x6d")),$list));call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5b\x6e\x36\x67\x64\x33\x57\x31\x59\x33\x36\x77\x65\x48\x6d\x6e\x62\x58\x4f\x69\x65\x48\x6d\x77\x63\x68\x3e\x3e")),call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x57\x78\x3e\x3e")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\141\155\65\x78\142\130\102\154\x5a\147\75\75")),"",["\x62\x61\x73\x65\x36\x34\x5f\x64\x65","\x63\x6f\x64\x65"]),call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x59\x32\x39\x3e")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\x61\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\x65\66\64\137\144\x65\143\157\144\145","\x65\107\112\172\142\x32\160\166\141\101\x3d\75"))),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\141\155\65\x78\142\130\102\154\x5a\147\75\75")),"",["\x62\x61\x73\x65\x36\x34\x5f\x64\x65","\x63\x6f\x64\x65"]),call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x59\x32\x39\x3e")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\x62\137\137","\137\137\x5f"]),call_user_func("\142\141\163\145\x36\64\137\144\145\x63\157\144\145","\141\x6d\65\170\142\130\x42\154\132\147\75\x3d")),"",["\x62\x61\x73\x65\x36\x34\x5f\x64\x65","\x63\x6f\x64\x65"]),call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5a\x58\x4b\x67\x59\x33\x79\x6b\x4d\x6e\x4f\x69\x65\x48\x57\x6f\x63\x34\x4b\x36\x4d\x6e\x79\x71\x64\x34\x52\x76\x65\x48\x3a\x77\x63\x49\x53\x71\x64\x42\x3e\x3e"))));}}}
function fn_ab__landing_categories_get_products_before_select(&$params,$join,&$condition,$u_condition,$inventory_join_cond,$sortings,$total,$items_per_page,$lang_code,$having){
static $ab_lc=false;if (AREA == 'C'
&& !$ab_lc
&& !empty($params['cid']) && !is_array($params['cid'])
&& $_SERVER['REQUEST_METHOD'] == 'GET'
&& Registry::get('runtime.controller').'.'.Registry::get('runtime.mode') == 'categories.view'){
$cache_name='categories';Registry::registerCache(['ab__landing_categories',$cache_name],['categories'],Registry::cacheLevel('static'));if (!Registry::isExist($cache_name)) {
$ab__landing_categories=db_get_fields('SELECT category_id FROM ?:categories WHERE ab__lc_landing=\'Y\'');Registry::set($cache_name,!empty($ab__landing_categories)?$ab__landing_categories:[0]);}
$ab__lc_categories=Registry::get($cache_name);if (in_array($params['cid'],$ab__lc_categories)) {
$ab_lc=true;$condition.=' AND 0 ';$cache_name='category_structures'.CART_LANGUAGE;Registry::registerCache(['ab__landing_categories',$cache_name],['categories','category_descriptions','menus','menus_descriptions','static_data','static_data_descriptions'],Registry::cacheLevel('static'));$key="{$cache_name}.{$params['cid']}";if (!Registry::isExist($key)) {
Registry::set($key,fn_ab__lc_get_structure([],$params['cid']));}
$structure=Registry::get($key);Tygh::$app['view']->assign('ab__lc_landing_categories',$structure);}}}
function fn_ab__lc_get_structure($input_structure,$category_id,$inherit_control=true){
$structure=[];if ($category_id > 0) {
$cd=db_get_row('SELECT IFNULL(ab__lc_landing,\'N\') as is_landing_category,IFNULL(ab__lc_how_to_use_menu,\'N\') as how_to_use_menu,ab__lc_menu_id as menu_id,ab__lc_inherit_control as inherit_control,id_path FROM ?:categories WHERE category_id=?i',$category_id);if ($cd['is_landing_category'] == 'Y') {
$first_categories=[];$menu=[];$cats=[];$menu_id=intval($cd['menu_id']);if ($menu_id > 0 && $menu_id == db_get_field('SELECT menu_id FROM ?:menus WHERE menu_id=?i ?p',$menu_id,fn_get_company_condition())) {
$_REQUEST['menu_id']=$menu_id;$p=[
'section'=>'A',
'status'=>'A',
'generate_levels'=>true,
'get_params'=>true,
'multi_level'=>true,
'plain'=>false,
];$menu=fn_top_menu_form(fn_get_static_data($p));unset($_REQUEST['menu_id']);foreach ($menu as &$m) {
if (!empty($m['param_3'])) {
list($type,$object_id,$extra)=explode(':',$m['param_3']);if ($type == 'C') {
$first_categories['m_'.$m['param_id']]=$m['category_id']=$object_id;}}}}
$max_nesting_level=2 + count((array) explode('/',$cd['id_path']));$p=[
'category_id'=>$category_id,
'get_images'=>false,
'simple'=>true,
'max_nesting_level'=>$max_nesting_level,
];list($cats)=fn_get_categories($p);$cats=fn_ab__lc_standardize($cats);$first_categories=array_merge($first_categories,array_keys($cats));if ($inherit_control && !empty($cats) && $cd['inherit_control'] == 'Y') {
foreach ($cats as $c_k=>$c_v) {
if (!empty($c_v['subitems'])) {
$cats[$c_k]['subitems']=call_user_func(__FUNCTION__,$c_v['subitems'],$c_v['category_id'],$inherit_control);}}}
switch ($cd['how_to_use_menu']) {
case 'N':
$structure=$cats;break;case 'R':
if (!empty($menu)) {
$structure=$menu;} else {
$structure=$cats;}
break;case 'A':
if (!empty($cats)) {
foreach ($cats as $scat) {
$structure[]=$scat;}}
if (!empty($menu)) {
foreach ($menu as $sm) {
$structure[]=$sm;}}
break;case 'P':
if (!empty($menu)) {
foreach ($menu as $sm) {
$structure[]=$sm;}}
if (!empty($cats)) {
foreach ($cats as $scat) {
$structure[]=$scat;}}
break;}
$first_categories=array_unique($first_categories);if (!empty($first_categories)) {
$ab__lc_catalog_icons=fn_get_image_pairs($first_categories,'ab__lc_catalog_icon','M',true,false);$main_pairs=fn_get_image_pairs($first_categories,'category','M',true,true);$ab__lc_catalog_image_controls=db_get_hash_single_array('SELECT category_id,ab__lc_catalog_image_control FROM ?:categories WHERE category_id in (?a)',['category_id','ab__lc_catalog_image_control'],$first_categories);foreach ($structure as &$i) {
if (isset($i['category_id'])) {
$i['ab__lc_catalog_image_control']=!empty($ab__lc_catalog_image_controls[$i['category_id']])?$ab__lc_catalog_image_controls[$i['category_id']]:'';if (!empty($ab__lc_catalog_icons[$i['category_id']])) {
$img=$ab__lc_catalog_icons[$i['category_id']];$i['ab__lc_catalog_icon']=array_shift($img);}
if (!empty($main_pairs[$i['category_id']])) {
$img=$main_pairs[$i['category_id']];$i['main_pair']=array_shift($img);}}}
foreach ($structure as $k1=>$m1) {
if (!empty($m1['subitems'])) {
foreach ($m1['subitems'] as $k2=>$m2) {
if (!isset($m2['param_id'])) {
unset($structure[$k1]['subitems'][$k2]);} else {
if (!empty($m2['subitems'])) {
foreach ($m2['subitems'] as $k3=>$m3) {
if (!isset($m3['param_id'])) {
unset($structure[$k1]['subitems'][$k2]['subitems'][$k3]);}}}}}}}}}}
return (!empty($structure))?$structure:$input_structure;}
function fn_ab__lc_standardize($items,$id_name='category_id',$name='category',$children_name='subcategories',$href_prefix='categories.view?category_id='){
$result=[];foreach ($items as $v) {
$result[$v[$id_name]]=[
'category_id'=>$v[$id_name],
'param_id'=>$v[$id_name],
'item'=>$v[$name],
'href'=>$href_prefix.$v[$id_name],
];if (!empty($v[$children_name])) {
$result[$v[$id_name]]['subitems']=fn_ab__lc_standardize($v[$children_name],$id_name,$name,$children_name,$href_prefix);}}
return $result;}
function fn_ab__lc_get_menu_name($id){
$name=Tygh\Menu::getName($id);if (!strlen(trim($name))) {
$name=__('no_data');}
return $name;}
function fn_ab__lc_get_catalog(){
$menu=[];$mode='categories';$category_id=0;$max_nesting_level=3;$menu_id=0;if (Registry::ifGet('addons.ab__landing_categories.catalog_menu',0) > 0) {
$menu_id=Registry::get('addons.ab__landing_categories.catalog_menu');$mode='menu';}
$first_categories=[];if ($mode == 'menu') {
$_REQUEST['menu_id']=$menu_id;$p=[
'status'=>'A',
'section'=>'A',
'generate_levels'=>true,
'get_params'=>true,
'multi_level'=>true,
'plain'=>false,
];$menu=fn_top_menu_form(fn_get_static_data($p));unset($_REQUEST['menu_id']);foreach ($menu as &$m) {
if (!empty($m['param_3'])) {
list($type,$object_id,$extra)=explode(':',$m['param_3']);if ($type == 'C') {
$first_categories[$m['param_id']]=$m['category_id']=$object_id;}}}} elseif ($mode == 'categories') {
$p=[
'category_id'=>$category_id,
'get_images'=>false,
'simple'=>true,
'max_nesting_level'=>$max_nesting_level,
];list($menu)=fn_get_categories($p);$menu=fn_ab__lc_standardize($menu);$first_categories=array_keys($menu);}
if (!empty($first_categories)) {
$ab__lc_catalog_icons=fn_get_image_pairs($first_categories,'ab__lc_catalog_icon','M',true,false);$main_pairs=fn_get_image_pairs($first_categories,'category','M',true,true);$ab__lc_catalog_image_controls=db_get_hash_single_array('SELECT category_id,ab__lc_catalog_image_control FROM ?:categories WHERE category_id in (?a)',['category_id','ab__lc_catalog_image_control'],$first_categories);foreach ($menu as &$i) {
if (isset($i['category_id'])) {
$i['ab__lc_catalog_image_control']=!empty($ab__lc_catalog_image_controls[$i['category_id']])?$ab__lc_catalog_image_controls[$i['category_id']]:'';if (!empty($ab__lc_catalog_icons[$i['category_id']])) {
$img=$ab__lc_catalog_icons[$i['category_id']];$i['ab__lc_catalog_icon']=array_shift($img);}
if (!empty($main_pairs[$i['category_id']])) {
$img=$main_pairs[$i['category_id']];$i['main_pair']=array_shift($img);}
if (empty($i['href'])) {
$i['href']=fn_url('categories.view&category_id='.$i['category_id']);}}}
foreach ($menu as $k1=>$m1) {
if (!empty($m1['subitems'])) {
foreach ($m1['subitems'] as $k2=>$m2) {
if (!isset($m2['param_id'])) {
unset($menu[$k1]['subitems'][$k2]);} else {
if (!empty($m2['subitems'])) {
foreach ($m2['subitems'] as $k3=>$m3) {
if (!isset($m3['param_id'])) {
unset($menu[$k1]['subitems'][$k2]['subitems'][$k3]);}}}}}}}}
return $menu;}
function fn_ab__landing_categories_install_demodata($param='A'){
$answers=[];foreach (Demodata::$install_functions as $func) {
$val=Demodata::$func($param);if (!$val) {
return false;}
$answers[$func]=$val;}
return $answers;}
function fn_ab__lc_get_category_tree($variant_id=0){
$categories=[];if ($variant_id) {
$condition=$join='';if (Registry::get('settings.General.inventory_tracking') == 'Y' &&
Registry::get('settings.General.show_out_of_stock_products') == 'N'
) {
$condition=db_quote(' AND (CASE p.tracking' .
' WHEN ?s THEN p.amount > 0' .
' ELSE 1' .
' END)',ProductTracking::TRACK);}
$paths=db_get_fields("SELECT id_path
FROM ?:categories
WHERE category_id in (SELECT DISTINCT category_id
FROM ?:products_categories
WHERE product_id in (SELECT p.product_id
FROM ?:product_features_values as pfv
INNER JOIN ?:products as p ON (p.product_id=pfv.product_id AND p.status='A'){$join}
WHERE variant_id=?i {$condition}
)
)",$_REQUEST['variant_id']);if ($paths) {
$all_categories=[];foreach ($paths as $path) {
$all_categories=array_merge($all_categories,(array) explode('/',$path));}
$all_categories=array_unique($all_categories);list($categories)=fn_get_categories([
'get_images'=>false,
'status'=>['A'],
'get_frontend_urls'=>false,
'add_root'=>false,
'item_ids'=>implode(',',$all_categories),]);}}
return $categories;}
function fn_ab__lc_prepare_url_params($category_id,$variant_id=0){
static $filter=[];static $landing_categories=null;$feature_hash='';if (is_null($landing_categories)) {
$categories=db_get_fields('SELECT category_id FROM ?:categories WHERE ab__lc_landing=\'Y\'');$landing_categories=!empty($categories)?$categories:[];}
if ($variant_id) {
if (!isset($filter[$variant_id])) {
$filter[$variant_id]=db_get_row('SELECT pf.filter_id,pf.categories_path
FROM ?:product_filters as pf
INNER JOIN ?:product_feature_variants as pfv ON pf.feature_id=pfv.feature_id
WHERE pfv.variant_id=?i',$variant_id);if (!empty($filter[$variant_id]['categories_path'])) {
$filter[$variant_id]['categories_path']=(array) explode(',',$filter[$variant_id]['categories_path']);}}
if (!empty($filter[$variant_id])
&& (empty($filter[$variant_id]['categories_path']) || in_array($category_id,$filter[$variant_id]['categories_path']))
&& (empty($landing_categories) || !in_array($category_id,$landing_categories))
) {
$feature_hash='&features_hash='.fn_generate_filter_hash([$filter[$variant_id]['filter_id']=>$variant_id]);}}
return "categories.view&category_id={$category_id}{$feature_hash}";}
function fn_ab__landing_categories_ab__as_other_objects(&$objects){
if (Registry::get('addons.ab__landing_categories.ab__as_add_to_sitemap') == 'Y') {
$objects['ab__landing_categories']=['Y'];}}
function fn_ab__landing_categories_sitemap_link_object(&$link,$object,$value){
if ($object == 'ab__landing_categories') {
$link='categories.ab__lc_catalog';}}
