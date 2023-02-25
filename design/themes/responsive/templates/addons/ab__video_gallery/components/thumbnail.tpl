{$class = "ab-vg-video-image"}
{$image_additional_attrs = [
    "data-ab-vg-image-emded-url" => fn_ab__vg_get_video_embed_url($video),
    "data-ab-vg-video-type" => $video.type
]}

{$ab__vg_unique = rand()}
{$ab__vg_obj_id = "`$preview_id`_`$video.video_id`_`$block.block_id`_`$ab__vg_unique`"}
{if $video.icon_type == "icon"}
    {if $video.icon}
        {include file="common/image.tpl" images=$video.icon image_width=$width image_height=$height show_detailed_link=false obj_id=$ab__vg_obj_id}
    {/if}
{else}
    {$image = [
        "image_path" => fn_ab__vg_get_video_icon($video),
        "image_x" => $width|default:0,
        "image_y" => $height|default:0,
        "alt" => $video.title|strip_tags,
        "relative_path" => "",
        "absolute_path" => ""
    ]}
    {include file="common/image.tpl" images=$image image_width=$image.image_x image_height=$image.image_y show_detailed_link=false obj_id=$ab__vg_obj_id}
{/if}