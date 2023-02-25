{* Video popups content. For tab with videos or for popup onclick *}
{foreach $ab__vg_videos as $video}
    <div id="ab__vg_video_{$video.video_id}" class="ab__vg_video_popup cm-popup-box hidden" data-ca-keep-in-place="true" title="{$video.title}">
        <div id="ab__vg_iframe_video_{$video.video_id}" class="ab__vg_loading"{if $video.settings.iframe_attributes} {$video.settings.iframe_attributes nofilter}{else} data-frameborder="0" data-allowfullscreen="1"{/if} data-src="{fn_ab__vg_get_video_embed_url($video)}">
            {include file="addons/ab__video_gallery/components/thumbnail.tpl" video=$video}
        </div>
    </div>
{/foreach}