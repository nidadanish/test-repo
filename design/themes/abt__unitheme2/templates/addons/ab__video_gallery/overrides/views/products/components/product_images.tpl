{assign var="th_size" value=min($addons.ab__video_gallery.th_size|default:35, 100)}
{assign var="th_b_size" value=$th_size + 8}

{$ab__vg_videos = $product.product_id|fn_ab__vg_get_videos}
{$ab__vg_settings = $product.product_id|fn_ab__vg_get_setting}
{$is_vertical = (($runtime.mode != 'quick_view') && ($addons.ab__video_gallery.vertical == 'Y')) && $settings.abt__device != "mobile"}
{$total_count = ($product.image_pairs|count + $ab__vg_videos|count + 1)}

{capture name="abt__ut2_vertical_gallery_width"}{if $total_count >= 6 && $settings.Appearance.thumbnails_gallery == "N"}{$th_size * 2 + 24}{elseif $total_count > 1}{$th_size + 12}{/if}{/capture}

{if $product.main_pair.icon || $product.main_pair.detailed}
    {assign var="image_pair_var" value=$product.main_pair}
{elseif $product.option_image_pairs}
    {assign var="image_pair_var" value=$product.option_image_pairs|reset}
{/if}

{if $image_pair_var.image_id}
    {assign var="image_id" value=$image_pair_var.image_id}
{else}
    {assign var="image_id" value=$image_pair_var.detailed_id}
{/if}

{if !$preview_id}
    {assign var="preview_id" value=$product.product_id|uniqid}
{/if}

{if $product.product_id|fn_get_product_details_view != 'blocks/product_templates/bigpicture_template.tpl'}
    {$image_height_block = $settings.Thumbnails.product_details_thumbnail_height}
{/if}

