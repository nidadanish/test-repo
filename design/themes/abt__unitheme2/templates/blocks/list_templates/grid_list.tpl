{if $products}

	{$tmpl='products_multicolumns'}

	{include file="blocks/product_list_templates/components/show_features_conditions.tpl"}

    {script src="js/tygh/exceptions.js"}

    {if !$no_pagination}
        {include file="common/pagination.tpl"}
    {/if}

    {if !$no_sorting}
        {include file="views/products/components/sorting.tpl"}
    {/if}

    {if !$show_empty}
        {split data=$products size=$columns|default:"2" assign="splitted_products"}
    {else}
        {split data=$products size=$columns|default:"2" assign="splitted_products" skip_complete=true}
    {/if}




	{** Custom size grid item height **}

	{if $settings.abt__ut2.product_list.$tmpl.grid_item_height[$settings.abt__device]}
	    {$product_height=$settings.abt__ut2.product_list.$tmpl.grid_item_height[$settings.abt__device]}

	    {if !$show_add_to_cart || $settings.abt__ut2.product_list.$tmpl.show_buttons_on_hover[$settings.abt__device] == "YesNo::YES"|enum}
	    	{$product_height=$settings.abt__ut2.product_list.$tmpl.grid_item_height[$settings.abt__device] - 38}
	    {/if}
    {/if}

    {** Detecting grid item height **}

    {* Grid padding *}
    {assign var="pd" value=45}

    {* Thumb *}
    {if $settings.abt__device == "mobile"}
        {assign var="t1" value=150}
    {else}
        {assign var="t1" value=$settings.abt__ut2.product_list.$tmpl.image_height[$settings.abt__device]|default:$settings.Thumbnails.product_lists_thumbnail_height|intval + 10}
    {/if}

	{* Show rating *}
    {assign var="t2" value=25}

	{* Show sku *}
    {if $settings.abt__ut2.product_list.$tmpl.show_sku[$settings.abt__device] == "YesNo::YES"|enum}
    	{assign var="t3" value=17}
    {/if}

    {* Show name *}
    {assign var="t4" value=37}

    {* Show amount *}
    {if $settings.abt__ut2.product_list.$tmpl.show_amount[$settings.abt__device] == "YesNo::YES"|enum}
    	{assign var="t5" value=26}
    {/if}

    {* Show price *}
    {assign var="t6" value=42}

    {* Show buttons *}
    {if $show_add_to_cart && $settings.abt__ut2.product_list.$tmpl.show_buttons_on_hover[$settings.abt__device] == "YesNo::NO"|enum}
        {assign var="t7" value=41}
    {/if}

    {* Show your save *}
    {if $settings.abt__ut2.product_list.$tmpl.show_you_save[$settings.abt__device] == "YesNo::YES"|enum}
    	{assign var="t8" value=16}
    {/if}

    {* Show clean price *}
    {if $settings.Appearance.show_prices_taxed_clean == "YesNo::YES"|enum}
    	{assign var="t9" value=16}
    {/if}

    {* Show features *}
    {if $settings.abt__ut2.product_list.$tmpl.show_content_on_hover[$settings.abt__device] == "YesNo::NO"|enum}
        {if $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] == 'features' 
         || $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] == 'features_and_description'
         || $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] == 'features_and_variations'}
    	    {assign var="t10" value=$settings.abt__ut2.product_list.max_features[$settings.abt__device]*18.19}
    	{/if}
    {/if}
    
    {* Show s.description *}
    {if $settings.abt__ut2.product_list.$tmpl.show_content_on_hover[$settings.abt__device] == "YesNo::NO"|enum}
        {if $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] == 'description' 
         || $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] == 'features_and_description'}
        	{assign var="t11" value=47}
        {/if}
    {/if}

    {* Show variations *}
    {if $settings.abt__ut2.product_list.$tmpl.show_content_on_hover[$settings.abt__device] == "YesNo::NO"|enum}
        {if $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] == 'variations' 
         || $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] == 'features_and_variations'}
        	{assign var="t12" value=36}
        {/if}
    {/if}
    
    {* Show content block *}
    {if $settings.abt__ut2.product_list.$tmpl.show_content_on_hover[$settings.abt__device] == "YesNo::NO"|enum}
        {if $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] != 'none'}
            {assign var="pd" value=63}
        {/if}
    {/if}
    
	{$th = $t1|default:0 + $t2|default:0 + $t3|default:0 + $t4|default:0 + $t5|default:0 + $t6|default:0 + $t7|default:0 + $t8|default:0 + $t9|default:0 + $t10|default:0 + $t11|default:0 + $t12|default:0 + $pd}
    {capture name="abt__ut2_gl_item_height"}{if $settings.abt__ut2.product_list.$tmpl.grid_item_height[$settings.abt__device]}{$settings.abt__ut2.product_list.$tmpl.grid_item_height[$settings.abt__device]}{else}{$th}{/if}{/capture}

	{* Price block height *}
	{$pth = $t6|default:0 + $t8|default:0 + $t9|default:0}
	{capture name="abt__ut2_pr_block_height"}{$pth}{/capture}

    {** end **}



    {math equation="100 / x" x=$columns|default:"2" assign="cell_width"}
    {if $item_number == "YesNo::YES"|enum}
        {assign var="cur_number" value=1}
    {/if}

    {* FIXME: Don't move this file *}
    {script src="js/tygh/product_image_gallery.js"}

    {if $settings.Appearance.enable_quick_view == "YesNo::YES"|enum && $settings.abt__device != "mobile"}
        {$quick_nav_ids = $products|fn_fields_from_multi_level:"product_id":"product_id"}
    {/if}

    <div class="grid-list {$show_custom_class}">
	    {if $ut2_load_more}{include file="common/abt__ut2_pagination.tpl" type="`$runtime.controller`_`$runtime.mode`" position="top" object="products"}{/if}
        {strip}
            {foreach from=$splitted_products item="sproducts" name="sprod"}
                {foreach from=$sproducts item="product" name="sproducts"}
                    <div class="ty-column{$columns}"{if $ut2_load_more && $smarty.foreach.sprod.first && $smarty.foreach.sproducts.first} data-ut2-load-more="first-item"{/if}>
                        {if $product}
                            {assign var="obj_id" value=$product.product_id}
                            {assign var="obj_id_prefix" value="`$obj_prefix``$product.product_id``$settings.abt__device`"}
                            {include file="common/product_data.tpl" product=$product product_labels_position="left-top"}

                            <div class="ut2-gl__item" style="height: {$smarty.capture.abt__ut2_gl_item_height nofilter}px">
                                {assign var="form_open" value="form_open_`$obj_id`"}
                                {$smarty.capture.$form_open nofilter}
                                {hook name="products:product_multicolumns_list"}
                                <div class="ut2-gl__body {if $settings.abt__ut2.product_list.decolorate_out_of_stock_products == "YesNo::YES"|enum && $product.amount <= 0} decolorize{/if}" style="min-height: {$smarty.capture.abt__ut2_gl_item_height nofilter}px">
                                    <div class="ut2-gl__image" style="height:{$settings.abt__ut2.product_list.$tmpl.image_height[$settings.abt__device]|default:$settings.Thumbnails.product_lists_thumbnail_height|intval}px">

									{include file="views/products/components/product_icon.tpl"
									    product=$product
									    image_width=$settings.Thumbnails.product_details_thumbnail_width
										image_height=$settings.Thumbnails.product_details_thumbnail_height
										thumbnails_size=$thumbnails_size
									    show_gallery=$settings.abt__ut2.product_list.show_gallery == "YesNo::YES"|enum}

                                        {assign var="product_labels" value="product_labels_`$obj_prefix``$obj_id`"}
                                        {$smarty.capture.$product_labels nofilter}

                                        <div class="ut2-gl__buttons" {if $smarty.capture.abt__service_buttons_id}id="{$smarty.capture.abt__service_buttons_id}"{/if}>
                                            {if !$quick_view && $settings.Appearance.enable_quick_view == "YesNo::YES"|enum && $settings.abt__device != "mobile"}
                                                {include file="views/products/components/quick_view_link.tpl" quick_nav_ids=$quick_nav_ids}
                                            {/if}
                                            {if $addons.wishlist.status == "ObjectStatuses::ACTIVE"|enum && !$hide_wishlist_button}
                                                {include file="addons/wishlist/views/wishlist/components/add_to_wishlist.tpl" but_id="button_wishlist_`$obj_prefix``$product.product_id`" but_name="dispatch[wishlist.add..`$product.product_id`]" but_role="text"}
                                            {/if}
                                            {if $settings.General.enable_compare_products == "YesNo::YES"|enum && !$hide_compare_list_button || $product.feature_comparison == "YesNo::YES"|enum}
                                                {include file="buttons/add_to_compare_list.tpl" product_id=$product.product_id}
                                            {/if}
                                        <!--{$smarty.capture.abt__service_buttons_id}--></div>

										{if $show_brand_logo && $settings.abt__ut2.general.brand_feature_id > 0}
		                                    {$b_feature=$product.abt__ut2_features[$settings.abt__ut2.general.brand_feature_id]}
		                                    {if $b_feature.variants[$b_feature.variant_id].image_pairs}
			                                    <div class="brand-img">
				                                    {include file="common/image.tpl" image_height=20 images=$b_feature.variants[$b_feature.variant_id].image_pairs no_ids=true}
			                                    </div>
		                                    {/if}
		                                {/if}
                                    </div>

                                    <div class="ut2-gl__content {if $settings.abt__ut2.product_list.$tmpl.show_content_on_hover[$settings.abt__device] == "YesNo::YES"|enum} content-on-hover{/if}">
                                    
                                    {if $settings.abt__ut2.product_list.price_position_top|default:{"YesNo::YES"|enum} == "YesNo::YES"|enum}
                                    <div class="ut2-gl__price{if $product.price == 0} ut2-gl__no-price{/if}	pr-{$settings.abt__ut2.product_list.price_display_format}{if $product.list_discount || $product.discount} pr-color{/if}" style="min-height: {$smarty.capture.abt__ut2_pr_block_height nofilter}px;">
	                                    <div>
		                                    {assign var="old_price" value="old_price_`$obj_id`"}
	                                        {if $smarty.capture.$old_price|trim}{$smarty.capture.$old_price nofilter}{/if}

	                                        {assign var="price" value="price_`$obj_id`"}
	                                        {$smarty.capture.$price nofilter}
	                                    </div>
                                        <div>
	                                        {assign var="list_discount" value="list_discount_`$obj_id`"}
	                                        {$smarty.capture.$list_discount nofilter}

	                                        {assign var="clean_price" value="clean_price_`$obj_id`"}
	                                        {$smarty.capture.$clean_price nofilter}
										</div>
                                    </div>
                                    {/if}
                                    
        							{hook name="products:product_rating"}
                                    	<div class="ut2-gl__rating ut2-rating-stars {if $settings.abt__ut2.product_list.show_rating == "YesNo::YES"|enum && $addons.product_reviews.status == "ObjectStatuses::ACTIVE"|enum}r-block{/if}">

                                            {hook name="products:dotd_product_label"}{/hook}
                                            {hook name="products:video_gallery"}{/hook}

                                            {if $settings.abt__ut2.product_list.show_rating == "YesNo::YES"|enum && $addons.product_reviews.status == "ObjectStatuses::ACTIVE"|enum}
                                                {if $product.product_reviews_count}<div class="cn-reviews">({$product.product_reviews_count})</div>{/if}
                                                {if $product.average_rating}
                                                    {include file="addons/product_reviews/views/product_reviews/components/product_reviews_stars.tpl"
                                                        rating=$product.average_rating
                                                        link=true
                                                        product=$product
                                                    }
                                                {else}
                                                    <div class="ty-product-review-reviews-stars" data-ca-product-review-reviews-stars-full="0"></div>
                                                {/if}
                                            {elseif $settings.abt__ut2.product_list.show_rating|default:{"YesNo::YES"|enum} == "YesNo::YES"|enum}
                                                {assign var="rating" value="rating_$obj_id"}
                                                {if $smarty.capture.$rating|strlen > 40 && $product.discussion_type && $product.discussion_type != "D"}
                                                    {$smarty.capture.$rating nofilter}
                                                {elseif $addons.discussion.status == "ObjectStatuses::ACTIVE"|enum}
                                                     <span class="ty-nowrap ty-stars"><i class="ty-icon-star-empty"></i><i class="ty-icon-star-empty"></i><i class="ty-icon-star-empty"></i><i class="ty-icon-star-empty"></i><i class="ty-icon-star-empty"></i></span>
                                                {/if}
                                            {/if}
                                        </div>
        							{/hook}

                                    {if $product.product_code}
                                        {assign var="sku" value="sku_$obj_id"}
                                        {$smarty.capture.$sku nofilter}
                                    {/if}

									<div class="ut2-gl__name">
                                        {if $item_number == "YesNo::YES"|enum}
                                            <span class="item-number">{$cur_number}.&nbsp;</span>
                                            {math equation="num + 1" num=$cur_number assign="cur_number"}
                                        {/if}

                                        {assign var="name" value="name_$obj_id"}
                                        {$smarty.capture.$name nofilter}
                                    </div>

                                    {if $settings.abt__ut2.product_list.$tmpl.show_content_on_hover[$settings.abt__device] == "YesNo::NO"|enum}
                                        <div class="ut2-gl__bottom">
                                            {hook name="products:additional_info_before"}{/hook}
                                            {if $show_descr && $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] != "features_and_variations"}
                                                <div class="product-description">
                                                    {assign var="prod_descr" value="prod_descr_`$obj_id`"}
                                                    {$smarty.capture.$prod_descr nofilter}
                                                </div>                                      
                                            {/if}
                                            {if $show_features and $product.abt__ut2_features}
                                                <div class="ut2-gl__feature">
                                                    {assign var="product_features" value="product_features_`$obj_id`"}
                                                    {$smarty.capture.$product_features nofilter}
                                                </div>
                                            {/if}
                                        </div>
                                    {/if}
                                    
                                    {if $settings.abt__ut2.product_list.$tmpl.show_amount[$settings.abt__device] == "YesNo::YES"|enum}
                                    <div class="ut2-gl__amount">
                                        {assign var="product_amount" value="product_amount_`$obj_id`"}
                                        {$smarty.capture.$product_amount nofilter}
                                    </div>
                                    {/if}
                                    
                                    {if $settings.abt__ut2.product_list.price_position_top|default:{"YesNo::YES"|enum} == "YesNo::NO"|enum}
                                    <div class="ut2-gl__price{if $product.price == 0} ut2-gl__no-price{/if}	pr-{$settings.abt__ut2.product_list.price_display_format}{if $product.list_discount || $product.discount} pr-color{/if}" style="min-height: {$smarty.capture.abt__ut2_pr_block_height nofilter}px;">
	                                    <div>
		                                    {assign var="old_price" value="old_price_`$obj_id`"}
	                                        {if $smarty.capture.$old_price|trim}{$smarty.capture.$old_price nofilter}{/if}

	                                        {assign var="price" value="price_`$obj_id`"}
	                                        {$smarty.capture.$price nofilter}
	                                    </div>
                                        <div>
	                                        {assign var="list_discount" value="list_discount_`$obj_id`"}
	                                        {$smarty.capture.$list_discount nofilter}

	                                        {assign var="clean_price" value="clean_price_`$obj_id`"}
	                                        {$smarty.capture.$clean_price nofilter}
										</div>
                                    </div>
                                    {/if}

                                    </div>{* End "ut2-gl__content" conteiner *}

                                    {capture name="product_multicolumns_list_control_data_wrapper"}
                                        {if $show_add_to_cart && $settings.abt__ut2.product_list.$tmpl.show_buttons[$settings.abt__device] == "YesNo::YES"|enum}
                                            {assign var="qty" value="qty_`$obj_id`"}

                                            <div class="ut2-gl__control
                                                {if $settings.abt__ut2.product_list.$tmpl.show_buttons_on_hover[$settings.abt__device] == "YesNo::YES"|enum} hidden{/if}
                                                {if !$hide_form && ($settings.abt__ut2.addons.call_requests.item_button == "YesNo::YES"|enum && $addons.call_requests.buy_now_with_one_click == "YesNo::YES"|enum) && ($auth.user_id || $settings.General.allow_anonymous_shopping == "allow_shopping")} bt-2x{/if}
                                                {if $settings.abt__ut2.product_list.$tmpl.show_qty[$settings.abt__device] == 'Y' &&  $smarty.capture.$qty|strip_tags:false|replace:"&nbsp;":""|trim|strlen} ut2-view-qty{/if}">
                                            {capture name="product_multicolumns_list_control_data"}
                                                {hook name="products:product_multicolumns_list_control"}

                                                {if $show_qty && $smarty.capture.$qty|strip_tags:false|replace:"&nbsp;":""|trim|strlen}
                                                    <div class="ut2-gl__qty">
                                                        {$smarty.capture.$qty nofilter}
                                                    </div>
                                                {/if}

                                                <div class="button-container">
                                                    {$add_to_cart = "add_to_cart_`$obj_id`"}
                                                    {$smarty.capture.$add_to_cart nofilter}
                                                </div>

                                                {/hook}
                                            {/capture}
                                            {$smarty.capture.product_multicolumns_list_control_data nofilter}
                                        </div>
                                        {/if}
                                    {/capture}

                                    {if $smarty.capture.product_multicolumns_list_control_data|trim}
                                        {$smarty.capture.product_multicolumns_list_control_data_wrapper nofilter}
                                    {/if}

                                    <div class="ut2-gl__bottom">
                                        {hook name="products:additional_info"}{/hook}
                                        {hook name="products:additional_info_before"}{/hook}
                                        {if $settings.abt__ut2.product_list.$tmpl.show_content_on_hover[$settings.abt__device] == "YesNo::YES"|enum}
                                            {if $show_descr && $settings.abt__ut2.product_list.$tmpl.grid_item_bottom_content[$settings.abt__device] != "features_and_variations"}
                                                <div class="product-description">
                                                    {assign var="prod_descr" value="prod_descr_`$obj_id`"}
                                                    {$smarty.capture.$prod_descr nofilter}
                                                </div>                                      
                                            {/if}
                                            {if $show_features and $product.abt__ut2_features}
                                                <div class="ut2-gl__feature">
                                                    {assign var="product_features" value="product_features_`$obj_id`"}
                                                    {$smarty.capture.$product_features nofilter}
                                                </div>
                                            {/if}
                                            {hook name="products:additional_info_after"}{/hook}
                                        {/if}
                                    </div>
                                </div>
                                {/hook}
                                {assign var="form_close" value="form_close_`$obj_id`"}
                                {$smarty.capture.$form_close nofilter}
                            </div>
                        {/if}
                    </div>
                {/foreach}
                {if $show_empty && $smarty.foreach.sprod.last}
                    {assign var="iteration" value=$smarty.foreach.sproducts.iteration}
                    {capture name="iteration"}{$iteration}{/capture}
                    {hook name="products:$tmpl_extra"}
                    {/hook}
                    {assign var="iteration" value=$smarty.capture.iteration}
                    {if $iteration % $columns != 0}
                        {math assign="empty_count" equation="c - it%c" it=$iteration c=$columns}
                        {section loop=$empty_count name="empty_rows"}
                            <div class="ty-column{$columns}">
                                <div class="ut2-gl__item ty-product-empty" style="height: {if $settings.abt__ut2.product_list.$tmpl.grid_item_height[$settings.abt__device]}{if $settings.abt__ut2.product_list.$tmpl.show_sku[$settings.abt__device] == "YesNo::YES"|enum}{$product_height|intval + 16}{else}{$product_height|intval}{/if}{else}{$th}{/if}px">
                                    <span class="ty-product-empty__text">{__("empty")}</span>
                                </div>
                            </div>
                        {/section}
                    {/if}
                {/if}
            {/foreach}
        {/strip}
        {if $ut2_load_more}{include file="common/abt__ut2_pagination.tpl" type="{"`$runtime.controller`_`$runtime.mode`"}" position="bottom" object="products"}{/if}
    </div>

    {if !$no_pagination}
        {include file="common/pagination.tpl"}
    {/if}

{/if}

{capture name="mainbox_title"}{$title}{/capture}