{if $addons.sd_labels.detail_product_labels_overlay !== "YesNo::YES"|enum}
    {$sd_product_labels = "sd_product_labels_{$obj_prefix}{$obj_id}"}

    {if $smarty.capture.$sd_product_labels|trim}
        <div class="sd-col-full-width">
            {$smarty.capture.$sd_product_labels nofilter}
        </div>
    {/if}
{/if}
