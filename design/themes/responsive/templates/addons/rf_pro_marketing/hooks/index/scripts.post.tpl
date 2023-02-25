{assign var="vk_pixel_id" value=$addons.rf_pro_marketing.vk_pixel_id}
{assign var="vk_price_list_id" value=$addons.rf_pro_marketing.vk_price_list_id}

{assign var="google_conversion_id" value=$addons.rf_pro_marketing.conversion_id}
{assign var="google_product_id_param" value=$addons.rf_pro_marketing.gtag_product_id}
{assign var="facebook_pixel_id" value=$addons.rf_pro_marketing.facebook_pixel_id}
{assign var="facebook_product_id_param" value=$addons.rf_pro_marketing.fbc_product_id}
{assign var="criteo_account_id" value=$addons.rf_pro_marketing.criteo_id}

<script type="text/javascript">
	_RF_MARKETING_CURRENCY = '{$smarty.const.CART_PRIMARY_CURRENCY}';
</script>

{if $vk_pixel_id && $vk_price_list_id}

<script type="text/javascript">
	var _RF_VK_PRICELIST_ID = '{$vk_price_list_id}';
	{literal}
	window.vkAsyncInit = function() {
	{/literal}

		{* enable retargeting *}
		_RF_VK_PIXEL = VK.Retargeting.Init('{$vk_pixel_id}');

		var products = [];
		{if $runtime.controller == "index" && $runtime.mode == "index"}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "view_home", {ldelim}{rdelim});
		{elseif $runtime.controller == "categories"}
			{foreach from=$products item="item"}
				{if $item.product_id && $item.price_min}
				products.push({ldelim}id: {$item.product_id}, price: {$item.price|intval}{rdelim});
				{/if}
			{/foreach}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "view_category", {ldelim}
				products: products,
				category_ids: {$category_data.category_id},
				currency_code: _RF_MARKETING_CURRENCY
			{rdelim});
		{elseif ($runtime.controller == 'product_features' && $runtime.mode == 'view') || ($runtime.controller == "products" && $runtime.mode == "search")}
			{foreach from=$products item="item"}
				{if $item.product_id}
					products.push({ldelim}id: {$item.product_id}, price: {$item.price|intval}{rdelim});
				{/if}
			{/foreach}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, {if $runtime.controller == "products"}"view_search"{else}"view_other"{/if}, {ldelim}
				products: products,
				currency_code: _RF_MARKETING_CURRENCY
			{rdelim});
		{elseif $runtime.controller == "products" && $runtime.mode == "view"}
			products.push({ldelim}id: {$product.product_id}, price: {$product.price|intval}{rdelim});
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "view_product", {ldelim}
				products: products,
				currency_code: _RF_MARKETING_CURRENCY
			{rdelim});
		{elseif ($runtime.controller == "orders" && $runtime.mode == "processing") || ($runtime.controller == "checkout" && $runtime.mode == "complete")}
			{foreach from=$order_info.products item="item"}
				products.push({ldelim}id: {$item.product_id}, price: {$item.price|intval}{rdelim});
			{/foreach}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "purchase", {ldelim}
				products: products,
				currency_code: _RF_MARKETING_CURRENCY,
				total_price: {$order_info.total|intval}
			{rdelim});
		{elseif $runtime.controller == "checkout"}
			{foreach from=$smarty.session.cart.products item="item"}
				products.push({ldelim}id: {$item.product_id}, price: {$item.price|intval}{rdelim});
			{/foreach}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "init_checkout", {ldelim}
				products: products,
				currency_code: _RF_MARKETING_CURRENCY
			{rdelim});
		{else}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "view_other", {ldelim}{rdelim});
		{/if}

		{if $rf_pro_marketing.added}
			{foreach from=$rf_pro_marketing.added item="item"}
				products.push({ldelim}id: {$item.id}, price: {$item.price|intval}{rdelim});
			{/foreach}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "add_to_cart", {ldelim}
				products: products,
				currency_code: _RF_MARKETING_CURRENCY
			{rdelim});
		{elseif $rf_pro_marketing.deleted}
			{foreach from=$rf_pro_marketing.deleted item="item"}
				products.push({ldelim}id: {$item.id}, price: {$item.price|intval}{rdelim});
			{/foreach}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "remove_from_cart", {ldelim}
				products: products,
				currency_code: _RF_MARKETING_CURRENCY
			{rdelim});
		{elseif $rf_pro_marketing.wishlist_added}
			{foreach from=$rf_pro_marketing.wishlist_added item="item"}
				products.push({ldelim}id: {$item.id}, price: {$item.price|intval}{rdelim});
			{/foreach}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "add_to_wishlist", {ldelim}
				products: products,
				currency_code: _RF_MARKETING_CURRENCY
			{rdelim});
		{elseif $rf_pro_marketing.wishlist_deleted}
			{foreach from=$rf_pro_marketing.wishlist_deleted item="item"}
				products.push({ldelim}id: {$item.id}, price: {$item.price|intval}{rdelim});
			{/foreach}
			VK.Retargeting.ProductEvent({$vk_price_list_id}, "remove_from_wishlist", {ldelim}
				products: products,
				currency_code: _RF_MARKETING_CURRENCY
			{rdelim});
		{/if}
	{literal}
	};
	{/literal}
