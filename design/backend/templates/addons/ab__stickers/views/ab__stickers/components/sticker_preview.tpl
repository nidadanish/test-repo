{$text_style = "Tygh\Enum\Addons\Ab_stickers\StickerStyles::TEXT"|constant}
{if $sticker.style == $text_style}
{if !$hide_link}
<a class="row-status ab-stickers-container__{$sticker.output_position_list}{$addons.ab__stickers.output_position}" href="{"ab__stickers.update?sticker_id=`$sticker.sticker_id`"|fn_url}">
{/if}
<span class="ab-sticker T-sticker {$sticker.appearance.appearance_style|default:$addons.ab__stickers.ts_appearance}" style="{if $sticker.appearance.uppercase_text == "Y"}text-transform:uppercase;font-size:.8em;{/if}color:{$sticker.appearance.text_color};background-color:{fn_ab__stickers_hex_to_rgba($sticker.appearance.sticker_bg, $sticker.appearance.sticker_bg_opacity)};{if $sticker.appearance.border_width != "0" && $addons.ab__stickers.ts_appearance != "beveled_angle"}box-shadow: inset 0 0 0 {$sticker.appearance.border_width} {$sticker.appearance.border_color}{/if}">{fn_ab__stickers_get_sticker_string_value($sticker.name_for_desktop|default:$sticker.name_for_admin, $ab__stickers_default_placeholders|default:[]) nofilter}</span>
{if !$hide_link}
</a>
{/if}
{else}
{$href = $sticker.main_pair.icon.https_image_path}
{if !$hide_link}
{$href = "ab__stickers.update?sticker_id=`$sticker.sticker_id`"|fn_url}
{/if}
{include file="common/image.tpl" image=$sticker.main_pair image_width=48 image_hieght=48 no_ids=true href=$href}
{/if}