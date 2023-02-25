{if $promotion && $category_group}

{*Remove empty cells*}
{capture name="iteration"}0{/capture}

<div class="ty-column{$columns} ab-dotd-more-products">
    <div class="ut2-gl__item" style="aspect-ratio: var(--gl-item-width) / var(--gl-item-height)">
        <div style="height: 100%">
            <div class="ut2-gl__body">
                <div class="ut2-gl__image" style="max-height: {$tbh + $smarty.capture.abt__ut2_gl_content_height + 15 nofilter}px;aspect-ratio: {$tbw} / {$tbh + $smarty.capture.abt__ut2_gl_content_height + 15 nofilter};">
                    <a href="{"promotions.view?promotion_id=`$promotion.promotion_id`&cid=`$category_group.category_id`"|fn_url}">
                        <span class="ty-icon ty-icon-arrow-up-right ab-dotd-more-icon"></span>
                        {__('ab__dotd.more_products_from_category', ["[category]" => $category_group.category])}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{/if}