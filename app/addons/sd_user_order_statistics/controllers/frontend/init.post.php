<?php
 use Tygh\Registry; if (!defined('BOOTSTRAP')) { die('Access denied'); } if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['HTTP_REFERER'])) { $refer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST); if ($refer_host != $_SERVER['HTTP_HOST']) { if (empty(Tygh::$app['session']['cart']['order_statistics']['refer_url'])) { Tygh::$app['session']['cart']['order_statistics']['refer_url'] = $_SERVER['HTTP_REFERER']; Tygh::$app['session']['cart']['order_statistics']['direct_link'] = false; } } } 