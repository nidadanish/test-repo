{* Only two levels. Vertical output *}
{if !$item1.$childs|fn_check_second_level_child_array:$childs}
    {hook name="blocks:topmenu_dropdown_2levels_elements"}
        <div class="ty-menu__submenu-items ty-menu__submenu-items-simple cm-responsive-menu-submenu{if $item1.abt__ut2_mwi__text && $item1.abt__ut2_mwi__text_position !="bottom"} with-pic{/if}" data-cols-count="{$settings_cols}" {if $settings.abt__device != "mobile"}style="min-height:{$block.properties.abt__ut2_menu_min_height}px"{/if}>
            {include file="blocks/menu/components/horizontal/two_level_columns.tpl"}
        </div>
    {/hook}
{else}
    {hook name="blocks:topmenu_dropdown_3levels_cols"}
        <div class="ty-menu__submenu-items cm-responsive-menu-submenu{if $item1.abt__ut2_mwi__dropdown == "YesNo::YES"|enum} tree-level-dropdown{else} {$dropdown_class}{if $item1.abt__ut2_mwi__text && $item1.abt__ut2_mwi__text_position != "bottom"} with-pic{/if}{/if}{if $block.properties.abt_menu_icon_items == "YesNo::YES"|enum} with-icon-items{/if} clearfix" {if $settings.abt__device != "mobile"}style="min-height:{$block.properties.abt__ut2_menu_min_height}px"{/if}>
            <div{if $settings.abt__device != "mobile"} style="min-height:{$block.properties.abt__ut2_menu_min_height}px"{/if}>
                {include file="blocks/menu/components/horizontal/three_level_columns.tpl"}
            </div>
        </div>
    {/hook}
{/if}