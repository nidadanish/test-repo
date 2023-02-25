{capture name="mainbox"}
{$html_name = "light_menu_content"}
{$html_id = "light_menu_content"}
<form action="{""|fn_url}" enctype="multipart/form-data" method="post" class="form-horizontal form-edit" name="abt__ut2_light_menu_content_form">
<div class="table-responsive-wrapper">
<table class="table table-middle table-responsive">
<thead>
<tr class="first-sibling">
<th width="10%">{__("type")}</th>
<th width="5%">{__("position")}</th>
<th width="25%">{__("abt__ut2.picker")}</th>
<th width="10%">{__("user_class")}</th>
<th width="20%">&nbsp;</th>
</tr>
</thead>
{$num_item = 0}
{foreach $items as $item}
{$num_item = $item.item_id}
<tbody class="hover cm-row-item cm-reload-{$num_item}" id="box_add_item_{$html_id}_{$num_item}">
<tr>
<td data-th="{__("type")}">
<input type="hidden" name="{$html_name}[{$num_item}][item_id]" value="{$item.item_id}">
<input type="hidden" name="{$html_name}[{$num_item}][storefront_id]" value="{$app["storefront"]->storefront_id}">
<select id="{$html_id}_type_{$num_item}" name="{$html_name}[{$num_item}][type]" title="{__("type")}" class="input-medium cm-ab-fm-type-selector" onchange="Tygh.abt__ut2.fm_selector(this)">
<option value="menu"{if $item.type == "menu"} selected{/if}>{__("menu")}</option>
<option value="block"{if $item.type == "block"} selected{/if}>{__("block")}</option>
<option value="delimiter"{if $item.type == "delimiter"} selected{/if}>{__("abt__ut2.lm.delimiter")}</option>
</select>
</td>
<td data-th="{__("position")}">
<input id="{$html_id}_position_{$num_item}" type="text" name="{$html_name}[{$num_item}][position]" value="{$item.position}" title="{__("position")}" size="3" class="input-micro cm-value-integer" />
</td>
<td data-th="{__("abt__ut2.picker")}">
<div class="cm-ab-fm-menu{if $item.type != "menu"} hidden{/if}">
<select id="{$html_id}_menu_{$num_item}" name="{$html_name}[{$num_item}][menu]" title="{__("menu")}" class="input-medium">
<option value="">--- {__('none')} ---</option>
{foreach $menus as $menu}
<option value="{$menu@key}"{if $item.content.menu == $menu@key} selected{/if}>{$menu}</option>
{/foreach}
</select>
<input type="hidden" name="{$html_name}[{$num_item}][state]" value="{"YesNo::NO"|enum}" />
<input id="{$html_id}_states_{$num_item}" type="checkbox" name="{$html_name}[{$num_item}][state]" value="{"YesNo::YES"|enum}"{if $item.content.state == "YesNo::YES"|enum} checked{/if} class="cm-tooltip" title="{__("abt__ut2.menus.pickers.states.tooltip")}" />
</div>
<div class="cm-ab-fm-block{if $item.type != "block"} hidden{/if}">
{include file="common/popupbox.tpl"
act="general"
id="select_block_`$html_id`"
link_class="ab-index-`$num_item`"
text=__("select_block")
link_text=__("select_block")
href="block_manager.block_selection"
action="block_manager.block_selection"
opener_ajax_class="cm-ajax cm-ajax-force"
meta="pull-left"
}
<br><br>
<input type="hidden" name="{$html_name}[{$num_item}][block_id]" value="{$item.block_id}" id="elm_block_{$html_id}_{$num_item}" />
<div id="ajax_update_block_{$html_id}">
{if $item.block_id > 0}
{include file="views/block_manager/render/block.tpl" block_data=$blocks[$item.block_id] external_render=true
external_id=$html_id}
{/if}
<!--ajax_update_block_{$html_id}--></div>
</div>
<div class="cm-ab-fm-delimiter{if $item.type != "delimiter"} hidden{/if}"></div>
</td>
<td data-th="{__("user_class")}">
<input id="{$html_id}_user_class" type="text" name="{$html_name}[{$num_item}][user_class]" title="{__("user_class")}" class="input-large" />
{*{include file="addons/abt__unitheme2/views/abt__ut2/components/display_on_toggler.tpl" id="{$html_id}_user_class"}*}
</td>
<td class="right" data-th="{__("abt__ut2.menus.pickers.states")}">
{include file="buttons/multiple_buttons.tpl" item_id="add_item_`$html_id`" tag_level="1" only_delete="YesNo::YES"|enum}
</td>
</tr>
</tbody>
{/foreach}
{math equation="x + 1" assign="num_item" x=$num_item|default:0}
<tbody class="hover cm-row-item cm-reload-{$num_item}" id="box_add_item_{$html_id}">
<tr>
<td data-th="{__("type")}">
<input type="hidden" name="{$html_name}[{$num_item}][item_id]" value="{$num_item}">
<input type="hidden" name="{$html_name}[{$num_item}][storefront_id]" value="{$app["storefront"]->storefront_id}">
<select id="{$html_id}_type" name="{$html_name}[{$num_item}][type]" title="{__("type")}" class="input-medium cm-ab-fm-type-selector" onload="alert(1)" onchange="Tygh.abt__ut2.fm_selector(this)">
<option value="menu">{__("menu")}</option>
<option value="block">{__("block")}</option>
<option value="delimiter">{__("abt__ut2.lm.delimiter")}</option>
</select>
</td>
<td data-th="{__("position")}">
<input id="{$html_id}_position" type="text" name="{$html_name}[{$num_item}][position]" value="0" title="{__("position")}" size="3" class="input-micro cm-value-integer" />
</td>
<td data-th="{__("abt__ut2.picker")}">
<div class="cm-ab-fm-menu">
<select id="{$html_id}_menu" name="{$html_name}[{$num_item}][menu]" title="{__("menu")}" class="input-medium">
<option value="">--- {__('none')} ---</option>
{foreach $menus as $menu}
<option value="{$menu@key}">{$menu}</option>
{/foreach}
</select>
<input type="hidden" name="{$html_name}[{$num_item}][state]" value="{"YesNo::NO"|enum}" />
<input id="{$html_id}_states" type="checkbox" name="{$html_name}[{$num_item}][state]" value="{"YesNo::YES"|enum}" class="cm-tooltip" title="{__("abt__ut2.menus.pickers.states.tooltip")}" />
</div>
<div class="cm-ab-fm-block hidden">
{include file="common/popupbox.tpl"
act="general"
link_class="ab-index-`$num_item`"
id="select_block_`$html_id`_`$num_item`"
text=__("select_block")
link_text=__("select_block")
href="block_manager.block_selection"
action="block_manager.block_selection"
opener_ajax_class="cm-ajax cm-ajax-force"
meta="pull-left"
}
<br><br>
<input type="hidden" name="{$html_name}[{$num_item}][block_id]" id="elm_block_{$html_id}_{$num_item}" />
<div id="ajax_update_block_{$html_id}_{$num_item}"><!--ajax_update_block_{$html_id}--></div>
</div>
<div class="cm-ab-fm-delimiter hidden"></div>
</td>
<td data-th="{__("user_class")}">
<input id="{$html_id}_user_class" type="text" name="{$html_name}[{$num_item}][user_class]" title="{__("user_class")}" class="input-large" />
{*{include file="addons/abt__unitheme2/views/abt__ut2/components/display_on_toggler.tpl" id="{$html_id}_user_class"}*}
</td>
<td class="right" data-th="{__("abt__ut2.menus.pickers.states")}">
{include file="buttons/multiple_buttons.tpl" item_id="add_item_`$html_id`" tag_level="1"}
</td>
</tr>
</tbody>
</table>
</div>
<script>
(function(_, $) {
$(document).ready(function() {
$(_.doc).on('click', '.cm-remove-block', function(e) {
if (confirm(_.tr('text_are_you_sure_to_proceed')) !== false) {
var parent = $(this).parent();
var block_id = parent.find('input[name="block_id"]').val();
$.ceAjax('request', fn_url('block_manager.block.delete'), {
data: { block_id: block_id },
callback: function() {
parent.remove();
},
method: 'post'
});
}
return false;
});
var counter = 0;
$(_.doc).on('mouseenter', '#content_abt__ut2_light_menu_content_form .cm-dialog-opener', function(e) {
var href = this.getAttribute('href');
if (href.indexOf('&extra_id') === -1) {
this.setAttribute('href', href + '&extra_id=' + counter++);
} else {
href = href.split('&');
href[href.length - 1] = href[href.length - 1].split('=')[0] + '=' + counter++;
this.setAttribute('href', href.join('&'));
}
});
$(_.doc).on('click', '#content_abt__ut2_light_menu_content_form .btn-add, #content_abt__ut2_light_menu_content_form .btn-clone', function(e) {
setTimeout(function(){
$('.cm-ab-fm-type-selector').change();
}, 5);
});
var curr_index = '';
var current_block_id = '';
$(_.doc).on('click', '#content_abt__ut2_light_menu_content_form .cm-dialog-opener', function(e) {
current_block_id = this.id.substr('opener_select_block_'.length);
curr_index = this.className.match(/ab-index-([0-9]+)/)[1];
});
$(_.doc).on('click', '.cm-add-block', function(e) {
var $this = $(this);

var action = $this.prop('class').match(/bm-action-([a-zA-Z0-9-_]+)/)[1];
if (action === 'existing-block') {
var block_id = $this.find('input[name="block_id"]').val();
data = {
block_data: {
block_id: block_id
},
assign_to: 'ajax_update_block_' + current_block_id,
force_close: '1'
};
$.ceAjax('request', fn_url('block_manager.update_block'), {
data: data,
method: 'post',
callback: function(data) {
if (data.id !== undefined) {
$('#elm_block_{$html_id}_' + curr_index).val(data.id);
}
}
});
}
$.ceDialog('get_last').ceDialog('close');
});
});
_.abt__ut2.fm_selector = function(elem) {
var parent = $(elem).parents('.cm-row-item');
parent.find('.cm-ab-fm-menu,.cm-ab-fm-block').addClass('hidden');
parent.find('.cm-ab-fm-' + elem.value).removeClass('hidden');
};
}(Tygh, Tygh.$));
</script>
</form>
{/capture}
{capture name="buttons"}
{include file="buttons/save_cancel.tpl" but_role="submit-link" but_target_form="abt__ut2_light_menu_content_form" but_name="dispatch[abt__ut2.light_menu_content]" save=true}
{/capture}
{include file="addons/ab__addons_manager/views/ab__am/components/menu.tpl" addon="abt__unitheme2"}
{include
file="common/mainbox.tpl"
title_start = __("abt__unitheme2")|truncate:40
title_end = __("abt__ut2.light_menu_content")
content=$smarty.capture.mainbox
buttons=$smarty.capture.buttons
adv_buttons=$smarty.capture.adv_buttons
content_id="abt__ut2_light_menu_content_form"
}