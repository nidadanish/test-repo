{hook name="blocks:topmenu_dropdown"}
{strip}
{if $items}
    {if $block.properties.elements_per_column_third_level_view < 1}
        {$block.properties.elements_per_column_third_level_view = 1}
    {/if}
    {$block.properties.abt_menu_ajax_load = "YesNo::NO"|enum}

    <a href="javascript:void(0);" rel="nofollow" class="ut2-btn-close hidden" onclick="$(this).parent().prev().removeClass('open');$(this).parent().addClass('hidden');"><i class="ut2-icon-baseline-close"></i></a>

    <div class="ut2-menu__inbox">
        <ul class="ty-menu__items cm-responsive-menu">
            {hook name="blocks:topmenu_dropdown_top_menu"}

            {math assign="settings_cols" equation="min(6, x)" x=$block.properties.abt__ut2_columns_count|default:4}
            {foreach from=$items item="item1" name="item1"}
                {assign var="item1_url" value=$item1|fn_form_dropdown_object_link:$block.type}
                {assign var="unique_elm_id" value="topmenu_{$block.block_id}_{$block.snapping_id}_{substr(crc32(serialize($item1)), 0, 10)}"}
                {assign var="subitems_count" value=$item1.$childs|count}

                <li class="ty-menu__item{if !$item1.$childs} ty-menu__item-nodrop{else} cm-menu-item-responsive{/if}{if $item1.active || $item1|fn_check_is_active_menu_item:$block.type} ty-menu__item-active{/if} first-lvl{if $smarty.foreach.item1.last} last{/if}{if $item1.class} {$item1.class}{/if}" data-subitems-count="{$item1.$childs|count}" data-settings-cols="{$settings_cols}">
                    {if $item1.$childs}
                        <a class="ty-menu__item-toggle ty-menu__menu-btn visible-phone cm-responsive-menu-toggle">
    	                    <i class="ut2-icon-outline-expand_more"></i>
    	                </a>
                    {/if}

                    <a href="{$item1_url|default:"javascript:void(0)"}"{if $item1_url && $item1.new_window == "YesNo::YES"|enum} target="_blank"{/if} class="ty-menu__item-link a-first-lvl">
                        <span class="menu-lvl-ctn {if $item1.abt__ut2_mwi__status == 'Y' && $item1.abt__ut2_mwi__desc|strip_tags|trim}exp-wrap{/if}">
                            {if $item1.abt__ut2_mwi__status == 'Y' && $item1.abt__ut2_mwi__icon && $settings.abt__device != 'mobile'}
                                {include file="common/image.tpl" images=$item1.abt__ut2_mwi__icon class="ut2-mwi-icon" width=$image_data.width height=$image_data.height no_ids=true lazy_load=false}
                            {/if}
                            <span>
                            <bdi>{$item1.$name}</bdi>
                            {if $item1.abt__ut2_mwi__status == 'Y' && $item1.abt__ut2_mwi__label}
                                <span class="m-label" style="color: {$item1.abt__ut2_mwi__label_color}; background-color: {$item1.abt__ut2_mwi__label_background}; {if $item1.abt__ut2_mwi__label_background == '#ffffff'}border: 1px solid {$item1.abt__ut2_mwi__label_color}{else}border: 1px solid {$item1.abt__ut2_mwi__label_background};{/if}">{$item1.abt__ut2_mwi__label}</span>
                            {/if}
                            {if $item1.abt__ut2_mwi__desc|strip_tags|trim}
                                <br><span class="exp-mwi-text">{$item1.abt__ut2_mwi__desc|strip_tags|trim}</span>
                            {/if}
                            </span>
                            {if $item1.$childs}<i class="icon-right-dir ut2-icon-outline-arrow_forward"></i>{/if}
                        </span>
                    </a>
                    {if $item1.$childs}
                        {capture name="children"}
                            {$col_width = 100 / $settings_cols}
                            {include file="blocks/menu/components/vertical/`$block.properties.abt__ut2_filling_type|default:'column_filling'`.tpl"}
                        {/capture}

                        {if $block.properties.abt_menu_ajax_load != 'Y'}
                            <div class="ty-menu__submenu" id="{$unique_elm_id}">
                                {$smarty.capture.children nofilter}
                            </div>
                        {else}
                            <div class="abt__ut2_am ty-menu__submenu" id="{$unique_elm_id}_{$smarty.const.DESCR_SL}_{$settings.abt__device}"></div>
                            {$smarty.capture.children|fn_abt__ut2_ajax_menu_save:$unique_elm_id}
                        {/if}
                    {/if}
                </li>
            {/foreach}
            {/hook}
        </ul>
    </div>
{/if}
{if $block.properties.abt_menu_ajax_load == "YesNo::YES"|enum && !$smarty.capture.ut2_mwi_ajax_upload_included}
    {capture name="ut2_mwi_ajax_upload_included"}1{/capture}

    {include file="blocks/menu/components/ajax_upload.tpl"}
{/if}
{/strip}
{/hook}