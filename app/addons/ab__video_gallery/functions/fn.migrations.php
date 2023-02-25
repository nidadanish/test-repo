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
die('Access denied');
}
function fn_ab__vg_migrate_v300_v250()
{
$table = '?:ab__video_gallery_descriptions';
$exists = db_get_field('SHOW COLUMNS FROM ?p WHERE Field = ?s', $table, 'video_path');
if (empty($exists)) {
db_query('ALTER TABLE ?p CHANGE youtube_id video_path VARCHAR(255) NOT NULL DEFAULT ""', $table);
db_query('ALTER TABLE ?p MODIFY video_path VARCHAR(255) NOT NULL DEFAULT ""', $table);
$table = '?:ab__video_gallery';
$column = 'type';
$column_data = 'CHAR(1) NOT NULL DEFAULT "Y"';
db_query('ALTER TABLE ?p ADD COLUMN ?p AFTER video_id', $table, $column . ' ' . $column_data);
$column = 'settings';
$column_data = 'TEXT NOT NULL';
db_query('ALTER TABLE ?p ADD COLUMN ?p AFTER icon_type', $table, $column . ' ' . $column_data);
}
}
