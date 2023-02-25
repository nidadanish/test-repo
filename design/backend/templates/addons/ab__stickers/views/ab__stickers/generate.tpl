{capture name="mainbox"}
<form action="{""|fn_url}" method="post" name="ab__stickers_generation_form" id="ab__stickers_generation_form">
<div id="content_ab__s_generate_links">
{$seconds = 5 * ($app['storefront']->storefront_id % 12)}
{$cron_cmd = "`$seconds` 1 * * * php `$config.dir.root`/`$config.admin_index` --dispatch=ab__stickers.cron"}
{if "ULTIMATE"|fn_allowed_for}
{$company_id=fn_get_runtime_company_id()}
{$cron_cmd = "`$cron_cmd` --switch_company_id=`$company_id`"}
{else}
{$cron_cmd = "`$cron_cmd` --storefront_id=`$app['storefront']->storefront_id`"}
{/if}
{include file="common/widget_copy.tpl" widget_copy_title=__("ab__stickers.generate") widget_copy_text=__("ab__stickers.generation.description") widget_copy_code_text=$cron_cmd}
<div class="table-responsive-wrapper">
<table class="table table-middle table-responsive" width="100%">
<thead>
<tr>
<th width="80%">{__("description")}</th>
<th width="20%" style="text-align: center">{__("action")}</th>
</tr>
</thead>
<tbody>
<tr>
<td data-th="{__('description')}">
{__('ab__stickers.generate.generated_ids.description', [2])}
</td>
<td data-th="{__('action')}" style="text-align: center;">
{include file="buttons/button.tpl" but_href="ab__stickers.generate?storefront_ids=`$app['storefront']->storefront_id`"|fn_url but_text=__("generate") but_role="action" but_meta="cm-ajax cm-post cm-comet"}
</td>
</tr>
</tbody>
</table>
</div>
</div>
</form>
{/capture}
{include file="addons/ab__addons_manager/views/ab__am/components/menu.tpl" addon="ab__stickers"}
{include file="common/mainbox.tpl"
title_start = __("ab__stickers")|truncate:40
title_end = __("ab__stickers.link_generation")
content=$smarty.capture.mainbox
buttons=$smarty.capture.buttons
select_storefront=true
show_all_storefront=false
adv_buttons=$smarty.capture.adv_buttons
content_id="ab__stickers_generation_form"}