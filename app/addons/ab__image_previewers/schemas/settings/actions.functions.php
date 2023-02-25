<?php
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
use Tygh\Enum\ObjectStatuses;use Tygh\Registry;use Tygh\Settings;if (!class_exists('ABXmlScheme')) {
class ABXmlScheme{
private $addon='';private $xml;public function __construct($addon){
$this->addon=$addon;$this->xml=$this->readXml();return $this;}
private function readXml(){
$filename=Registry::get('config.dir.addons').$this->addon.'/addon.xml';if (file_exists($filename)) {
return simplexml_load_file($filename);}
return false;}
private function getAddonName($addon=''){
$name='';if (!empty($addon)) {
$name=db_get_field('SELECT name FROM ?:addon_descriptions WHERE addon=?s AND lang_code=?s',$addon,CART_LANGUAGE);}
return $name;}
public function checkDependencies(){
$result=true;if (!empty($this->xml) && isset($this->xml->ab->compatibility->dependencies)) {
foreach ((array) $this->xml->ab->compatibility->dependencies as $addon=>$conditions) {
$conditions=(array) $conditions;$status=Registry::get("addons.{$addon}.status");$version=fn_get_addon_version($addon);if (!empty($conditions) && $status == 'A' && !$this->checkVersion($version,$conditions)) {
$result=false;$min=$max='';if (!empty($conditions['min']) && empty($conditions['max'])) {
$min=' v'.$conditions['min'];$max=' and higher';}
if (!empty($conditions['min']) && !empty($conditions['max'])) {
$min=' from v'.$conditions['min'];$max=' to v'.$conditions['max'];}
if (empty($conditions['min']) && !empty($conditions['max'])) {
$max=' up to v'.$conditions['max'];}
$replaces=[
'[main_addon]'=>$this->getAddonName($this->addon),'[addon]'=>$this->getAddonName($addon),'[min]'=>$min,
'[max]'=>$max,
];$msg=str_replace(array_keys($replaces),$replaces,'To activate \'[main_addon]\' add-on requires \'[addon]\' add-on version[min][max]');fn_set_notification('E',__('error'),$msg);}}}
return $result;}
private function checkVersion($version,$conditions){
$result=true;if ($result && !empty($conditions['min']) && !$this->compareVersion($version,$conditions['min'],'>=')) {
$result=false;}
if ($result && !empty($conditions['max']) && !$this->compareVersion($version,$conditions['max'],'<=')) {
$result=false;}
return $result;}
private static function compareVersion($a,$b,$operator=null){
$format_versions=function ($a,$b) {
$replaces=['43'=>'4.3','44'=>'4.4','45'=>'4.5','46'=>'4.6','47'=>'4.7','48'=>'4.8','49'=>'4.9'];$a=str_replace(array_keys($replaces),$replaces,$a);$b=str_replace(array_keys($replaces),$replaces,$b);return [$a,$b];};list($a,$b)=$format_versions($a,$b);$replace_chars=function ($m){return ord(strtolower($m[1])); };$a=preg_replace('#([0-9]+)([a-z]+)#i','$1.$2',$a);$b=preg_replace('#([0-9]+)([a-z]+)#i','$1.$2',$b);$a=preg_replace_callback('#\b([a-z]{1})\b#i',$replace_chars,$a);$b=preg_replace_callback('#\b([a-z]{1})\b#i',$replace_chars,$b);return \version_compare($a,$b,$operator);}}}
function fn_settings_actions_addons_ab__image_previewers(&$a,$b){
$a == call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\142\141\x73\145\66\x34\137\144\x65\143\157\x64\145",call_user_func("\x61\142\137\x5f\137\137\x5f","\142\x58\62\170\x63\110\72\x6c\133\122\x3e\76")),"",["\141\142\137\x5f","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\x5f\144\145\143\157\x64\145","\141\155\65\x78\142\130\102\154\x5a\147\75\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\142\x61\163\145\x36\64\137\x64\145\143\x6f\144\145",call_user_func("\141\142\x5f\137\137\x5f\137","\x62\130\62\x78\143\110\x3a\154\133\x52\76\76")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\144\110\126\172\x63\62\132\63")),call_user_func(call_user_func(call_user_func("\142\x61\163\145\x36\64\137\x64\145\143\x6f\144\145",call_user_func("\141\142\x5f\137\137\x5f\137","\x62\130\62\x78\143\110\x3a\154\133\x52\76\76")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\116\124\144\155\x64\107\112\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\142\x61\163\145\x36\64\137\x64\145\143\x6f\144\145",call_user_func("\141\142\x5f\137\137\x5f\137","\x62\130\62\x78\143\110\x3a\154\133\x52\76\76")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\144\110\126\172\x63\62\132\63")),call_user_func(call_user_func(call_user_func("\142\x61\163\145\x36\64\137\x64\145\143\x6f\144\145",call_user_func("\141\142\x5f\137\137\x5f\137","\x62\130\62\x78\143\110\x3a\154\133\x52\76\76")),"",["\141\142\137\137","\x5f\137\137"]),call_user_func("\142\141\x73\145\66\64\137\x64\145\143\157\144\x65","\132\155\126\167\x5a\107\132\154\131\x41\75\75")))]),call_user_func("\141\142\137\x5f\137\137\137","\x52\122\76\76")) && !(new ABXmlScheme(substr(__FUNCTION__,27)))->checkDependencies() && $a=call_user_func(call_user_func("\163\164\162\162\145\166","\137\137\x5f\137\137\142\141"),call_user_func("\142\141\163\145\x36\64\137\144\145\143\157\144\145","\x52\121\75\75"));if ($a === ObjectStatuses::DISABLED && fn_ab__ip_is_ab_previewer()) {
$previewers_path=Registry::get('config.dir.root').'/js/tygh/previewers';$default_previewers_list=fn_get_dir_contents($previewers_path,false,true,'js');$default_previewer=reset($default_previewers_list);$default_previewer_name=fn_basename($default_previewer,'.previewer.js');$previewer_description=fn_get_file_description($previewers_path.'/'.$default_previewer,'previewer-description');Settings::instance()->updateValue('default_image_previewer',$default_previewer_name,'Appearance');fn_set_notification('W',__('information'),__('ab__image_previewers.default_previewer_changed',['[previewer]'=>$previewer_description]));}}