</script>
{literal}
<script>
	setTimeout(function() {
		var el = document.createElement("script");
		el.type = "text/javascript";
		el.src = "https://vk.com/js/api/openapi.js?150";
		el.async = true;
		document.getElementById("vk_api_transport").appendChild(el);
	}, 0);
</script>
{/literal}

{/if}

{if $facebook_pixel_id}

{literal}
<!-- Facebook Pixel Code -->
<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '{$facebook_pixel_id}');
</script>
<!-- End Facebook Pixel Code -->
{/literal}

<script type="text/javascript">
	var _RF_FACEBOOK_PRICELIST_ID = '{$facebook_pixel_id}';

	{if $runtime.controller == "products" && $runtime.mode == "view"}

	$.ceAjax('request', fn_url("rf_pro_marketing.fb"), {ldelim}
		method: 'POST',
		caching: false,
		hidden: true,
		data: {ldelim}
			'event': 'ViewContent_P',
			'product_id': '{$product.product_id|default:0|intval}',
		{rdelim},
		callback: function (data) {ldelim}
			data = data.data;
			if (data.status == "success") {ldelim}
				fbq('track', 'ViewContent', {ldelim}
					content_name: data.content_name,
					content_category: data.content_category,
					content_ids: data.content_ids,
					content_type: data.content_type,
					value: data.value,
					currency: data.currency
				{rdelim}, {ldelim}eventID: data.event_id{rdelim});
			{rdelim}
		{rdelim}
	{rdelim});
		
	{elseif $runtime.controller == "categories" && $runtime.mode == "view"}

	$.ceAjax('request', fn_url("rf_pro_marketing.fb"), {ldelim}
		method: 'POST',
		caching: false,
		hidden: true,
		data: {ldelim}
			'event': 'ViewContent_C',
			'category_id': '{$category_data.category_id|default:0|intval}',
		{rdelim},
		callback: function (data) {ldelim}
			data = data.data;
			if (data.status == "success") {ldelim}
				fbq('track', 'ViewContent', {ldelim}
					content_name: data.content_name,
					content_ids: data.content_ids,
					content_type: data.content_type,
				{rdelim}, {ldelim}eventID: data.event_id{rdelim});
			{rdelim}
		{rdelim}
	{rdelim});

	{elseif $runtime.controller == "pages" && $runtime.mode == "view"}

	$.ceAjax('request', fn_url("rf_pro_marketing.fb"), {ldelim}
		method: 'POST',
		caching: false,
		hidden: true,
		data: {ldelim}
			'event': 'PageView_P',
			'page_id': '{$smarty.request.page_id|default:0|intval}',
		{rdelim},
		callback: function (data) {ldelim}
			data = data.data;
			if (data.status == "success") {ldelim}
				fbq('track', 'PageView', {ldelim}{rdelim}, {ldelim}eventID: data.event_id{rdelim});
			{rdelim}
		{rdelim}
	{rdelim});

	{elseif $runtime.controller == "product_features" && $runtime.mode == "view_all"}

	$.ceAjax('request', fn_url("rf_pro_marketing.fb"), {ldelim}
		method: 'POST',
		caching: false,
		hidden: true,
		data: {ldelim}
			'event': 'PageView_F',
			'filter_id': '{$smarty.request.filter_id|default:0|intval}',
		{rdelim},
		callback: function (data) {ldelim}
			data = data.data;
			if (data.status == "success") {ldelim}
				fbq('track', 'PageView', {ldelim}{rdelim}, {ldelim}eventID: data.event_id{rdelim});
			{rdelim}
		{rdelim}
	{rdelim});
	
	{elseif $runtime.controller == "index" && $runtime.mode == "index"}

	$.ceAjax('request', fn_url("rf_pro_marketing.fb"), {ldelim}
		method: 'POST',
		caching: false,
		hidden: true,
		data: {ldelim}
			'event': 'PageView_I',
		{rdelim},
		callback: function (data) {ldelim}
			data = data.data;
			if (data.status == "success") {ldelim}
				fbq('track', 'PageView', {ldelim}{rdelim}, {ldelim}eventID: data.event_id{rdelim});
			{rdelim}
		{rdelim}
	{rdelim});

	{elseif $runtime.controller == "search" || ($runtime.controller == "products" && $runtime.mode == "search")}

	$.ceAjax('request', fn_url("rf_pro_marketing.fb"), {ldelim}
		method: 'POST',
		caching: false,
		hidden: true,
		data: {ldelim}
			'event': 'Search',
			'q': '{$smarty.request.q|default:""}',
		{rdelim},
		callback: function (data) {ldelim}
			data = data.data;
			if (data.status == "success") {ldelim}
				fbq('track', 'Search', {ldelim}{rdelim}, {ldelim}eventID: data.event_id{rdelim});
			{rdelim}
		{rdelim}
	{rdelim});

	{elseif (($runtime.controller == "checkout" && $runtime.mode == "complete") || ($runtime.controller == "onestepcheckout" && $runtime.mode == "complete")) && !empty($smarty.request.order_id)}

		{$sess_label = "order_id_"|cat:$smarty.request.order_id}
		{$sess = $smarty.session.{$sess_label}|default:false}
	 	{if !$sess}
			$.ceAjax('request', fn_url("rf_pro_marketing.fb"), {ldelim}
				method: 'POST',
				caching: false,
				hidden: true,
				data: {ldelim}
					'event': 'Purchase',
					'order_id': '{$smarty.request.order_id|default:0|intval}',
				{rdelim},
				callback: function (data) {ldelim}
					data = data.data;
					if (data.status == "success") {ldelim}
						fbq('track', 'Purchase', {ldelim}
							content_type: data.content_type,
							contents: data.contents,
							value: data.value,
							currency: data.currency
						{rdelim}, {ldelim}eventID: data.event_id{rdelim});
					{rdelim}
				{rdelim}
			{rdelim});
		{/if}

	{elseif ($runtime.controller == "checkout" && $runtime.mode == "checkout") || ($runtime.controller == "onestepcheckout" && $runtime.mode == "checkout")}

	$.ceAjax('request', fn_url("rf_pro_marketing.fb"), {ldelim}
		method: 'POST',
		caching: false,
		hidden: true,
		data: {ldelim}
			'event': 'InitiateCheckout',
		{rdelim},
		callback: function (data) {ldelim}
			data = data.data;
			if (data.status == "success") {ldelim}
				fbq('track', 'InitiateCheckout', {ldelim}{rdelim}, {ldelim}eventID: data.event_id{rdelim});
			{rdelim}
		{rdelim}
	{rdelim});

	{/if}
