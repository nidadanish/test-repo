{assign var="show_price" value=true}
{assign var="show_old_price" value=true}
{assign var="show_clean_price" value=true}


<ul class="ty-template-small">
{foreach from=$products item="product" name="products"}
    {assign var="obj_id" value=$product.product_id}
    {assign var="obj_id_prefix" value="`$obj_prefix``$product.product_id`"}
    {include file="common/product_data.tpl" product=$product}
    {hook name="products:product_small_item"}
    <li class="ty-template-small__item clearfix">
        {assign var="form_open" value="form_open_`$obj_id`"}
        {$smarty.capture.$form_open nofilter}
            <div class="ty-template-small__item-img">
                <a href="{"products.view?product_id=`$product.product_id`"|fn_url}">{include file="common/image.tpl" image_width="50" image_height="50" images=$product.main_pair obj_id=$obj_id_prefix no_ids=true}</a>
            </div>
            <div class="ty-template-small__item-description">
                {if $block.properties.item_number == "YesNo::YES"|enum}<span class="ut2-hit">{$smarty.foreach.products.iteration}</span>{/if}
                {assign var="name" value="name_$obj_id"}<bdi>{$smarty.capture.$name nofilter}</bdi>
    			
				{hook name="products:product_rating"}
                	<div class="ty-template-small__rating ut2-rating-stars">

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
				{/hook}
                
                {if $show_price}
                <div class="ty-template-small__item-price pr-{$settings.abt__ut2.product_list.price_display_format}{if $product.list_discount || $product.discount} pr-color{/if}">
                    <div>
                        {assign var="old_price" value="old_price_`$obj_id`"}
                        {if $smarty.capture.$old_price|trim}{$smarty.capture.$old_price nofilter}{/if}

                        {assign var="price" value="price_`$obj_id`"}
                        {$smarty.capture.$price nofilter}
					</div>
                        {assign var="clean_price" value="clean_price_`$obj_id`"}
                        {$smarty.capture.$clean_price nofilter}
                </div>
                {/if}

                {assign var="add_to_cart" value="add_to_cart_`$obj_id`"}
                {if $smarty.capture.$add_to_cart|trim}<p>{$smarty.capture.$add_to_cart nofilter}</p>{/if}
            </div>
        {assign var="form_close" value="form_close_`$obj_id`"}
        {$smarty.capture.$form_close nofilter}
    </li>
    {/hook}
{/foreach}
</ul>