<div class="ab_vg-images-wrapper clearfix" data-ca-previewer="true">
    {assign var="product_labels" value="product_labels_`$obj_prefix``$obj_id`"}
    {$smarty.capture.$product_labels nofilter}

    <div id="product_images_{$preview_id}" class="ty-product-img cm-preview-wrapper {if $is_vertical}ab-{if $settings.Appearance.thumbnails_gallery == "Y"}vg-{/if}vertical{/if}" {if $is_vertical && $total_count > 1}style="width: -webkit-calc(100% - {$smarty.capture.abt__ut2_vertical_gallery_width}px);width: calc(100% - {$smarty.capture.abt__ut2_vertical_gallery_width + 10}px);{if $image_height_block} max-height: {$image_height_block}px;{/if}"{elseif $image_height_block}style="max-height: {$image_height_block}px;"{/if}>
    {* print video_tumbs to var *}
{hook name="ab__vg_videos:video"}
    {capture name="ab__vg_videos"}
        {include file="addons/ab__video_gallery/components/videos.tpl"}
    {/capture}
{/hook}

        {* output videos before images *}
        {if $addons.ab__video_gallery.position == "pre"}
            {$smarty.capture.ab__vg_videos nofilter}
        {/if}

        {include file="common/image.tpl" obj_id="`$preview_id`_`$image_id`" images=$image_pair_var link_class="cm-image-previewer{if $ab__vg_videos && $ab__vg_settings.replace_image == "Y"} hidden{/if}" image_width=$image_width image_height=$image_height image_id="preview[product_images_`$preview_id`]"}

        {foreach from=$product.image_pairs item="image_pair"}
            {if $image_pair}
                {if $image_pair.image_id}
                    {assign var="img_id" value=$image_pair.image_id}
                {else}
                    {assign var="img_id" value=$image_pair.detailed_id}
                {/if}
                {include file="common/image.tpl" images=$image_pair link_class="cm-image-previewer hidden" obj_id="`$preview_id`_`$img_id`" image_width=$image_width image_height=$image_height image_id="preview[product_images_`$preview_id`]"}
            {/if}
        {/foreach}

        {* output videos after images *}
        {if $addons.ab__video_gallery.position == "post"}
            {$smarty.capture.ab__vg_videos nofilter}
        {/if}
    </div>

    {* Video popups content. For tab with videos or for popup onclick *}
    {include file="addons/ab__video_gallery/components/video_popups.tpl"}

    {$image_classes="cm-gallery-item cm-thumbnails-mini ty-product-thumbnails__item"}
    {if $product.image_pairs || $ab__vg_videos}
        {$image_counter = -1}
        {if $settings.Appearance.thumbnails_gallery == "Y"}
            {$image_classes="`$image_classes` gallery"}
            <input type="hidden" name="no_cache" value="1" />
            {strip}
                <div class="ty-center ty-product-thumbnails_gallery{if $is_vertical} ab-vg-vertical-thumbnails{/if}"{if $is_vertical} style="width: {$smarty.capture.abt__ut2_vertical_gallery_width - 4}px;{if $image_height_block}max-height: {$image_height_block + 20}px;{/if}"{/if}>
                    <div class="cm-image-gallery-wrapper ty-thumbnails_gallery ty-inline-block">
                        {strip}
                            <div class="ty-product-thumbnails cm-image-gallery" id="images_preview_{$preview_id}" data-ca-cycle="{$addons.ab__video_gallery.cycle}" data-ca-vertical="{if $is_vertical}Y{else}N{/if}" data-ca-main-image-height="{$image_height}">
                                {if $ab__vg_videos && $addons.ab__video_gallery.position == "pre"}
                                    {foreach $ab__vg_videos as $video}
                                        {$image_counter = $image_counter + 1}
                                        <div class="cm-item-gallery">
                                            <a href="javascript:void(0)" data-ca-gallery-large-id="det_img_link_{$preview_id}_{$video.video_id}" class="ab__vg-image_gallery_item cm-gallery-item cm-thumbnails-mini ty-product-thumbnails__item gallery {if $ab__vg_settings.replace_image == "Y" && $video@iteration == 1} active{/if}" data-ca-image-order="{$image_counter}" data-ca-parent="#product_images_{$preview_id}" style="width:{$th_b_size}px;height:{$th_b_size}px;">
                                                {include file="addons/ab__video_gallery/components/video_icon.tpl" icon_width=$th_size icon_height=$th_size icon_alt=$video.title|strip_tags obj_id="`$preview_id`_`$video.video_id`_mini"}
                                            </a>
                                        </div>
                                    {/foreach}
                                {/if}

                                {if $image_pair_var}
                                    {$image_counter = $image_counter + 1}
                                    <div class="cm-item-gallery">
                                        <a href="javascript:void(0)" data-ca-gallery-large-id="det_img_link_{$preview_id}_{$image_id}" class="cm-gallery-item cm-thumbnails-mini ty-product-thumbnails__item gallery {if !$ab__vg_videos || $ab__vg_settings.replace_image != "Y"} active{/if}" data-ca-image-order="{$image_counter}" data-ca-parent="#product_images_{$preview_id}">
                                            {include file="common/image.tpl" ab__vg_gallery_image=true images=$image_pair_var image_width=$th_size image_height=$th_size show_detailed_link=false obj_id="`$preview_id`_`$video.video_id`_mini"}
                                        </a>
                                    </div>
                                {/if}
                                {if $product.image_pairs}
                                    {foreach from=$product.image_pairs item="image_pair"}
                                        {$image_counter = $image_counter + 1}
                                        {if $image_pair}
                                            <div class="cm-item-gallery">
                                                {if $image_pair.image_id}
                                                    {assign var="img_id" value=$image_pair.image_id}
                                                {else}
                                                    {assign var="img_id" value=$image_pair.detailed_id}
                                                {/if}
                                                <a href="javascript:void(0)" data-ca-gallery-large-id="det_img_link_{$preview_id}_{$img_id}" class="cm-gallery-item cm-thumbnails-mini ty-product-thumbnails__item gallery" data-ca-image-order="{$image_counter}" data-ca-parent="#product_images_{$preview_id}" >
                                                    {include file="common/image.tpl" ab__vg_gallery_image=true images=$image_pair image_width=$th_size image_height=$th_size show_detailed_link=false obj_id="`$preview_id`_`$video.video_id`_mini"}
                                                </a>
                                            </div>
                                        {/if}
                                    {/foreach}
                                {/if}

                                {if $ab__vg_videos && $addons.ab__video_gallery.position == "post"}
                                    {foreach $ab__vg_videos as $video}
                                        {$image_counter = $image_counter + 1}
                                        <div class="cm-item-gallery">
                                            <a href="javascript:void(0)" data-ca-gallery-large-id="det_img_link_{$preview_id}_{$video.video_id}" class="ab__vg-image_gallery_item cm-gallery-item cm-thumbnails-mini ty-product-thumbnails__item gallery {if $ab__vg_settings.replace_image == "Y" && $video@iteration == 1} active{/if}" data-ca-image-order="{$image_counter}" data-ca-parent="#product_images_{$preview_id}" style="width:{$th_b_size}px;height:{$th_b_size}px;">
                                                {include file="addons/ab__video_gallery/components/video_icon.tpl" icon_width=$th_size icon_height=$th_size icon_alt=$video.title|strip_tags obj_id="`$preview_id`_`$video.video_id`_mini"}
                                            </a>
                                        </div>
                                    {/foreach}
                                {/if}

                            </div>
                        {/strip}
                    </div>
                </div>
            {/strip}
        {else}
            <div class="ty-product-thumbnails ty-center{if $is_vertical} ab-{if $settings.Appearance.thumbnails_gallery == "Y"}vg-{/if}vertical-thumbnails{/if}" {if $is_vertical}style="width: {$smarty.capture.abt__ut2_vertical_gallery_width - 1}px;"{/if} id="images_preview_{$preview_id}">
                {strip}

                    {if $ab__vg_videos && $addons.ab__video_gallery.position == "pre"}
                        {foreach $ab__vg_videos as $video}
                            {$image_counter = $image_counter + 1}
                            <a href="javascript:void(0)" data-ca-gallery-large-id="det_img_link_{$preview_id}_{$video.video_id}" class="ab__vg-image_gallery_item ty-product-thumbnails__item cm-thumbnails-mini{if $ab__vg_settings.replace_image == "Y" && $video@iteration == 1} active{/if}" data-ca-image-order="{$image_counter}" data-ca-parent="#product_images_{$preview_id}" style="width:{$th_b_size}px;height:{$th_b_size}px;">
                                {include file="addons/ab__video_gallery/components/video_icon.tpl" icon_width=$th_size icon_height=$th_size icon_alt=$video.title|strip_tags obj_id="`$preview_id`_`$image_id`_mini"}
                            </a>
                        {/foreach}
                    {/if}

                    {if $image_pair_var}
                        {$image_counter = $image_counter + 1}
                        <a href="javascript:void(0)" data-ca-gallery-large-id="det_img_link_{$preview_id}_{$image_id}" class="cm-thumbnails-mini ty-product-thumbnails__item{if !$ab__vg_videos || $ab__vg_settings.replace_image != "Y"} active{/if}" data-ca-image-order="{$image_counter}" data-ca-parent="#product_images_{$preview_id}">
                            {include file="common/image.tpl" ab__vg_gallery_image=true images=$image_pair_var image_width=$th_size image_height=$th_size show_detailed_link=false obj_id="`$preview_id`_`$image_id`_mini"}
                        </a>
                    {/if}

                    {if $product.image_pairs}
                        {foreach from=$product.image_pairs item="image_pair"}
                            {$image_counter = $image_counter + 1}
                            {if $image_pair}
                                {if $image_pair.image_id == 0}
                                    {assign var="img_id" value=$image_pair.detailed_id}
                                {else}
                                    {assign var="img_id" value=$image_pair.image_id}
                                {/if}
                                <a href="javascript:void(0)" data-ca-gallery-large-id="det_img_link_{$preview_id}_{$img_id}" class="cm-thumbnails-mini ty-product-thumbnails__item" data-ca-image-order="{$image_counter}" data-ca-parent="#product_images_{$preview_id}">
                                    {include file="common/image.tpl" ab__vg_gallery_image=true images=$image_pair image_width=$th_size image_height=$th_size show_detailed_link=false obj_id="`$preview_id`_`$img_id`_mini"}
                                </a>
                            {/if}
                        {/foreach}
                    {/if}

                    {if $ab__vg_videos && $addons.ab__video_gallery.position == "post"}
                        {foreach $ab__vg_videos as $video}
                            {$image_counter = $image_counter + 1}
                            <a href="javascript:void(0)" data-ca-gallery-large-id="det_img_link_{$preview_id}_{$video.video_id}" class="ab__vg-image_gallery_item ty-product-thumbnails__item cm-thumbnails-mini{if $ab__vg_settings.replace_image == "Y" && $video@iteration == 1} active{/if}" data-ca-image-order="{$image_counter}" data-ca-parent="#product_images_{$preview_id}" style="width:{$th_b_size}px;height:{$th_b_size}px;">
                                {include file="addons/ab__video_gallery/components/video_icon.tpl" icon_width=$th_size icon_height=$th_size icon_alt=$video.title|strip_tags obj_id="`$preview_id`_`$image_id`_mini"}
                            </a>
                        {/foreach}
                    {/if}

                {/strip}
            </div>
        {/if}
    {/if}
</div>

{include file="common/previewer.tpl"}

{script src="js/addons/ab__video_gallery/product_image_gallery.js"}

{hook name="products:product_images"}{/hook}