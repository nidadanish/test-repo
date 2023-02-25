<?php

use Tygh\Enum\ProductTracking;
use Tygh\Registry;
use Tygh\Storage;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

Tygh::$app['session']['wishlist'] = isset(Tygh::$app['session']['wishlist']) ? Tygh::$app['session']['wishlist'] : array();
$wishlist = & Tygh::$app['session']['wishlist'];
Tygh::$app['session']['continue_url'] = isset(Tygh::$app['session']['continue_url']) ? Tygh::$app['session']['continue_url'] : '';
$auth = & Tygh::$app['session']['auth'];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Add product to the wishlist
	if ($mode == 'add')
	{
		$product_id_param = Registry::get('addons.rf_pro_marketing.gtag_product_id');
		$products = array ();
		if (!empty($_REQUEST['product_data']) && is_array($_REQUEST['product_data']))
		{
			foreach ($_REQUEST['product_data'] as $product_id => $_product)
			{
				$product_data = db_get_row("SELECT * FROM ?:products WHERE product_id = ?i", $product_id);
				$products[] = array ('id' => $product_data[$product_id_param], 'price' => intval(fn_get_product_price($product_id, 1, Tygh::$app['session']['auth'])));
			}
		}

		if (defined('AJAX_REQUEST'))
		{
			Tygh::$app['ajax']->assign('rf_pro_marketing', array('wishlist_added' => $products, 'event_AddToWishlist' => fn_rf_pro_marketing_get_event_id("AddToWishlist")));
		}
		else
		{
			Tygh::$app['session']['rf_pro_marketing'] = array('wishlist_added' => $products);
		}
	}
}