</script>
{/if}

{if $google_conversion_id}
	{if $runtime.controller == "index" && $runtime.mode == "index"}
		{literal}
		<script type="text/javascript">
			var _rf_google_tag_params = {
				ecomm_pagetype : 'home',
				ecomm_prodid : '',
				ecomm_totalvalue : 0
			};
		</script>
		{/literal}
	{elseif $runtime.controller == "categories"}
		{literal}
		<script type="text/javascript">
			var _rf_google_tag_params = {
				ecomm_pagetype : 'category',
				ecomm_prodid : '',
				ecomm_totalvalue : 0
			};
		</script>
		{/literal}
	{elseif $runtime.controller == "products" && $runtime.mode == "view"}
		<script type="text/javascript">
			var _rf_google_tag_params = {ldelim}
				ecomm_pagetype : 'product',
				ecomm_prodid : '{$product.$google_product_id_param}',
				ecomm_totalvalue : '{$product.price}'
				{rdelim};
		</script>
	{elseif $runtime.controller == "checkout" && $runtime.mode == "cart"}
		<script type="text/javascript">
			var _rf_google_tag_params = {ldelim}
				ecomm_pagetype : 'cart',
				ecomm_prodid : {strip}[
					{foreach from=$cart_products item="product" key="key" name="cart_products"}
					'{$product.$google_product_id_param}'{if !$smarty.foreach.cart_products.last},{/if}
					{/foreach}
				]{/strip},
				ecomm_totalvalue : {$cart.total}
				{rdelim};
		</script>
	{elseif ($runtime.controller == "orders" && $runtime.mode == "processing") || ($runtime.controller == "checkout" && $runtime.mode == "complete")}
		{assign var="rf_order_placed" value=1}
		<script type="text/javascript">
			var _rf_google_tag_params = {ldelim}
				ecomm_pagetype : 'purchase',
				ecomm_prodid : {strip}[
					{foreach from=$order_info.products item="product" key="key" name="cart_products"}
					'{$product.$google_product_id_param}'{if !$smarty.foreach.cart_products.last},{/if}
					{/foreach}
				]{/strip},
				ecomm_totalvalue : {$order_info.total}
				{rdelim};
		</script>
	{else}
		{literal}
		<script type="text/javascript">
			var _rf_google_tag_params = {
				ecomm_pagetype : 'other',
				ecomm_prodid : '',
				ecomm_totalvalue : 0
			};
		</script>
		{/literal}
	{/if}

	<!-- Google ecommerce -->
	<!-- Global site tag (gtag.js) - Google Ads: {$google_conversion_id} -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-{$google_conversion_id}"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){ldelim}dataLayer.push(arguments);{rdelim}
		gtag('js', new Date());
		gtag('config', 'AW-{$google_conversion_id}');
	</script>
	<script>
	gtag('event', 'page_view', {ldelim}
		'send_to': 'AW-{$google_conversion_id}',
		'ecomm_pagetype': _rf_google_tag_params.ecomm_pagetype,
		'ecomm_prodid': _rf_google_tag_params.ecomm_prodid,
		'ecomm_totalvalue': _rf_google_tag_params.ecomm_totalvalue
	{rdelim});
	</script>
	{if $rf_order_placed && $addons.rf_pro_marketing.conversion_label}
	<script>
		gtag('event', 'conversion', {ldelim}
			'send_to': 'AW-{$google_conversion_id}/{$addons.rf_pro_marketing.conversion_label}',
			'value': {$order_info.total},
			'currency': _RF_MARKETING_CURRENCY,
			'transaction_id': '{$order_info.order_id}'
		{rdelim});
	</script>
	{/if}
{/if}

