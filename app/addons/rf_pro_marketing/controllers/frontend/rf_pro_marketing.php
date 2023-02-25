<?php
use Tygh\Registry;
if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == "fb" && defined('AJAX_REQUEST'))
{
	$event = (!empty($_REQUEST['event'])) ? $_REQUEST['event'] : false;
	if ($event)
	{
		switch ($event)
		{
			case "ViewContent_P":
				$product_id = (!empty($_REQUEST['product_id'])) ? $_REQUEST['product_id'] : 0;
				if (!empty($product_id) && Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_viewcontent') == "Y")
				{
					$product = fn_get_product_data($product_id, Tygh::$app['session']['auth']);
					$product_id_param = Registry::ifGet('addons.rf_pro_marketing.fbc_product_id', 'product_id');
					$data = [
						'event_name' => 'ViewContent',
						'content_ids' => [($product_id_param == "product_id") ? intval($product[$product_id_param]) : strval($product[$product_id_param])],
						'content_type' => 'product',
						'content_name' => $product['product'],
						'content_category' => fn_get_category_name($product['main_category']),
						'value' => fn_format_price($product['price']),
						'currency' => CART_SECONDARY_CURRENCY,
						'event_id' => 'product_id.' . $product_id,
						'event_source_url' => fn_url("products.view?product_id=" . $product_id),
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;

			case "ViewContent_C":
				$category_id = (!empty($_REQUEST['category_id'])) ? $_REQUEST['category_id'] : 0;
				if (!empty($category_id) && Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_viewcontent') == "Y")
				{
					$category = fn_get_category_data($category_id);
					$data = [
						'event_name' => 'ViewContent',
						'content_ids' => [intval($category_id)],
						'content_type' => 'product',
						'content_name' => $category['category'],
						'event_id' => 'category_id.' . $category_id,
						'event_source_url' => fn_url("categories.view?category_id=" . $category_id),
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;

			case "Search":
				$q = (!empty($_REQUEST['q'])) ? $_REQUEST['q'] : "";
				if (!empty($q) && Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_search') == "Y")
				{
					$data = [
						'event_name' => 'Search',
						'event_id' => 'search_result',
						'search_string' => $q,
						'event_source_url' => fn_url("products.search?q=" . $q . "&match=all&subcats=Y&pcode_from_q=Y&pshort=Y&pfull=Y&pname=Y&pkeywords=Y&search_performed=Y"),
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;

			case "InitiateCheckout":
				if (Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_checkout') == "Y")
				{
					$data = [
						'event_name' => 'InitiateCheckout',
						'event_id' => 'checkout',
						'event_source_url' => fn_url("checkout.checkout"),
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;

			case "PageView_P":
				$page_id = (!empty($_REQUEST['page_id'])) ? $_REQUEST['page_id'] : 0;
				if (!empty($page_id) && Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_pageview') == "Y")
				{
					$data = [
						'event_name' => 'PageView',
						'event_id' => 'page_id.' . $page_id,
						'event_source_url' => fn_url("pages.view?page_id=" . $page_id),
						'content_name' => fn_get_page_name($page_id),
						'content_ids' => [intval($page_id)],
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;

			case "PageView_F":
				$filter_id = (!empty($_REQUEST['filter_id'])) ? $_REQUEST['filter_id'] : 0;
				if (!empty($filter_id) && Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_pageview') == "Y")
				{
					$data = [
						'event_name' => 'PageView',
						'event_id' => 'product_features.' . $filter_id,
						'event_source_url' => fn_url("product_features.view_all?filter_id=" . $filter_id),
						'content_ids' => [intval($filter_id)],
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;
				
			case "PageView_I":
				if (Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_pageview') == "Y")
				{
					$data = [
						'event_name' => 'PageView',
						'event_id' => 'index_page',
						'event_source_url' => fn_url("index.index"),
						'content_ids' => ['index'],
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;

			case "Purchase":
				$order_id = (!empty($_REQUEST['order_id'])) ? $_REQUEST['order_id'] : 0;
				if (!empty($order_id) && Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_purchase') == "Y")
				{
					$products = [];
					$order_info = fn_get_order_info($order_id);
					$product_id_param = Registry::ifGet('addons.rf_pro_marketing.fbc_product_id', 'product_id');
					foreach ($order_info['products'] as $product)
					{
						$products[] = [
							'id' => ($product_id_param == "product_id") ? intval($product[$product_id_param]) : strval($product[$product_id_param]),
							'price' => fn_format_price($product['price']),
							'quantity' => $product['amount'],
						];
					}
					$data = [
						'event_name' => 'Purchase',
						'event_id' => 'order_id.' . $order_id,
						'content_type' => 'product',
						'contents' => $products,
						'value' => fn_format_price($order_info['total']),
						'currency' => CART_SECONDARY_CURRENCY,
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
						$_SESSION['order_id_' . $order_id] = true;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;

			case "AddToWishlist":
				$request = (!empty($_REQUEST['data']['ids'])) ? $_REQUEST['data']['ids'] : [];
				if (!empty($request) && Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_addtowishlist') == "Y")
				{
					$products = $products_ids = [];
					$value = 0;
					$product_id_param = Registry::ifGet('addons.rf_pro_marketing.fbc_product_id', 'product_id');
					foreach ($request as $product_id)
					{
						$product_data = fn_get_product_data($product_id, Tygh::$app['session']['auth']);
						$pid = ($product_id_param == "product_id") ? intval($product_data[$product_id_param]) : strval($product_data[$product_id_param]);
						$products[] = [
							'id' => $pid,
							'price' => fn_format_price($product_data['price']),
							'quantity' => 1,
						];
						$products_ids[] = $pid;
						$value += $product_data['price'];
					}
					$data = [
						'event_name' => 'AddToWishlist',
						'event_id' => 'wishlist',
						'content_type' => 'product',
						'contents' => $products,
						'content_ids' => $products_ids,
						'value' => fn_format_price($value),
						'currency' => CART_SECONDARY_CURRENCY,
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;

			case "AddToCart":
				$request = (!empty($_REQUEST['data']['ids'])) ? $_REQUEST['data']['ids'] : [];
				if (!empty($request) && Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_addtocart') == "Y")
				{
					$products = $products_ids = [];
					$value = 0;
					$product_id_param = Registry::ifGet('addons.rf_pro_marketing.fbc_product_id', 'product_id');
					foreach ($request as $product_id)
					{
						$product_data = fn_get_product_data($product_id, Tygh::$app['session']['auth']);
						$pid = ($product_id_param == "product_id") ? intval($product_data[$product_id_param]) : strval($product_data[$product_id_param]);
						$products[] = [
							'id' => $pid,
							'price' => fn_format_price($product_data['price']),
							'quantity' => 1,
						];
						$products_ids[] = $pid;
						$value += $product_data['price'];
					}
					$data = [
						'event_name' => 'AddToCart',
						'event_id' => 'addtocart',
						'content_type' => 'product',
						'contents' => $products,
						'content_ids' => $products_ids,
						'value' => fn_format_price($value),
						'currency' => CART_SECONDARY_CURRENCY,
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;

			case "CompleteRegistration":
				$user_id = (!empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : 0;
				if (!empty($user_id) && Registry::get('addons.rf_pro_marketing.fbc_events.fbc_events_registration') == "Y")
				{
					$data = [
						'event_name' => 'CompleteRegistration',
						'event_id' => 'profile.' . $user_id,
						'content_ids' => [intval($user_id)],
					];
					$event_id = fn_rf_pro_marketing_make_request($data);
					if (!empty($event_id))
					{
						$data['status'] = "success";
						$data['event_id'] = $event_id;
						$_SESSION['user_id_' . $user_id] = true;
					}
					else
					{
						$data['status'] = "fail";
					}
				}
				else
				{
					$data['status'] = "fail";
				}
				break;
		}
	}
	Tygh::$app['ajax']->assign('data', $data);
	exit;
}
