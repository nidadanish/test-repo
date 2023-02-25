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
namespace Tygh\Addons\Abt_unitheme2;
use Tygh\Database\Connection;
use Tygh\Storefront\Storefront;
use Tygh\Exceptions\DatabaseException;

class LMRepository
{

protected $db;

private $table = 'abt__ut2_light_menu_content';

const ITEM_TYPE_MENU = 'menu';

const ITEM_TYPE_BLOCK = 'block';

const ITEM_TYPE_DELIMITER = 'delimiter';

public function __construct(Connection $db)
{
$this->db = $db;
}

public function updateLightMenu(array $light_menu_data)
{
foreach ($light_menu_data as $key => &$lm_data) {
if ($lm_data['type'] == static::ITEM_TYPE_MENU && empty($lm_data['menu'])) {
unset($light_menu_data[$key]);
}
if ($lm_data['type'] == static::ITEM_TYPE_BLOCK && empty($lm_data['block_id'])) {
unset($light_menu_data[$key]);
}
$lm_data['content'] = [
'user_class' => $lm_data['user_class'],
];
if (!empty($lm_data['menu'])) {
$lm_data['content']['menu'] = $lm_data['menu'];
}
if (!empty($lm_data['block_id'])) {
$lm_data['content']['block_id'] = $lm_data['block_id'];
}
if (!empty($lm_data['state'])) {
$lm_data['content']['state'] = $lm_data['state'];
}
$lm_data['content'] = serialize($lm_data['content']);
unset($lm_data['user_class']);
unset($lm_data['block_id']);
unset($lm_data['state']);
unset($lm_data['menu']);
}
try {
if (empty($light_menu_data)) {
$this->db->query("DELETE FROM ?:{$this->table}");
} else {
$this->db->replaceInto($this->table, $light_menu_data, true);
}
} catch (DatabaseException $e) {
fn_print_die($e->getMessage());
}
}

public function find(array $params = [])
{
$params = array_merge([
'storefront_id' => \Tygh::$app['storefront']->storefront_id,
'sort_by' => 'position',
], $params);
try {
$cond = $this->db->quote('storefront_id = ?i', $params['storefront_id']);
$sortings = [
'position' => 'position',
];
$sorting = db_sort($params, $sortings, 'position', 'asc');
$items = $this->db->getArray("SELECT * FROM ?:{$this->table} WHERE ?p ?p", $cond, $sorting);
} catch (DatabaseException $e) {
fn_print_die($e->getMessage());
}
foreach ($items as &$item) {
$item['content'] = unserialize($item['content']);
$item = fn_array_merge($item, $item['content'], true);
}
return [$items, $params];
}
}