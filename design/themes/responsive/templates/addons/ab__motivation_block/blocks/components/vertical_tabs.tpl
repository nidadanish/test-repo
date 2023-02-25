{strip}
{foreach $ab__motivation_items as $ab__mb_item}
    {$key = "`$id`_`$ab__mb_item.motivation_item_id`"}
    {$capture_name = "mb__content_`$key`"}

    {capture name=$capture_name}
        {hook name="ab__mb:vertical_tab_content"}
            {hook name="ab__mb:templates_content"}
                {if $ab__mb_item.template_path == 'addons/ab__motivation_block/blocks/components/item_templates/geo_maps.tpl'}
                    {$product_id = $product.product_id}
                {/if}
            {/hook}

            {include file=$ab__mb_item.template_path}
        {/hook}
    {/capture}

    {if trim(strip_tags($smarty.capture.$capture_name, '<img>'))}
        <div class="ab__mb_item" style="background-color: {$addons.ab__motivation_block.bg_color}{if $addons.ab__motivation_block.bg_color !="#ffffff"};border-color: {$addons.ab__motivation_block.bg_color}{/if}">
            <div id="sw_{$key}" class="ab__mb_item-title cm-combination{if $addons.ab__motivation_block.save_element_state == "YesNo::YES"|enum} ab-mb-save-state{/if}{if ($ab__mb_item.expanded == "YesNo::YES"|enum && $smarty.cookies.$key != "YesNo::NO"|enum) || $smarty.cookies.$key == "YesNo::YES"|enum} open{/if}">
                {hook name="ab__mb:vertical_tab_title"}
                    {if $ab__mb_item.icon_type == 'img' && $ab__mb_item.main_pair}
                        {include file="common/image.tpl" images=$ab__mb_item.main_pair}
                    {elseif $ab__mb_item.icon_type == 'icon' && $ab__mb_item.icon_class}
                        <i class="{$ab__mb_item.icon_class} ab__mb_item-icon" style="color:{$ab__mb_item.icon_color}"></i>
                    {/if}
                    <div class="ab__mb_item-name" {live_edit name="ab__motivation_block:name:{$ab__mb_item.motivation_item_id}"}>{$ab__mb_item.name}</div>
                {/hook}
            </div>
            <div id="{$key}" class="ab__mb_item-description"{if ($ab__mb_item.expanded != "YesNo::YES"|enum || $smarty.cookies.$key == "YesNo::NO"|enum) && $smarty.cookies.$key != "YesNo::YES"|enum} style="display: none;"{/if}>
                {$smarty.capture.$capture_name nofilter}
            </div>
        </div>
    {/if}
{/foreach}
{/strip}