{if $criteo_account_id}
	<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
	<script>
		var _RF_CRITEO_ACCOUNT_ID = '{$criteo_account_id}';
		var _RF_CRITEO_HASHED_EMAIL = '{$rf_hashed_email}';
		var _RF_CRITEO_DEVICE_TYPE = '{$rf_device_type}';
	</script>

	{if $runtime.controller == "index" && $runtime.mode == "index"}
		<script type="text/javascript">
			window.criteo_q = window.criteo_q || [];
			window.criteo_q.push(
				{ldelim} event: "setAccount", account: '{$criteo_account_id}' {rdelim},
				{ldelim} event: "setSiteType", type: _RF_CRITEO_DEVICE_TYPE {rdelim},
				{ldelim} event: "setHashedEmail", email: _RF_CRITEO_HASHED_EMAIL {rdelim},
				{ldelim} event: "viewHome" {rdelim}
			);
		</script>
	{elseif $runtime.controller == "categories"}
		<script type="text/javascript">
			window.criteo_q = window.criteo_q || [];
			window.criteo_q.push(
				{ldelim} event: "setAccount", account: '{$criteo_account_id}' {rdelim},
				{ldelim} event: "setSiteType", type: _RF_CRITEO_DEVICE_TYPE {rdelim},
				{ldelim} event: "setHashedEmail", email: _RF_CRITEO_HASHED_EMAIL {rdelim},
				{ldelim} event: "viewList", item: {strip}[
					{foreach from=$products item="product" key="key" name="category_products"}
						{$product.product_id}{if !$smarty.foreach.category_products.last},{/if}
					{/foreach}
				]{/strip}{rdelim}
			);
		</script>
    {elseif $runtime.controller == "products" && $runtime.mode == "view"}
		<script type="text/javascript">
			window.criteo_q = window.criteo_q || [];
			window.criteo_q.push(
				{ldelim} event: "setAccount", account: '{$criteo_account_id}' {rdelim},
				{ldelim} event: "setSiteType", type: _RF_CRITEO_DEVICE_TYPE {rdelim},
				{ldelim} event: "setHashedEmail", email: _RF_CRITEO_HASHED_EMAIL {rdelim},
				{ldelim} event: "viewItem", item: "{$product.product_id}" {rdelim}
			);
		</script>
    {elseif $runtime.controller == "checkout" && $runtime.mode == "cart"}
		<script type="text/javascript">
			window.criteo_q = window.criteo_q || [];
			window.criteo_q.push(
				{ldelim} event: "setAccount", account: '{$criteo_account_id}' {rdelim},
				{ldelim} event: "setSiteType", type: _RF_CRITEO_DEVICE_TYPE {rdelim},
				{ldelim} event: "setHashedEmail", email: _RF_CRITEO_HASHED_EMAIL {rdelim},
				{ldelim} event: "viewBasket", item: {strip}[
					{foreach from=$cart_products item="product" key="key" name="cart_products"}
						{ldelim}id: "{$product.product_id}", price: "{$product.price}", quantity: "{$product.amount}"{rdelim}{if !$smarty.foreach.cart_products.last},{/if}
					{/foreach}
				]{/strip}{rdelim}
			);
		</script>
	{elseif ($runtime.controller == "orders" && $runtime.mode == "processing") || ($runtime.controller == "checkout" && $runtime.mode == "complete")}
		<script type="text/javascript">
			window.criteo_q = window.criteo_q || [];
			window.criteo_q.push(
				{ldelim} event: "setAccount", account: {$criteo_account_id} {rdelim},
				{ldelim} event: "setSiteType", type: _RF_CRITEO_DEVICE_TYPE {rdelim},
				{ldelim} event: "setHashedEmail", email: _RF_CRITEO_HASHED_EMAIL {rdelim},
				{ldelim} event: "trackTransaction", id: "{$order_info.order_id}", item: {strip}[
					{foreach from=$order_info.products item="product" key="key" name="cart_products"}
						{ldelim}id: "{$product.product_id}", price: "{$product.price}", quantity: "{$product.amount}"{rdelim},
					{/foreach}
					{ldelim}id: "delivery_price", price: "{$order_info.shipping_cost}", quantity: 1{rdelim}
				]{/strip}{rdelim}
			);
		</script>
	{/if}
{/if}

