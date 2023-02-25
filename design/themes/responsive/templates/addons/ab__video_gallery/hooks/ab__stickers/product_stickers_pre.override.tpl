{strip}
    {$ab__vg_videos = $product.product_id|fn_ab__vg_get_videos}
    {$total_count = ($product.image_pairs|count + $ab__vg_videos|count + 1)}
    {$is_vertical = (($runtime.mode != "quick_view") && ($addons.ab__video_gallery.vertical == "YesNo::YES"|enum))}

    {assign var="th_size" value=min($addons.ab__video_gallery.th_size|default:35, 100)}
    {if $is_vertical}
        {if $total_count == 0 || $total_count == 1}
            {$gal_width = 0}
        {elseif $total_count >= 6 && $settings.Appearance.thumbnails_gallery == "YesNo::NO"|enum}
            {$gal_width = ($th_size * 2 + 18 + 5)}
        {else}
            {$gal_width = ($th_size + 12 + 5)}
        {/if}
    {else}
        {$gal_width = $th_size + 10}
    {/if}

    {$left_or_right = "left"}
    {if $language_direction == "rtl"}
        {$left_or_right = "right"}
    {/if}

    {if $details_page && $total_count > 1 && $product.ab__stickers}
        <!-- This wrapper was overrated by ab__video_gallery add-on -->
        <div class="ab-stickers-wrapper" style="{if $is_vertical}width:calc(100% - {$gal_width}px);{$left_or_right}:{$gal_width}px;bottom{else}{$left_or_right}{/if}:0">
    {/if}
{/strip}