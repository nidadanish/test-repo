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
use Tygh\Registry;if (!class_exists('ABXmlScheme')) {
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
function fn_settings_actions_addons_ab__hide_product_description(&$a,$b){
$a == call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\x65\66\64\137\144\145\143\x6f\144\145",call_user_func("\141\142\137\x5f\137\137\137","\142\130\62\170\x63\110\72\154\133\122\76\x3e")),"",["\x61\142\x5f\137","\x5f\137\x5f"]),call_user_func("\142\x61\163\x65\66\x34\137\x64\145\x63\157\x64\145","\x61\155\x35\170\x62\130\x42\154\x5a\147\x3d\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\142\141\x73\145\66\64\137\144\145\x63\157\144\145",call_user_func("\141\142\x5f\137\137\137\137","\142\130\62\x78\143\110\72\154\133\122\x3e\76")),"",["\x61\142\x5f\137","\x5f\137\x5f"]),call_user_func("\142\x61\163\x65\66\x34\137\x64\145\x63\157\x64\145","\x64\110\x56\172\x63\62\x5a\63")),call_user_func(call_user_func(call_user_func("\142\141\163\145\66\x34\137\144\145\143\157\144\x65",call_user_func("\141\142\137\137\137\x5f\137","\142\130\62\170\143\110\x3a\154\133\122\76\76")),"",["\x61\142\x5f\137","\x5f\137\x5f"]),call_user_func("\142\x61\163\x65\66\x34\137\x64\145\x63\157\x64\145","\x4e\124\x64\155\x64\107\x4a\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\142\x61\163\145\66\64\137\144\x65\143\157\144\145",call_user_func("\141\x62\137\137\137\137\137","\142\130\x32\170\143\110\72\154\133\x52\76\76")),"",["\x61\142\x5f\137","\x5f\137\x5f"]),call_user_func("\142\x61\163\x65\66\x34\137\x64\145\x63\157\x64\145","\x64\110\x56\172\x63\62\x5a\63")),call_user_func(call_user_func(call_user_func("\142\141\163\145\x36\64\137\144\145\143\157\x64\145",call_user_func("\141\142\137\137\x5f\137\137","\142\130\62\170\143\x48\72\154\133\122\76\76")),"",["\x61\142\x5f\137","\x5f\137\x5f"]),call_user_func("\142\x61\163\x65\66\x34\137\x64\145\x63\157\x64\145","\x5a\155\x56\167\x5a\107\x5a\154\x59\101\x3d\75")))]),call_user_func("\141\142\137\x5f\137\137\137","\122\x52\76\76")) && !(new ABXmlScheme(substr(__FUNCTION__,27)))->checkDependencies() && $a=call_user_func(call_user_func("\163\x74\162\162\145\x76","\137\137\137\x5f\137\142\141"),call_user_func("\x62\141\163\145\x36\64\137\144\x65\143\157\144\x65","\122\121\75\x3d"));}

function fn_settings_variants_addons_ab__hide_product_description_transition(){
$transition=[
10=>__('ab__smc.settings.transition.10'),];for ($i=100; $i <= 1500; $i += 100) {
$transition[$i]=__('ab__smc.settings.transition.'.$i);}
fn_set_hook('ab__hide_product_description_transition_post',$transition);return $transition;}

function fn_settings_variants_addons_ab__hide_product_description_align(){
$aligns=[
'left'=>__('ab__smc.settings.align.left'),'center'=>__('ab__smc.settings.align.center'),'right'=>__('ab__smc.settings.align.right'),];fn_set_hook('ab__hide_product_description_align_post',$aligns);return $aligns;}

function fn_settings_variants_addons_ab__hide_product_description_appearance(){
$appearances=[
'text'=>__('ab__smc.settings.appearance.text'),'text2'=>__('ab__smc.settings.appearance.text2'),'button'=>__('ab__smc.settings.appearance.button'),];fn_set_hook('ab__hide_product_description_button_post',$appearances);return $appearances;}
