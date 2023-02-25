{foreach from=$item1.$childs item="item2" name="item2"}
    {assign var="item_url2" value=$item2|fn_form_dropdown_object_link:$block.type}
    <div class="ty-menu__submenu-item{if $item2.active || $item2|fn_check_is_active_menu_item:$block.type} ty-menu__submenu-item-active{/if}{if $item2.class} {$item2.class}{/if}{if $item2.abt__ut2_mwi__icon} with-icon-items{/if}" {if $settings.abt__device != "mobile"}style="width:{$col_width}%"{/if}>
        <a class="ty-menu__submenu-link" {if $item_url2} href="{$item_url2}"{/if}>
            {if $block.properties.abt_menu_icon_items == "YesNo::YES"|enum && $item2.abt__ut2_mwi__icon && $settings.abt__device != "mobile"}
                {include file="common/image.tpl" images=$item2.abt__ut2_mwi__icon class="ut2-mwi-icon" no_ids=true}
            {/if}
            {strip}<bdi>{$item2.$name}
                {if $item2.abt__ut2_mwi__status == "YesNo::YES"|enum && $item2.abt__ut2_mwi__label}
                    <span class="m-label" style="color: {$item2.abt__ut2_mwi__label_color};background-color: {$item2.abt__ut2_mwi__label_background}; {if $item2.abt__ut2_mwi__label_background == "#ffffff"}border: 1px solid {$item2.abt__ut2_mwi__label_color}{else}border: 1px solid {$item2.abt__ut2_mwi__label_background};{/if}">{$item2.abt__ut2_mwi__label}<span class="arrow" style="border-color: {$item2.abt__ut2_mwi__label_background} transparent transparent transparent;"></span></span>
                {/if}
            </bdi>{/strip}
        </a>
    </div>
{/foreach}

{if $item1.abt__ut2_mwi__status == "YesNo::YES"|enum && $item1.abt__ut2_mwi__text|trim && $settings.abt__device != "mobile"}
    <div class="ut2-mwi-html {$item1.abt__ut2_mwi__text_position} hidden-phone">{$item1.abt__ut2_mwi__text|trim nofilter}</div>
{/if}
{if $item1.show_more && $item1_url}
    <div class="ty-menu__submenu-alt-link"><a class="ty-btn" href="{$item1_url}" title="">{__("text_topmenu_more", ["[item]" => $item1.$name])}</a></div>
{/if}