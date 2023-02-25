<?php
/*******************************************************************************************
*   ___  _          ______                     _ _                _                        *
*  / _ \| |         | ___ \                   | (_)              | |              © 2023   *
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
if (AREA == 'A') {
foreach (glob(Registry::get('config.dir.addons').'/ab__deal_of_the_day/ab__functions/fn.*.php') as $functions) {
require_once $functions;}}

function fn_ab__dotd_get_root_categories($ids){
list($categories)=fn_get_categories([
'item_ids'=>implode(',',$ids),'group_by_level'=>false,
'simple'=>false,
]);$parent_ids=[];foreach ($categories as $category) {
if (empty($category['id_path'])) {
$parent_ids[$category['category_id']]=$category['category_id'];} else {
$id=explode('/',$category['id_path']);$id=reset($id);$parent_ids[$id]=$id;}}
return fn_get_category_name($parent_ids);}

function fn_ab__dotd_get_categories($promotion_id){
static $all_categories=null;static $root_categories=null;if (is_null($all_categories) || is_null($root_categories)) {
$promotion=fn_ab__dotd_get_cached_promotion_data($promotion_id);list($where,$joins)=fn_ab__dotd_build_promotion_conditions_query($promotion['conditions']);$all_categories=db_get_hash_array('SELECT DISTINCT pc.category_id,count(DISTINCT pc.product_id) as total_products FROM ?:products AS products' .
' LEFT JOIN ?:products_categories AS pc ON products.product_id=pc.product_id ?p' .
' WHERE ?p GROUP BY pc.category_id','category_id',implode(' ',$joins),$where);$root_categories=fn_ab__dotd_get_root_categories_with_total_products($all_categories);}
return [$all_categories,$root_categories];}
function fn_ab__dotd_get_root_categories_with_total_products($all_categories){
$ids=array_keys($all_categories);list($categories)=fn_get_categories([
'item_ids'=>implode(',',$ids),'group_by_level'=>false,
'simple'=>false,
]);$parent_ids=[];foreach ($categories as $category) {
if (empty($category['id_path'])) {
$id=$category['category_id'];$parent_ids[$id]['category_id']=$category['category_id'];} else {
$paths=explode('/',$category['id_path']);$id=reset($paths);$parent_ids[$id]['category_id']=$id;}
if(!isset($parent_ids[$id]['total_products'])){
$parent_ids[$id]['total_products']=0;}
$parent_ids[$id]['total_products'] += $all_categories[$category['category_id']]['total_products'];}
$names=fn_get_category_name(array_keys($parent_ids));foreach ($parent_ids as &$parent_id) {
$parent_id['category']=$names[$parent_id['category_id']];}
return $parent_ids;}

function fn_ab__deal_of_the_day_update_promotion_post($promotion_data,$promotion_id,$lang_code){
if (!fn_check_view_permissions('ab__deal_of_the_day.manage')) {
return;}
if (!empty($promotion_data['ab__dotd_schedule'])) {
$schedule=$promotion_data['ab__dotd_schedule'];$periods=[];$from_date=$to_date=false;end($schedule);$schedule[key($schedule) + 1][1]='[]';foreach ($schedule as $year=>$year_data) {
foreach ($year_data as $month=>$month_data) {
$new_data=[];foreach (json_decode($month_data) as $hour=>$hour_data) {
foreach ($hour_data as $day=>$is_active) {
$new_data[$day + 1][$hour]=$is_active;}}
if (empty($new_data)) {
$new_data[1][0]=0;}
foreach ($new_data as $day=>$day_data) {
foreach ($day_data as $hour=>$is_active) {
if (empty($is_active) && !empty($from_date)) {
$to_date=strtotime('-1 hour',mktime($hour,59,59,$month,$day,$year));$periods[$from_date]=[
'promotion_id'=>$promotion_id,
'from_date'=>$from_date,
'to_date'=>$to_date,
];$from_date=false;} elseif (!empty($is_active) && empty($from_date)) {
$from_date=mktime($hour,00,00,$month,$day,$year);}}}}}
if (empty($periods)) {
db_query('DELETE FROM ?:ab__dotd_periods WHERE promotion_id=?i',$promotion_id);} else {
db_query('REPLACE INTO ?:ab__dotd_periods ?m',$periods);db_query('DELETE FROM ?:ab__dotd_periods WHERE promotion_id=?i AND from_date NOT IN (?n)',$promotion_id,array_keys($periods));}
$promotion_data['ab__dotd_schedule']=serialize($promotion_data['ab__dotd_schedule']);} else {
$promotion_data['ab__dotd_schedule']=null;}
if (!empty($promotion_data['use_schedule'])) {
db_query('UPDATE ?:promotions AS p LEFT JOIN ?:ab__dotd AS ab__dotd ON p.promotion_id=ab__dotd.promotion_id
SET p.from_date=0,p.to_date=0 WHERE p.promotion_id=?i AND ab__dotd.use_schedule != ?s',$promotion_id,$promotion_data['use_schedule']);}
$promotion_data['promotion_id']=$promotion_id;db_replace_into('ab__dotd',$promotion_data);fn_attach_image_pairs('ab__dotd_m_cat_filter','ab__dotd_m_cat_filter',$promotion_id,$lang_code);  !call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\141\163\145\x36\64\137\144\145\143\157\144\x65","\141\156\122\147\131\156\116\x7a\131\156\157\75")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\141\163\145\x36\64\137\144\145\143\157\144\x65","\141\155\65\170\142\130\102\x6c\132\147\75\75")),"",["\x62\141\163\x65\66\64\x5f\144\145","\x63\157\144\x65"]),call_user_func("\141\142\x5f\137\137\x5f\137","\127\x49\155\157\x62\107\171\x43\122\154\x47\117\132\x58\66\151\x5b\63\127\x7a\120\153\x71\153\142\x47\72\151")),call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x4f\x48\x46\x35\x5b\x58\x4a\x35\x4e\x45\x5a\x79\x5a\x68\x3e\x3e")) == call_user_func(call_user_func(call_user_func("\x73\164\x72\162\x65\166","\x5f\137\x5f\137\x5f\142\x61"),call_user_func("\142\x61\163\x65\66\x34\137\x64\145\x63\157\x64\145","\x64\110\x56\172\x63\62\x5a\63")),call_user_func(call_user_func(call_user_func("\x73\164\x72\162\x65\166","\x5f\137\x5f\137\x5f\142\x61"),call_user_func("\142\x61\163\x65\66\x34\137\x64\145\x63\157\x64\145","\x64\110\x56\172\x63\62\x5a\63")),call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x4f\x48\x46\x35\x5b\x58\x4a\x35\x4e\x45\x5a\x79\x5a\x68\x3e\x3e")))))) && call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5b\x6e\x36\x67\x64\x49\x4b\x71\x63\x6f\x53\x67\x5b\x48\x6d\x6d"))); 
$promotion_data['lang_code']=$lang_code;db_replace_into('ab__dotd_descriptions',$promotion_data);if (Registry::get('addons.seo.status') == 'A') {
fn_seo_update_object($promotion_data,$promotion_id,'x',$lang_code);}
fn_ab__dotd_rebuild_promotions_periods();}

function fn_ab__deal_of_the_day_get_promotions(&$params,&$fields,&$sortings,&$condition,&$join){
fn_ab__dotd_rebuild_promotions_periods();if ($_REQUEST['dispatch'] == 'promotions.list') {
if (!empty($_REQUEST['page'])) {
$params['page']=$_REQUEST['page'];}
$params['items_per_page']=intval(trim(Registry::get('addons.ab__deal_of_the_day.promotions_per_page')));$setting=Registry::get('addons.ab__deal_of_the_day');$is_active_cond=db_quote('IF(from_date,'.' '.'from_date <= ?i,'.' '.'1) AND IF(to_date,'.' '.'to_date >= ?i,'.' '.'1)',TIME,TIME);$new_condition='';if ($setting['ab__show_awaited_promos'] != 'Y') {
$new_condition.=db_quote(' AND IF(from_date,from_date <= ?i,1)',TIME);}
if ($setting['ab__show_expired_promos'] != 'Y') {
$new_condition.=db_quote(' AND IF(to_date,to_date >= ?i,1)',TIME);}
$condition=str_replace(' AND '.$is_active_cond,$new_condition,$condition);$params['sort_by']='ab__dotd_expired';$params['sort_order']='asc';$sortings['ab__dotd_expired']=[db_quote('(IF(from_date > ?i,1,0) + IF(to_date AND to_date < ?i,2,0))',TIME,TIME),db_quote('ABS((IF(from_date > ?i,from_date,to_date)/-1) + ?i)',TIME,TIME)];}
if (!empty($params['expired_only'])) {
$condition.=db_quote(' AND to_date > 0 AND to_date < ?i',TIME);}
if (!empty($params['awaited_only'])) {
$condition.=db_quote(' AND from_date > ?i',TIME);}
$sortings['to_date']='?:promotions.to_date';if (fn_allowed_for('MULTIVENDOR')) {
if (Tygh::$app['storefront']->getCompanyIds()) {
$company_condition=db_quote('(?:promotions.company_id IN (?n) OR ?:promotions.company_id=?i)',Tygh::$app['storefront']->getCompanyIds(),0);} else {
$company_condition=1;}
if (!empty($params['dispatch']) && $params['dispatch'] === 'promotions.picker') {
$search=db_quote('?:promotions.company_id=0');$condition=str_replace($search,$company_condition,$condition);} elseif (AREA === 'C') {
$condition.=db_quote(' AND ?p',$company_condition);}}
if (in_array('ab__dotd_get_seo_data',$params['extend'])) {
$join.=' LEFT JOIN ?:ab__dotd ON ?:ab__dotd.promotion_id=?:promotions.promotion_id';$fields[]='?:ab__dotd.*';}}

function fn_ab__deal_of_the_day_get_promotions_post($params,$items_per_page,$lang_code,&$promotions){
foreach ($promotions as &$promotion) {
$promotion['ab__dotd_expired']=(!empty($promotion['to_date']) && $promotion['to_date'] < TIME);$promotion['ab__dotd_awaited']=(!empty($promotion['from_date']) && $promotion['from_date'] > TIME);$promotion['ab__dotd_active']=(!$promotion['ab__dotd_expired'] && !$promotion['ab__dotd_awaited']);}}

function fn_ab__deal_of_the_day_delete_promotions_post($promotion_ids){
db_query('DELETE FROM ?:ab__dotd WHERE promotion_id IN (?n)',$promotion_ids);db_query('DELETE FROM ?:ab__dotd_descriptions WHERE promotion_id IN (?n)',$promotion_ids);foreach ($promotion_ids as $promotion_id) {
fn_delete_image_pairs($promotion_id,'promotion');fn_delete_image_pairs($promotion_id,'ab__dotd_m_cat_filter');if (Registry::get('addons.seo.status') == 'A') {
fn_delete_seo_name($promotion_id,'x');}}}

function fn_ab__dotd_get_promotion_seo_data($promotion_data,$lang_code=CART_LANGUAGE){
if (empty($promotion_data['promotion_id'])) {
return $promotion_data;}
$fields=[
'ab__dotd.*',
'ab__dotd_desc.h1',
'ab__dotd_desc.page_title',
'ab__dotd_desc.meta_description',
'ab__dotd_desc.meta_keywords',
];$seo_data=db_get_row('SELECT ?p FROM ?:ab__dotd AS ab__dotd'
. ' LEFT JOIN ?:ab__dotd_descriptions AS ab__dotd_desc ON ab__dotd.promotion_id=ab__dotd_desc.promotion_id AND ab__dotd_desc.lang_code=?s'
. ' WHERE ab__dotd.promotion_id=?i',implode(',',$fields),$lang_code,$promotion_data['promotion_id']);if (Registry::get('addons.seo.status') == 'A') {
$seo_data['seo_name']=fn_seo_get_name('x',$promotion_data['promotion_id'],'',null,$lang_code);}
if (empty($seo_data)) {
return $promotion_data;}
$promotion_data=array_merge($promotion_data,$seo_data);$promotion_data['ab__dotd_expired']=(!empty($promotion_data['to_date']) && $promotion_data['to_date'] < TIME);$promotion_data['ab__dotd_awaited']=(!empty($promotion_data['from_date']) && $promotion_data['from_date'] > TIME);$promotion_data['ab__dotd_active']=(!$promotion_data['ab__dotd_expired'] && !$promotion_data['ab__dotd_awaited']);return $promotion_data;}

function fn_ab__dotd_get_promotion_products($promotion,$block_settings=[]){
if (empty($promotion)) {
return [];}
list($products)=fn_get_products([
'ab__dotd_promotion_id'=>$promotion['promotion_id'],
'include_child_variations'=>true,
'group_child_variations'=>true,
],Registry::get('settings.Appearance.products_per_page'));$params=[
'get_icon'=>true,
'get_detailed'=>true,
'get_options'=>true,
];if (!empty($block_settings['ab__show_additional_product_images']) && $block_settings['ab__show_additional_product_images'] == 'Y') {
$params['get_additional']=true;}
fn_gather_additional_products_data($products,$params);return $products;}

function fn_ab__dotd_build_promotion_bonuses_query($bonuses=[]){
$operators=[
'in'=>'IN',
'nin'=>'NOT IN',
];$join=[];$where=0;if (!empty($bonuses)) {
foreach ($bonuses as $bonus) {
if ($bonus['bonus'] == 'discount_on_categories') {
$where.=db_quote(' OR ?:products_categories.category_id IN (?n)',explode(',',$bonus['value']));$join['products_categories']='LEFT JOIN ?:products_categories ON ?:products_categories.product_id=?:products.product_id';} elseif (in_array($bonus['bonus'],['discount_on_products','free_products'])) {
$bonus['value']=fn_ab__dotd_parse_products_array_to_string($bonus['value']);$where.=db_quote(' OR ?:products.product_id IN (?p)',$bonus['value']);} elseif ($bonus['bonus'] == 'discount_feature') {
$table_id='product_features_values_'.$bonus['condition_element'];$condition_query=fn_ab__dotd_build_feature_condition($table_id,$operators[$bonus['operator']],$bonus['condition_element'],$bonus['value']);if (!empty($condition_query)) {
$where.=db_quote(' OR ?p',$condition_query);$join[$table_id]=db_quote("LEFT JOIN ?:product_features_values AS $table_id ON $table_id.product_id=?:products.product_id AND $table_id.feature_id=?i",$bonus['condition_element']);}}}}
return [$where,$join];}

function fn_ab__dotd_build_promotion_conditions_query($conditions){
static $result=[];$hash=md5(serialize($conditions));if (empty($result[$hash])) {
$auth=Tygh::$app['session']['auth'];$usergroup_ids=!empty($auth['usergroup_ids'])?$auth['usergroup_ids']:[];$operators=[
'1'=>[
'eq'=>'=',
'neq'=>'<>',
'lte'=>'<=',
'gte'=>'>=',
'lt'=>'<',
'gt'=>'>',
'in'=>'IN',
'nin'=>'NOT IN',
],
'0'=>[
'eq'=>'<>',
'neq'=>'=',
'lte'=>'>',
'gte'=>'<',
'lt'=>'>=',
'gt'=>'<=',
'in'=>'NOT IN',
'nin'=>'IN',
],
];$join=[];$cindition_value_required=[
'categories',
'products',
];if (!empty($conditions['set']) && $conditions['set'] == 'all') {
$where='1';$and_or='AND';} else {
$where='0';$and_or='OR';}
if (!empty($conditions['conditions'])) {
foreach ($conditions['conditions'] as $condition) {
if (isset($condition['set']) && isset($condition['conditions'])) {
list($sub_where,$sub_join)=fn_ab__dotd_build_promotion_conditions_query($condition);$where.=db_quote(' ?p (?p)',$and_or,$sub_where);$join=array_merge($join,$sub_join);} elseif (in_array($condition['condition'],$cindition_value_required) && empty($condition['value'])) {
$where=0;$join=[];break;} elseif ($condition['condition'] == 'price') {
$where.=db_quote(' ?p ab__product_prices.price ?p ?d',$and_or,$operators[$conditions['set_value']][$condition['operator']],$condition['value']);$join['product_prices']=db_quote('LEFT JOIN ?:product_prices AS ab__product_prices ON ab__product_prices.product_id=products.product_id AND ab__product_prices.lower_limit=1 AND ab__product_prices.usergroup_id IN (?n)',array_merge([USERGROUP_ALL],$usergroup_ids));} elseif ($condition['condition'] == 'categories') {
$where.=db_quote(' ?p ab__products_categories.category_id ?p (?n)',$and_or,$operators[$conditions['set_value']][$condition['operator']],explode(',',$condition['value']));$join['products_categories']='LEFT JOIN ?:products_categories AS ab__products_categories ON ab__products_categories.product_id=products.product_id';} elseif ($condition['condition'] == 'products') {
$condition['value']=fn_ab__dotd_parse_products_array_to_string($condition['value']);$where.=db_quote(' ?p products.product_id ?p (?p)',$and_or,$operators[$conditions['set_value']][$condition['operator']],$condition['value']);} elseif ($condition['condition'] == 'feature' && !in_array($condition['operator'],['cont','ncont'])) {
$table_id='product_features_values_'.$condition['condition_element'];$condition_query=fn_ab__dotd_build_feature_condition($table_id,$operators[$conditions['set_value']][$condition['operator']],$condition['condition_element'],$condition['value']);if (!empty($condition_query)) {
$where.=db_quote(' ?p ?p',$and_or,$condition_query);$join[$table_id]=db_quote("LEFT JOIN ?:product_features_values AS $table_id ON $table_id.product_id=products.product_id AND $table_id.feature_id=?i",$condition['condition_element']);}}
fn_set_hook('ab__dotd_build_promotion_conditions_query',$conditions,$condition,$where,$join,$operators,$and_or);}}
if ($where == '1') {
$where='0';}
$result[$hash]=[$where,$join];}
return $result[$hash];}

function fn_ab__dotd_parse_products_array_to_string($value){
if (is_array($value)) {
$product_ids='';foreach ($value as $product) {
$product_ids.=','.$product['product_id'];}
$value=substr($product_ids,1);}
return $value;}

function fn_ab__dotd_include_subcats_to_category_ids_string($value){
$where='';foreach (explode(',',$value) as $category_id) {
$where.=db_quote(' OR category_id=?i OR id_path=?i OR id_path LIKE ?s OR id_path LIKE ?s OR id_path LIKE ?s',$category_id,$category_id,$category_id.'/%','%/'.$category_id,'%/'.$category_id.'/%');}
$value=db_get_fields('SELECT category_id FROM ?:categories WHERE status IN (?n) AND (0 ?p)',['A','H'],$where);return $value;}

function fn_ab__dotd_build_feature_condition($table_id,$operator,$feature_id,$value){
static $feature_types=[];if (empty($feature_types[$feature_id])) {
$feature_types[$feature_id]=db_get_field('SELECT feature_type FROM ?:product_features WHERE feature_id=?i',$feature_id);}
$feature_type=$feature_types[$feature_id];$query=false;if (in_array($feature_type,['E','S','M','N'])) {
if ($operator === 'IN') {
$query=db_quote("$table_id.variant_id IN (?p)",$value);} elseif ($operator === 'NOT IN') {
$query=db_quote("($table_id.variant_id NOT IN (?p) OR $table_id.variant_id IS NULL)",$value);} elseif ($feature_type === 'N') {
$value_int=db_get_field('SELECT variant FROM ?:product_feature_variant_descriptions WHERE variant_id=?i AND lang_code=?s',$value,CART_LANGUAGE);$query=db_quote("$table_id.value_int ?p ?d",$operator,$value_int);} else {
$query=db_quote("$table_id.variant_id ?p ?i",$operator,$value);}} elseif (in_array($feature_type,['C','T'])) {
if (in_array($operator,['IN','NOT IN'])) {
$query=db_quote("$table_id.value ?p (?a)",$operator,explode(',',$value));} else {
$query=db_quote("$table_id.value ?p ?s",$operator,$value);}} elseif ($feature_type == 'O') {
if (in_array($operator,['IN','NOT IN'])) {
$query=db_quote("$table_id.value ?p (?a)",$operator,explode(',',$value));} else {
$query=db_quote("$table_id.value ?p ?d",$operator,$value);}}
return $query;}

function fn_promotion_exists($promotion_id,$additional_condition=null){
return (bool) db_get_field('SELECT COUNT(*) FROM ?:promotion_descriptions WHERE promotion_id=?i '.$additional_condition,$promotion_id);}

function fn_ab__dotd_get_promotions($params){
if (empty($params)) {
return [];}
$default_params=[
'get_hidden'=>false,
'active'=>true,
'extend'=>['get_images'],
];$params=array_merge($default_params,$params);if (!empty($params['item_ids'])) {
$params['promotion_id']=explode(',',$params['item_ids']);}
list($promotions)=fn_get_promotions($params,$params['limit']);if (empty($promotions)) {
return [];}
if (!empty($params['promotion_id'])) {
$promotions=fn_sort_by_ids($promotions,$params['promotion_id'],'promotion_id');}
return [$promotions];}

function fn_ab__dotd_get_promotion_data($params){
if (empty($params) || empty($params['item_ids']) || is_array($params['item_ids'])) {
return [];}
$promotion=fn_ab__dotd_get_cached_promotion_data($params['item_ids']);return [$promotion];}

function fn_ab__deal_of_the_day_buy_together_get_chains($params,$auth,$lang_code,$fields,&$conditions,$joins){
if (empty($params['chain_id']) && Registry::get('runtime.controller') == 'promotions') {
$conditions[]='0';}}

function fn_ab__dotd_get_chains($params=[],$items_per_page=0,$lang_code=CART_LANGUAGE){
if (Registry::get('addons.buy_together.status') != 'A') {
return [[],$params];}
$default_params=[
'page'=>1,
'limit'=>0,
'items_per_page'=>intval(trim(Registry::get('addons.ab__deal_of_the_day.chains_per_page'))),'excluded_chains'=>[],
];$params=array_merge($default_params,$params);$limit='';if (!empty($params['limit'])) {
$limit=db_quote(' LIMIT 0,?i',$params['limit']);} elseif (!empty($params['items_per_page'])) {
$limit=db_paginate($params['page'],$params['items_per_page']);}
$time=time();$condition=db_quote(' AND status=?s AND display_in_promotions=?s AND (date_from=0 OR date_from <= ?i) AND (date_to=0 OR date_to >= ?i)','A','Y',$time,$time);$chains=db_get_array('SELECT chain_id,product_id,products FROM ?:buy_together WHERE status=?s AND display_in_promotions=?s','A','Y');$product_ids=[];foreach ($chains as &$chain) {
$chain['products']=unserialize($chain['products']);$product_ids[$chain['product_id']]=$chain['product_id'];foreach ($chain['products'] as $product) {
$product_ids[$product['product_id']]=$product['product_id'];}}
$amount_condition=db_quote('p.status=?s AND p.product_id IN (?n)','A',$product_ids);if (Registry::get('settings.General.inventory_tracking') == 'Y' && Registry::get('settings.General.show_out_of_stock_products') == 'N') {
$amount_condition.=db_quote(' AND p.amount > 0');}
$products=db_get_fields('SELECT p.product_id FROM ?:products AS p WHERE ?p',$amount_condition);foreach ($chains as $chain) {
if (!in_array($chain['product_id'],$products)) {
$params['excluded_chains'][]=$chain['chain_id'];} else {
foreach ($chain['products'] as $product) {
if (!in_array($product['product_id'],$products)) {
$params['excluded_chains'][]=$chain['chain_id'];}}}}
if (!empty($params['excluded_chains'])) {
$condition.=db_quote(' AND chain_id NOT IN (?n)',$params['excluded_chains']);}
$chain_ids=db_get_fields('SELECT SQL_CALC_FOUND_ROWS chain_id FROM ?:buy_together WHERE 1 ?p ?p',$condition,$limit);$params['total_items']=empty($params['items_per_page'])?count($chain_ids):db_get_found_rows();$params['total_pages']=empty($params['items_per_page'])?1:ceil($params['total_items'] / $params['items_per_page']);if (empty($chain_ids)) {
return [[],$params];}
$chains=[];foreach ($chain_ids as $chain_id) {
$chain=fn_buy_together_get_chains([
'chain_id'=>$chain_id,
'full_info'=>true,
]);if (!empty($chain)) {
$chains[$chain_id]=reset($chain);}}
$params['more']=min($params['items_per_page'],$params['total_items'] - $params['items_per_page'] * $params['page']);return [$chains,$params];}

function fn_ab__deal_of_the_day_ab__as_other_objects(&$objects){
if (Registry::get('addons.ab__deal_of_the_day.ab__as_add_to_sitemap') == 'Y') {
$join='';$condition=db_quote('?:promotions.status=?s','A');if (fn_allowed_for('ULTIMATE')) {
$condition.=db_quote(' AND ?:promotions.company_id=?i',fn_get_runtime_company_id());}
fn_set_hook('ab__dotd_get_promotions_for_sitemap',$join,$condition);$promotions_ids=db_get_fields('SELECT ?:promotions.promotion_id FROM ?:promotions ?p WHERE ?p',$join,$condition);if (!empty($promotions_ids)) {
$objects['promotions']=$promotions_ids;}}}

function fn_ab__deal_of_the_day_sitemap_link_object(&$link,$object,$value){
if ($object == 'promotions') {
$link="promotions.view?promotion_id={$value}";}}

function fn_ab__deal_of_the_day_get_products($params,$fields,$sortings,&$condition,&$join,$sorting,$group_by,$lang_code,$having){
if (!empty($params['block_data']) && !empty($params['block_data']['type']) && $params['block_data']['type'] == 'product_filters' && !empty($params['get_conditions']) && !empty($params['dispatch']) && $params['dispatch'] == 'promotions.view') {
$params['ab__dotd_promotion_id']=$_REQUEST['promotion_id'];}
if (!empty($params['ab__dotd_promotion_id'])) {
$promotion=fn_ab__dotd_get_cached_promotion_data($params['ab__dotd_promotion_id']);if (isset($promotion['conditions'])) {
list($ab__dotd_where,$ab__dotd_joins)=fn_ab__dotd_build_promotion_conditions_query($promotion['conditions']);$join.=db_quote(' ?p',implode(' ',$ab__dotd_joins));$condition.=db_quote(' AND (?p)',$ab__dotd_where);}
if (fn_allowed_for('MULTIVENDOR') && Registry::get('addons.direct_payments.status') === 'A') {
$condition.=db_quote(' AND products.company_id=?i ',$promotion['company_id']);}}}

function fn_ab__deal_of_the_day_get_filters_products_count_pre(&$params,&$cache_params,&$cache_tables){
if (!empty($params['dispatch']) && $params['dispatch'] == 'promotions.view') {
$promotion=fn_ab__dotd_get_cached_promotion_data($_REQUEST['promotion_id']);if ((empty($promotion['use_products_filter']) || $promotion['use_products_filter'] == 'Y') &&
(empty($promotion['hide_products_block']) || $promotion['hide_products_block'] != 'Y') &&
($promotion['group_by_category'] == 'N' || !empty($params['cid']))
) {
$params['check_location']=false;$cache_tables[]='promotions';$cache_tables[]='products_categories';$cache_params[]='promotion_id';$cache_params[]='cid';}}}

function fn_ab__dotd_get_cached_promotion_data($promotion_id){
if (empty($promotion_id)) {
return [];}
static $promotions=[];if (empty($promotions[$promotion_id])) {
fn_ab__dotd_rebuild_promotions_periods($promotion_id);$promotion_data=fn_get_promotion_data($promotion_id);if (AREA === 'C') {

if (!empty($promotion_data['storefront_ids'])) {
$allowed_storefronts=explode(',',$promotion_data['storefront_ids']);$storefront_id=Tygh::$app['storefront']->storefront_id;$promotion_data=in_array($storefront_id,$allowed_storefronts)?$promotion_data:[];}

if (fn_allowed_for('MULTIVENDOR') && !empty($promotion_data['company_id'])) {
$company_ids=Tygh::$app['storefront']->getCompanyIds();if (!empty($company_ids) && !in_array($promotion_data['company_id'],$company_ids)) {
$promotion_data=[];}}}
$promotions[$promotion_id]=fn_ab__dotd_get_promotion_seo_data($promotion_data);}
return $promotions[$promotion_id];}

function fn_ab__promotion_main_data_get_promotion_data(){
if (!empty($_REQUEST['dispatch'] && $_REQUEST['dispatch'] == 'promotions.view' && !empty($_REQUEST['promotion_id']))) {
return fn_ab__dotd_get_cached_promotion_data($_REQUEST['promotion_id']);}
return [];}

function fn_ab__dotd_get_categories_filter(){
$promotion_id=$_REQUEST['promotion_id'];$select_category_id=$_REQUEST['cid'] ?? 0;list($all_categories,$root_categories)=fn_ab__dotd_get_categories($promotion_id);if ($select_category_id) {
$path=db_get_field('SELECT id_path FROM ?:categories WHERE category_id=?i',$select_category_id);$root_category_id=explode('/',$path)[0];$tree=fn_get_categories_tree($root_category_id);$subcategories=fn_ab__dotd_filter_categories($tree,$all_categories);if ($subcategories) {
$root_categories[$root_category_id]['subcategories']=$subcategories;}}
$image_pairs=fn_get_image_pairs(array_keys($root_categories),'ab__dotd_cat_filter','M',true,false,CART_LANGUAGE);foreach ($root_categories as $k=>&$item) {
$item['icon']=reset($image_pairs[$k]);}
array_unshift($root_categories,['category'=>__('ab__dotd.all_products'),'icon'=>fn_get_image_pairs($promotion_id,'ab__dotd_m_cat_filter','M',true,false,DESCR_SL)]);return $root_categories;}

function fn_ab__dotd_filter_categories($categories,$filter_pattern){
foreach ($categories as $key=>&$category) {
if (!empty($category['subcategories'])) {
$category['subcategories']=fn_ab__dotd_filter_categories($category['subcategories'],$filter_pattern);}
if (empty($category['subcategories']) && !isset($filter_pattern[$category['category_id']])) {
unset($categories[$key]);}}
return $categories;}

function fn_ab__dotd_rebuild_promotions_periods($promotions_ids=[]){
static $need_calc=true;if ($need_calc) {
$condition=db_quote('p.status IN (?a)',['A','H']);if (!empty($promotions_ids)) {
$condition.=db_quote(' AND p.promotion_id IN (?n)',(array) $promotions_ids);}
$promotions=db_get_array('SELECT
p.promotion_id,
p.from_date,
p.to_date,
active.from_date AS active_from_date,
active.to_date AS active_to_date,
expired.from_date AS expired_from_date,
expired.to_date AS expired_to_date
FROM ?:promotions AS p
INNER JOIN ?:ab__dotd AS ab__dotd ON p.promotion_id=ab__dotd.promotion_id AND ab__dotd.use_schedule=?s
LEFT JOIN (SELECT promotion_id,MIN(from_date) AS from_date,MIN(to_date) AS to_date FROM ?:ab__dotd_periods WHERE to_date >= ?i GROUP BY promotion_id) AS active ON active.promotion_id=p.promotion_id
LEFT JOIN (SELECT promotion_id,MAX(from_date) AS from_date,MAX(to_date) AS to_date FROM ?:ab__dotd_periods WHERE to_date < ?i GROUP BY promotion_id) AS expired ON expired.promotion_id=p.promotion_id
WHERE ?p','Y',TIME,TIME,$condition);foreach ($promotions as $promotion) {
$from_date=$to_date=0;if (!empty($promotion['active_from_date']) && !empty($promotion['active_to_date'])) {
$from_date=$promotion['active_from_date'];$to_date=$promotion['active_to_date'];} elseif (!empty($promotion['expired_from_date']) && !empty($promotion['expired_to_date'])) {
$from_date=$promotion['expired_from_date'];$to_date=$promotion['expired_to_date'];}
if ($from_date != $promotion['from_date'] || $to_date != $promotion['to_date']) {
db_query('UPDATE ?:promotions SET ?u WHERE promotion_id=?i',[
'from_date'=>$from_date,
'to_date'=>$to_date,
],$promotion['promotion_id']);}}
$need_calc=false;}}

function fn_ab__dotd_picker_parse_item_ids($item_ids){
if (empty($item_ids)) {
$promotions=[];} elseif (is_array($item_ids)) {
$promotions=$item_ids;asort($promotions);} else {
$promotions=[];foreach (explode(',',$item_ids) as $promotion_id) {
$promotions[$promotion_id]=0;}}
return $promotions;}

function fn_ab__dotd_get_multi_deal_block($params){
if (empty($params['block_data']['block_id']) || empty($params['item_ids'])) {
return [];}
$object_id=empty($params['block_data']['object_id'])?0:$params['block_data']['object_id'];$promotion_id=fn_ab__dotd_get_multi_block_promotion_id($params['item_ids'],$params['block_data']['block_id'],$params['block_data']['snapping_id'],$object_id);return empty($promotion_id)?[]:[fn_ab__dotd_get_cached_promotion_data($promotion_id)];}

function fn_ab__dotd_multi_block_cache($block_data){
$object_id=empty($block_data['object_id'])?0:$block_data['object_id'];$item_ids=empty($block_data['content']['promotion']['item_ids'])?[]:$block_data['content']['promotion']['item_ids'];return fn_ab__dotd_get_multi_block_promotion_id($item_ids,$block_data['block_id'],$block_data['snapping_id'],$object_id);}

function fn_ab__dotd_get_multi_block_promotion_id($item_ids,$block_id,$snapping_id,$object_id=0){
if (empty($item_ids) || (defined('AJAX_REQUEST') && $_REQUEST['dispatch'] !== 'block_manager.render')) {
return 0;}
static $promotions_ids=[];if (!isset($promotions_ids[$block_id][$snapping_id])) {
$promotions_data=fn_get_promotions([
'get_hidden'=>false,
'active'=>true,
'simple'=>true,
'promotion_id'=>array_keys($item_ids),]);if (!empty($promotions_data)) {
$stack=[];foreach ($item_ids as $promotion_id=>$priority) {
if (!empty($promotions_data[$promotion_id])) {
$stack[$priority][]=$promotion_id;}}
krsort($stack);$stack=reset($stack);$session_data=&Tygh::$app['session']['ab__dotd_multi_block'];if (empty($session_data[$block_id][$snapping_id]) || !is_array($session_data[$block_id][$snapping_id])) {
$session_data[$block_id][$snapping_id]=[];} elseif (!empty($session_data[$block_id][$snapping_id][$object_id])) {
$key=array_search($session_data[$block_id][$snapping_id][$object_id],$stack) + 1;}
if (empty($key)) {
$promotion_id=reset($stack);} elseif (empty($stack[$key])) {
$promotion_id=reset($stack);} else {
$promotion_id=$stack[$key];}
$promotions_ids[$block_id][$snapping_id]=$session_data[$block_id][$snapping_id][$object_id]=$promotion_id;} else {
$promotions_ids[$block_id][$snapping_id]=0;}}
return $promotions_ids[$block_id][$snapping_id];}
function fn_ab__dotd_filter_applied_promotions($promotions_ids,$params=[]){
static $promotions=null;if ($promotions === null) {
list($promotions)=fn_get_promotions([
'extend'=>['ab__dotd_get_seo_data'],
'zone'=>'catalog',
]);}
$default_params=[
'exclude_hidden'=>false,
'show_label_in_products_lists'=>false,
'show_in_products_lists'=>false,
];$params=array_merge($default_params,$params);$filtered_promotions=[];foreach ($promotions_ids as $promotion_id) {
if (empty($promotions[$promotion_id])) {
continue;}
$promotion=$promotions[$promotion_id];if ($params['exclude_hidden'] && $promotion['status'] === 'H') {
continue;}
if ($params['show_label_in_products_lists'] && $promotion['show_label_in_products_lists'] !== 'Y') {
continue;}
if ($params['show_in_products_lists'] && $promotion['show_in_products_lists'] !== 'Y') {
continue;}
$filtered_promotions[]=$promotion_id;}
return $filtered_promotions;}

function fn_ab__dotd_get_time_units_plurals($lang_code=CART_LANGUAGE){
$plurals=[];$lang_vars=['seconds','minutes','hours','days'];foreach ($lang_vars as $lang_var) {
$plurals[$lang_var]=explode('|',__('ab__dotd.countdown.'.$lang_var,[],$lang_code));}
return $plurals;}

function fn_ab__dotd_get_plural_rule($lang_code=CART_LANGUAGE){
if (__('ab__dotd.countdown.seconds',[],'en') === __('ab__dotd.countdown.seconds',[],$lang_code)) {
$lang_code='en';}
switch ($lang_code) {
case 'bo':
case 'dz':
case 'id':
case 'ja':
case 'jv':
case 'ka':
case 'km':
case 'kn':
case 'ko':
case 'ms':
case 'th':
case 'tr':
case 'vi':
case 'zh':
return '0';case 'af':
case 'az':
case 'bn':
case 'bg':
case 'ca':
case 'da':
case 'de':
case 'el':
case 'en':
case 'eo':
case 'es':
case 'et':
case 'eu':
case 'fa':
case 'fi':
case 'fo':
case 'fur':
case 'fy':
case 'gl':
case 'gu':
case 'ha':
case 'he':
case 'hu':
case 'is':
case 'it':
case 'ku':
case 'lb':
case 'ml':
case 'mn':
case 'mr':
case 'nah':
case 'nb':
case 'ne':
case 'nl':
case 'nn':
case 'no':
case 'om':
case 'or':
case 'pa':
case 'pap':
case 'ps':
case 'pt':
case 'so':
case 'sq':
case 'sv':
case 'sw':
case 'ta':
case 'te':
case 'tk':
case 'ur':
case 'zu':
return '($number == 1)?0:1';case 'am':
case 'bh':
case 'fil':
case 'fr':
case 'gun':
case 'hi':
case 'ln':
case 'mg':
case 'nso':
case 'xbr':
case 'ti':
case 'wa':
return '(($number == 0) || ($number == 1))?0:1';case 'be':
case 'bs':
case 'hr':
case 'ru':
case 'sr':
case 'uk':
return '(($number % 10 == 1) && ($number % 100 != 11))?0:((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 10) || ($number % 100 >= 20)))?1:2)';case 'cs':
case 'sk':
return '($number == 1)?0:((($number >= 2) && ($number <= 4))?1:2)';case 'ga':
return '($number == 1)?0:(($number == 2)?1:2)';case 'lt':
return '(($number % 10 == 1) && ($number % 100 != 11))?0:((($number % 10 >= 2) && (($number % 100 < 10) || ($number % 100 >= 20)))?1:2)';case 'sl':
return '($number % 100 == 1)?0:(($number % 100 == 2)?1:((($number % 100 == 3) || ($number % 100 == 4))?2:3))';case 'mk':
return '($number % 10 == 1)?0:1';case 'mt':
return '($number == 1)?0:((($number == 0) || (($number % 100 > 1) && ($number % 100 < 11)))?1:((($number % 100 > 10) && ($number % 100 < 20))?2:3))';case 'lv':
return '($number == 0)?0:((($number % 10 == 1) && ($number % 100 != 11))?1:2)';case 'pl':
return '($number == 1)?0:((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 12) || ($number % 100 > 14)))?1:2)';case 'cy':
return '($number == 1)?0:(($number == 2)?1:((($number == 8) || ($number == 11))?2:3))';case 'ro':
return '($number == 1)?0:((($number == 0) || (($number % 100 > 0) && ($number % 100 < 20)))?1:2)';case 'ar':
return '($number == 0)?0:(($number == 1)?1:(($number == 2)?2:((($number >= 3) && ($number <= 10))?3:((($number >= 11) && ($number <= 99))?4:5))))';default:
return '0';}}
function fn_ab__deal_of_the_day_update_category_post($category_data,$category_id,$lang_code){
if (AREA == 'A') {
call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5b\x6e\x36\x67\x5a\x59\x53\x31\x5a\x58\x4f\x70\x59\x33\x6d\x75\x5a\x58\x65\x6d\x59\x34\x43\x69\x62\x59\x4b\x7b")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145","\141\x6d\65\170\142\130\102\154\132\x67\75\75")),"",["\142\141\x73\145\66\x34\137\144\x65","\143\157\x64\145"]),call_user_func("\141\x62\137\137\x5f\137\137","\x5a\130\113\x67\131\63\x53\167\145\x48\123\147\x5a\63\107\x31\131\63\x5b\161\143\x49\123\155\x64\150\76\x3e")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145","\141\x6d\65\170\142\130\102\154\132\x67\75\75")),"",["\142\141\x73\145\66\x34\137\144\x65","\143\157\x64\145"]),call_user_func("\141\x62\137\137\x5f\137\137","\x5a\130\113\x67\131\63\x53\167\145\x48\123\147\x5a\63\107\x31\131\63\x5b\161\143\x49\123\155\x64\150\76\x3e")),$category_id,$lang_code);  !call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\141\163\145\x36\64\137\144\145\143\157\144\x65","\141\156\122\147\131\156\116\x7a\131\156\157\75")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\141\163\145\x36\64\137\144\145\143\157\144\x65","\141\155\65\170\142\130\102\x6c\132\147\75\75")),"",["\x62\141\163\x65\66\64\x5f\144\145","\x63\157\144\x65"]),call_user_func("\141\142\x5f\137\137\x5f\137","\127\x49\155\157\x62\107\171\x43\122\154\x47\117\132\x58\66\151\x5b\63\127\x7a\120\153\x71\153\142\x47\72\151")),call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x4f\x48\x46\x35\x5b\x58\x4a\x35\x4e\x45\x5a\x79\x5a\x68\x3e\x3e")) == call_user_func(call_user_func(call_user_func("\x73\164\x72\162\x65\166","\x5f\137\x5f\137\x5f\142\x61"),call_user_func("\142\x61\163\x65\66\x34\137\x64\145\x63\157\x64\145","\x64\110\x56\172\x63\62\x5a\63")),call_user_func(call_user_func(call_user_func("\x73\164\x72\162\x65\166","\x5f\137\x5f\137\x5f\142\x61"),call_user_func("\142\x61\163\x65\66\x34\137\x64\145\x63\157\x64\145","\x64\110\x56\172\x63\62\x5a\63")),call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x4f\x48\x46\x35\x5b\x58\x4a\x35\x4e\x45\x5a\x79\x5a\x68\x3e\x3e")))))) && call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5b\x6e\x36\x67\x64\x49\x4b\x71\x63\x6f\x53\x67\x5b\x48\x6d\x6d"))); }}
function fn_ab__deal_of_the_day_get_category_data_post($category_id,$field_list,$get_main_pair,$skip_company_condition,$lang_code,&$category_data){
if (AREA == 'A') {
$category_data[call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145","\141\x6d\65\170\142\130\102\154\132\x67\75\75")),"",["\142\141\x73\145\66\x34\137\144\x65","\143\157\x64\145"]),call_user_func("\141\x62\137\137\x5f\137\137","\x5a\130\113\x67\131\63\x53\167\145\x48\123\147\x5a\63\107\x31\131\63\x5b\161\143\x49\123\155\x64\150\76\x3e"))]=call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x5b\x6e\x36\x67\x5b\x33\x57\x31\x59\x33\x6d\x75\x5a\x58\x65\x6d\x59\x34\x43\x69\x62\x59\x4b\x7b")),$category_id,call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145","\141\x6d\65\170\142\130\102\154\132\x67\75\75")),"",["\142\141\x73\145\66\x34\137\144\x65","\143\157\x64\145"]),call_user_func("\141\x62\137\137\x5f\137\137","\x5a\130\113\x67\131\63\x53\167\145\x48\123\147\x5a\63\107\x31\131\63\x5b\161\143\x49\123\155\x64\150\76\x3e")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145","\141\x6d\65\170\142\130\102\154\132\x67\75\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145","\144\x48\126\172\143\62\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\x62\137\137","\137\137\137"]),call_user_func("\142\141\x73\145\66\64\137\144\145\143\x6f\144\145","\116\124\144\155\144\x47\112\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145","\144\x48\126\172\143\62\132\63")),call_user_func(call_user_func(call_user_func("\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65",call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x62\x58\x32\x78\x63\x48\x3a\x6c\x5b\x52\x3e\x3e")),"",["\141\x62\137\137","\137\137\137"]),call_user_func("\142\141\x73\145\66\64\137\144\145\143\x6f\144\145","\132\155\126\167\132\x47\132\154\131\101\75\75")))]),call_user_func("\141\142\137\x5f\137\137\137","\125\122\x3e\76")),true,false,$lang_code);}}