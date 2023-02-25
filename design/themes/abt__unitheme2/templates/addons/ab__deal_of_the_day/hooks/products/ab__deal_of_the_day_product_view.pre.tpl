{if $product.promotions}
    {$promotions_ids = fn_ab__dotd_filter_applied_promotions(array_keys($product.promotions), ["exclude_hidden" => true])}
    {$promotion = $promotions_ids[0]|fn_ab__dotd_get_cached_promotion_data}

    {if $promotion}
    <div class="ab__deal_of_the_day">
        <a href="{"promotions.view?promotion_id=`$promotion.promotion_id`"|fn_url}" title="" target="_blank">
		<div{if $promotion.to_date && $promotion.to_date > $smarty.now} class="col1"{/if}>
	        <div class="pd-promotion__title cm-tooltip" {if $promotion.short_description|strip_tags|fn_string_not_empty} title="{$promotion.short_description}"{/if}>{$promotion.name}</div>
            {if !$quick_view}
                <div class="actions-link">
                    {if $promotions_ids|count > 1}
                        <a class="also-in-promos-link cm-external-click" data-ca-scroll="content_ab__deal_of_the_day" data-ca-external-click-id="ab__deal_of_the_day"><i class="cm-tooltip ty-icon-help-circle" title="{__('ab__dotd.all_promotions.title')}"></i><span>{__('ab__dotd.all_promotions')}</span></a>
                    {/if}
                </div>
            {/if}
        </div>

        {if $promotion.show_counter_on_product_page === "Y" && $promotion.to_date && $promotion.to_date > $smarty.now}
        <div class="col2">
            <span class="time-left">{__('ab__dotd_time_left')}:</span>
            {include file="addons/ab__deal_of_the_day/components/init_countdown.tpl"}
        </div>
        {/if}
        </a>
    </div>
    {/if}
{/if}