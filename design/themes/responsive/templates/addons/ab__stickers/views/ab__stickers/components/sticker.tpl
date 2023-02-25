{strip}
{** Use this variables to check sticker type **}
{$text_style = "Tygh\Enum\Addons\Ab_stickers\StickerStyles::TEXT"|constant}
{$graphic_style = "Tygh\Enum\Addons\Ab_stickers\StickerStyles::GRAPHIC"|constant}

{if $sticker.style != $graphic_style || $sticker.main_pair}
    {$position = "list"}
    {if $smarty.request.controller_mode == "products.view"}
        {$position = "detailed_page"}
    {/if}

    {hook name="ab__stickers:sticker"}
        <div class="ab-sticker{if $sticker.style == $text_style} {$sticker.appearance.appearance_style|default:$addons.ab__stickers.ts_appearance}{if $sticker.appearance.use_theme_presets|default:"N" == "Y"} theme-color-presets{/if}{/if}{if $sticker.appearance.{$position}.user_class} {$sticker.appearance.{$position}.user_class}{/if} {$sticker.style}-sticker"{if $sticker.description} data-id="{if $sticker.html_id}{$sticker.html_id}{else}{$sticker.sticker_id}-{$sticker.hash}{/if}"{/if}{if $sticker.style == $text_style} style="{if $sticker.appearance.use_theme_presets|default:"N" != "Y"}background-color:{fn_ab__stickers_hex_to_rgba($sticker.appearance.sticker_bg, $sticker.appearance.sticker_bg_opacity)};{/if}{if $sticker.appearance.border_width != "0" && $sticker.appearance.appearance_style|default:$addons.ab__stickers.ts_appearance != "beveled_angle"}box-shadow: inset 0 0 0 {$sticker.appearance.border_width} {$sticker.appearance.border_color}{/if}"{/if}>
            {if $sticker.style == $text_style}
                <div class="ab-sticker__name{if $sticker.appearance.uppercase_text == "Y"} uppercase{/if}">
                    {hook name="ab__stikcers:sticker_name"}
                        <span style="color:{$sticker.appearance.text_color}" class="tfs">{fn_ab__stickers_get_sticker_string_value($sticker.name_for_desktop|default:$sticker.name_for_admin, $sticker.placeholders|default:[]) nofilter}</span>
                        <span style="color:{$sticker.appearance.text_color}" class="tss">{fn_ab__stickers_get_sticker_string_value($sticker.name_for_mobile|default:$sticker.name_for_admin, $sticker.placeholders|default:[]) nofilter}</span>
                    {/hook}
                </div>
            {else}
                {if $sticker.appearance.small_size_image_size > $sticker.appearance.full_size_image_size}
                    {$image_width = $sticker.appearance.small_size_image_size}
                    {$image_height = $sticker.appearance.small_size_image_size}
                {else}
                    {$image_width = $sticker.appearance.full_size_image_size}
                    {$image_height = $sticker.appearance.full_size_image_size}
                {/if}
                {include file="common/image.tpl" images=$sticker.main_pair image_width=$image_width image_height=$image_height lazy_load=false}
            {/if}
        </div>
    {/hook}

    {hook name="ab__stickers:tooltip"}
    {if $sticker.description}
        <div class="ab-sticker__tooltip" data-sticker-id="{if $sticker.html_id}{$sticker.html_id}{else}{$sticker.sticker_id}-{$sticker.hash}{/if}">
            {hook name="ab__stickers:tooltip_closer"}
                <i class="ab-sticker__tooltip-closer ty-icon-cancel" onclick="Tygh.ab__stickers.close_tooltip(this)"></i>
            {/hook}
            {fn_ab__stickers_get_sticker_string_value($sticker.description, $sticker.placeholders|default:[])|strip nofilter}
        </div>
        <div class="ab-sticker__tooltip-pointer" data-sticker-p-id="{if $sticker.html_id}{$sticker.html_id}{else}{$sticker.sticker_id}-{$sticker.hash}{/if}"></div>
    {/if}
    {/hook}
{/if}
{/strip}