{* [LEADHIT] *}
{if $addons.rf_pro_marketing.leadhit_id}
	<script type="text/javascript" language="javascript">
		var _lh_params = {ldelim}"popup": false{rdelim};
		lh_clid="{$addons.rf_pro_marketing.leadhit_id}";
		(function() {ldelim}
			var lh = document.createElement('script'); lh.type = 'text/javascript'; lh.async = true;
			lh.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'track.leadhit.io/track.js?ver=' + Math.floor(Date.now()/100000).toString();
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lh, s);
		{rdelim})();
	</script>
	{if ($runtime.controller == "orders" && $runtime.mode == "processing") || ($runtime.controller == "checkout" && $runtime.mode == "complete")}
		<script type="text/javascript">
			(function () {
				{literal}
				function readCookie(name) {
					if (document.cookie.length > 0) {
						offset = document.cookie.indexOf(name + "=");
						if (offset != -1) {
							offset = offset + name.length + 1;
							tail = document.cookie.indexOf(";", offset);
							if (tail == -1) tail = document.cookie.length;
							return unescape(document.cookie.substring(offset, tail));
						}
					}
					return null;
				}
				{/literal}
				var lh_clid = '{$addons.rf_pro_marketing.leadhit_id}'; /* ID Магазина */
				var order_id = '{$order_info.order_id}'; // String
				var cart_sum = '{$order_info.total}'; // String
				var order_offers = [
					{foreach from=$order_info.products item="product" key="key" name="cart_products"}
					{ldelim}
						'url': '{$product.product_id|fn_exim_get_product_url}',
						'name': '{$product.product|escape:"javascript"}',
						'count': '{$product.amount}',
						'currency': _RF_MARKETING_CURRENCY
					{rdelim}{if !$smarty.foreach.cart_products.last},{/if}
					{/foreach}
				];
				var uid = readCookie('_lhtm_u');
				var vid = readCookie('_lhtm_r').split('|')[1];
				var url = encodeURIComponent(window.location.href);
				var path = "https://track.leadhit.io/stat/lead_form?f_orderid=" + order_id + "&url=" + url + "&action=lh_orderid&uid=" + uid + "&vid=" + vid + "&ref=direct&f_cart_sum=" + cart_sum + "&clid=" + lh_clid;
				var sc = document.createElement("script");
				sc.type = 'text/javascript';
				var headID = document.getElementsByTagName("head")[0];
				sc.src = path;
				headID.appendChild(sc);
				if (Array.isArray(order_offers) && order_offers.length > 0) {
					var requestBody = {
						'order_id': order_id,
						'cart_sum': cart_sum,
						'vid': vid,
						'uid': uid,
						'clid': lh_clid,
						'offers': order_offers
					}
					var xhr = new XMLHttpRequest();
					xhr.open('POST', 'https://track.leadhit.io/stat/lead_order', true);
					xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
					xhr.onreadystatechange = function () {
						if (this.readyState != 4) return
						console.log('order sended')
					}
					xhr.send(JSON.stringify(requestBody));
				}
			})();
		</script>
	{/if}
{/if}
{* [/LEADHIT] *}

