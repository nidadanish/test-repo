{if $ab__vg_videos}
    {foreach $ab__vg_videos as $video}
        {*{if $product.details_layout == 'bigpicture_template' && $video.icon === "snapshot"}*}
            {*{$image_width = 800}*}
            {*{$image_height = 600}*}
        {*{/if}*}

        {if $addons.ab__video_gallery.on_thumbnail_click == 'image_replace' || $quick_view}
            <div id="det_img_link_{$preview_id}_{$video.video_id}" class="ab__vg_loading hidden ab__vg-image_gallery_video ab-{$addons.ab__video_gallery.video_icon}-icon"{if $video.settings.iframe_attributes} {$video.settings.iframe_attributes nofilter}{else} data-frameborder="0" data-allowfullscreen="1"{/if} data-src="{fn_ab__vg_get_video_embed_url($video)}">
                {include file="addons/ab__video_gallery/components/thumbnail.tpl" video=$video width=$image_width height=$image_height}
            </div>
        {else}
            <a id="det_img_link_{$preview_id}_{$video.video_id}" class="hidden ab__vg-image_gallery_video ab-{$addons.ab__video_gallery.video_icon}-icon cm-dialog-opener" data-ca-target-id="ab__vg_video_{$video.video_id}" data-ca-dialog-title="{$video.title}" title="{$video.title}" rel="nofollow">
                {include file="addons/ab__video_gallery/components/thumbnail.tpl" video=$video width=$image_width height=$image_height}
            </a>
        {/if}
    {/foreach}
{/if}