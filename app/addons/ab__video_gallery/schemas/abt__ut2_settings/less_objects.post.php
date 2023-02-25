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
use Tygh\Enum\YesNo;
$schema['addons']['items']['ab__video_gallery'] = [
'is_group' => YesNo::YES,
'position' => 10,
'items' => [
'block_bg' => [
'is_for_all_devices' => YesNo::YES,
'type' => 'colorpicker',
'position' => 100,
'value' => '',
'value_styles' => [
'Black.less' => '#333333',
'Blue.less' => '#cceaf6',
'Brick.less' => '#dc4d15',
'Cobalt.less' => '#0563d0',
'Dark_Blue.less' => '#f3f4f7',
'Dark_Navy.less' => '#f3f4f7',
'Default.less' => '#ffef9a',
'Fiolent.less' => '#3e4895',
'Flame.less' => '#a50315',
'Gray.less' => '#e3e3e3',
'Green.less' => '#379424',
'Indigo.less' => '#17a285',
'Ink.less' => '#182b4a',
'Mint.less' => '#88d2d3',
'Original.less' => '#2b2b2b',
'Powder.less' => '#e5684e',
'Purple.less' => '#6200ee',
'Skyfall.less' => '#eeeeee',
'Velvet.less' => '#595959',
'White.less' => '#eeeeee',
],
],
],
];
return $schema;