{script src="js/addons/rf_pro_marketing/func.js"}

{* TAPFILIATE *}
{if $addons.rf_pro_marketing.tapfiliate_id}
	<script src="https://script.tapfiliate.com/tapfiliate.js" type="text/javascript" async></script>
	<script type="text/javascript">
		{literal}(function(t,a,p){t.TapfiliateObject=a;t[a]=t[a]||function(){ (t[a].q=t[a].q||[]).push(arguments)}})(window,'tap');{/literal}
		tap('create', '{$addons.rf_pro_marketing.tapfiliate_id}', {ldelim} integration: "javascript" {rdelim});
		tap('detect');
	</script>
	{if ($runtime.controller == "orders" && $runtime.mode == "processing") || ($runtime.controller == "checkout" && $runtime.mode == "complete")}
	<script type="text/javascript">
		{literal}(function(t,a,p){t.TapfiliateObject=a;t[a]=t[a]||function(){ (t[a].q=t[a].q||[]).push(arguments)}})(window,'tap');{/literal}
		tap('create', '{$addons.rf_pro_marketing.tapfiliate_id}', {ldelim} integration: "javascript" {rdelim});
		tap('conversion', '{$order_info.order_id}', '{$order_info.total}');
	</script>
	{/if}
{/if}
{* /TAPFILIATE *}

{* AFFILIATLY *}
{if $addons.rf_pro_marketing.affiliatly_id}
	<script type="text/javascript" src="https://www.affiliatly.com/easy_affiliate.js"></script>
	<script type="text/javascript">startTracking('{$addons.rf_pro_marketing.affiliatly_id}');</script>
	{if ($runtime.controller == "orders" && $runtime.mode == "processing") || ($runtime.controller == "checkout" && $runtime.mode == "complete")}
	<script type="text/javascript">markPurchase('{$addons.rf_pro_marketing.affiliatly_id}', '{$order_info.order_id}', '{$order_info.total}');</script>
	{/if}
{/if}
{* /AFFILIATLY *}
