{if $category_banner}
    {hook name="ab__category_banner:banner"}{/hook}
    <div class="{$item_class} category-banner"{if $layout == 'products_multicolumns'} style="height: {$smarty.capture.abt__ut2_gl_item_height -1}px"{/if}>
        {if $category_banner.url}
        <a{if $category_banner.target_blank === "Y"} target="_blank"{/if} href="{$category_banner.url|fn_url}"{if $category_banner.nofollow === "Y"} rel="nofollow"{/if}>
            {/if}
            {if $layout == 'products_multicolumns'}
                {include file="common/image.tpl" images=$category_banner.main_pair}
            {elseif $layout == 'products_without_options'}
                {include file="common/image.tpl" images=$category_banner.list_pair}
            {elseif $layout == 'short_list'}
                {include file="common/image.tpl" images=$category_banner.short_list_pair}
            {/if}
            {if $category_banner.url}
        </a>
        {/if}
    </div>
{/if}