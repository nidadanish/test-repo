{if $products}

	{$tmpl='short_list'}

    {script src="js/tygh/exceptions.js"}

    {if !$no_pagination}
        {include file="common/pagination.tpl"}
    {/if}

    {if !$no_sorting}
        {include file="views/products/components/sorting.tpl"}
    {/if}

    {assign var="image_width" value=$image_width|default:100}
    {assign var="image_height" value=$image_height|default:100}

    <div class="ty-compact-list">
        {hook name="products:product_compact_list_view"}

        {if $ut2_load_more}{include file="common/abt__ut2_pagination.tpl" type="{"`$runtime.controller`_`$runtime.mode`"}" position="top"}{/if}
        {foreach from=$products item="product" key="key" name="products"}
            {assign var="obj_id" value=$product.product_id}
            {assign var="obj_id_prefix" value="`$obj_prefix``$product.product_id`"}
            {include file="common/product_data.tpl" product=$product product_labels_position="left-top"}
            {hook name="products:product_compact_list"}
                <div class="ty-compact-list__item {if $settings.abt__ut2.product_list.decolorate_out_of_stock_products == "YesNo::YES"|enum && $product.amount <= 0} decolorize{/if}" {if $ut2_load_more && $smarty.foreach.products.first} data-ut2-load-more="first-item"{/if}>
                    <form {if !$config.tweaks.disable_dhtml}class="cm-ajax cm-ajax-full-render"{/if} action="{""|fn_url}" method="post" name="short_list_form{$obj_prefix}">
                        <input type="hidden" name="result_ids" value="cart_status*,wish_list*,account_info*,abt__ut2_wishlist_count" />
                        <input type="hidden" name="redirect_url" value="{$config.current_url}" />
                        <div class="ty-compact-list__content">

                            {hook name="products:product_compact_list_image"}
                            <div class="ty-compact-list__image" {if !$product.main_pair}style="height: auto"{/if}>
                                <a href="{"products.view?product_id=`$product.product_id`"|fn_url}">
                                    {include file="common/image.tpl" image_width=$image_width image_height=$image_height images=$product.main_pair obj_id=$obj_id_prefix}
                                </a>
                                {assign var="product_labels" value="product_labels_`$obj_prefix``$obj_id`"}
                                {$smarty.capture.$product_labels nofilter}
                            </div>
                            {/hook}

                            <div class="ty-compact-list__title">

                                {assign var="name" value="name_$obj_id"}
                                <bdi>
                                {$smarty.capture.$name nofilter}

                                {if $settings.abt__device == "mobile" && $settings.abt__ut2.product_list.$tmpl.show_button_wishlist[$settings.abt__device] == "YesNo::YES"|enum || $settings.abt__device == "mobile" && $settings.abt__ut2.product_list.$tmpl.show_button_compare[$settings.abt__device] == "YesNo::YES"|enum}
                                    
                                    <div class="ty-dropdown-box">
                                        <div id="sw_box_w_c_{$obj_id}" class="cm-combination"><i class="ut2-icon-more_vert"></i></div>
                                        <div id="box_w_c_{$obj_id}" class="cm-popup-box ty-dropdown-box__content hidden">
                                        {if $addons.wishlist.status == "ObjectStatuses::ACTIVE"|enum && !$hide_wishlist_button && $settings.abt__ut2.product_list.$tmpl.show_button_wishlist[$settings.abt__device] == "YesNo::YES"|enum}
                                            {include file="addons/wishlist/views/wishlist/components/add_to_wishlist.tpl" but_id="button_wishlist_`$obj_prefix``$product.product_id`" but_name="dispatch[wishlist.add..`$product.product_id`]" but_role="text" but_label=true}
                                        {/if}
                                        {if $settings.General.enable_compare_products == "YesNo::YES"|enum && !$hide_compare_list_button && $settings.abt__ut2.product_list.$tmpl.show_button_compare[$settings.abt__device] == "YesNo::YES"|enum}
                                            {include file="buttons/add_to_compare_list.tpl" product_id=$product.product_id but_label=true}
                                        {/if}
                                        </div>
                                    </div>
                                {/if}
                                </bdi>

							    {hook name="products:product_rating"}
							        {strip}
                                	<div class="ty-compact-list__rating  ut2-rating-stars {if $settings.abt__ut2.product_list.show_rating == "YesNo::YES"|enum && $addons.product_reviews.status == "ObjectStatuses::ACTIVE"|enum}r-block{/if}">
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
                                        {else}
                                            {assign var="rating" value="rating_$obj_id"}
                                            {if $smarty.capture.$rating|strlen > 40 && $product.discussion_type && $product.discussion_type != "D"}
                                                {$smarty.capture.$rating nofilter}
                                            {elseif $addons.discussion.status == "ObjectStatuses::ACTIVE"|enum}
                                                 <span class="ty-nowrap ty-stars"><i class="ty-icon-star-empty"></i><i class="ty-icon-star-empty"></i><i class="ty-icon-star-empty"></i><i class="ty-icon-star-empty"></i><i class="ty-icon-star-empty"></i></span>
                                            {/if}
                                        {/if}
                                    </div>
                                    {/strip}
    							{/hook}

							    <div class="ty-compact-list__amount">
                                    {assign var="product_amount" value="product_amount_`$obj_id`"}
                                    {$smarty.capture.$product_amount nofilter}

                                    {$sku = "sku_`$obj_id`"}
                                    {$smarty.capture.$sku nofilter}
                                </div>

                            </div>

                            <div class="ty-compact-list__controls">

		                        <div class="ty-compact-list__price pr-{$settings.abt__ut2.product_list.price_display_format}{if $product.list_discount || $product.discount} pr-color{/if}">
		                            <div>
		                                {assign var="old_price" value="old_price_`$obj_id`"}
		                                {if $smarty.capture.$old_price|trim}{$smarty.capture.$old_price nofilter}{/if}

		                                {assign var="price" value="price_`$obj_id`"}
		                                {$smarty.capture.$price nofilter}
									</div>
		                                {assign var="clean_price" value="clean_price_`$obj_id`"}
		                                {$smarty.capture.$clean_price nofilter}
		                        </div>
                                <div class="ut2-compact-list__buttons">
                                    {if !$smarty.capture.capt_options_vs_qty}
                                        {assign var="product_options" value="product_options_`$obj_id`"}
                                        {$smarty.capture.$product_options nofilter}

                                        {assign var="qty" value="qty_`$obj_id`"}
                                        {$smarty.capture.$qty nofilter}
                                    {/if}

                                    {if $show_add_to_cart}
                                        {assign var="add_to_cart" value="add_to_cart_`$obj_id`"}
                                        {$smarty.capture.$add_to_cart nofilter}
                                    {/if}

                                    <div class="ut2-cl-bt" id="{$smarty.capture.abt__service_buttons_id}">
                                        {if !$quick_view && $settings.Appearance.enable_quick_view == "YesNo::YES"|enum && $settings.abt__ut2.product_list.$tmpl.show_button_quick_view[$settings.abt__device] == "YesNo::YES"|enum && $settings.abt__device != "mobile"}
                                            {include file="views/products/components/quick_view_link.tpl" quick_nav_ids=$quick_nav_ids}
                                        {/if}
                                        {if $addons.wishlist.status == "ObjectStatuses::ACTIVE"|enum && !$hide_wishlist_button && $settings.abt__ut2.product_list.$tmpl.show_button_wishlist[$settings.abt__device] == "YesNo::YES"|enum && $settings.abt__device != "mobile"}
                                            {include file="addons/wishlist/views/wishlist/components/add_to_wishlist.tpl" but_id="button_wishlist_`$obj_prefix``$product.product_id`" but_name="dispatch[wishlist.add..`$product.product_id`]" but_role="text"}
                                        {/if}
                                        {if $settings.General.enable_compare_products == "YesNo::YES"|enum && !$hide_compare_list_button && $settings.abt__ut2.product_list.$tmpl.show_button_compare[$settings.abt__device] == "YesNo::YES"|enum && $settings.abt__device != "mobile"}
                                            {include file="buttons/add_to_compare_list.tpl" product_id=$product.product_id}
                                        {/if}
                                    <!--{$smarty.capture.abt__service_buttons_id}--></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            {/hook}
        {/foreach}

        {if $ut2_load_more}{include file="common/abt__ut2_pagination.tpl" type="{"`$runtime.controller`_`$runtime.mode`"}" position="bottom" object="products"}{/if}

        {/hook}
    </div>

{if !$no_pagination}
    {include file="common/pagination.tpl" force_ajax=$force_ajax}
{/if}

{/if}