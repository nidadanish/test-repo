{$image_width = 45}

{if $promotion}
    <a href="{fn_url("promotions.view?promotion_id=`$promotion.promotion_id`")}">
        {if $promotion.image}
            {include file="common/image.tpl"
            show_detailed_link=false
            images=$promotion.image
            no_ids=true
            image_width=$image_width}
        {else}
            <i class="ty-no-image__icon ty-icon-image"></i>
        {/if}
        <span class="ab-dotd-promo-category-wrapper">
            {if $promotion.promotion_id }
                <span class="ab-dotd-promo-header">{__("ab__dotd_product_label")} <span>{$promotion.name}</span></span>
            {/if}
        </span>
    </a>
{/if}