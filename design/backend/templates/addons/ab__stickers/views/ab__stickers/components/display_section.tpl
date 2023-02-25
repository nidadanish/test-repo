{include file="common/subheader.tpl" title=__("ab__stickers.output_position.{$pos}") target="#sticker_output_positions_{$pos}"}
<div id="sticker_output_positions_{$pos}" class="in collapse">
{*<div class="control-group">*}
{*<label for="ab__stickers_display_on_{$pos}s" class="control-label">{__("ab__stickers.show")}:</label>*}
{*<div class="controls">*}
{*{$var = "display_on_{$pos}s"}*}
{*<input type="hidden" name="sticker_data[{$var}]" value="N">*}
{*<input id="ab__stickers_display_on_{$pos}s" type="checkbox" name="sticker_data[{$var}]"{if $sticker_data.$var|default:"Y" == "Y"} checked{/if} value="Y">*}
{*</div>*}
{*</div>*}
{*{if $pos == "list"}*}
{*<div class="control-group">*}
{*<label for="ab__stickers_display_on_small_{$pos}s" class="control-label">{__("ab__stickers.show.small")}{include file="common/tooltip.tpl" tooltip=__("ab__stickers.show.small.tooltip")}:</label>*}
{*<div class="controls">*}
{*{$var = "display_on_small_{$pos}s"}*}
{*<input type="hidden" name="sticker_data[{$var}]" value="N">*}
{*<input id="ab__stickers_display_on_small_{$pos}s" type="checkbox" name="sticker_data[{$var}]"{if $sticker_data.$var|default:"Y" == "Y"} checked{/if} value="Y">*}
{*</div>*}
{*</div>*}
{*{/if}*}
<div class="control-group">
<label class="control-label" for="ab__stickers_output_position_{$pos}">{__("ab__stickers.output_position.{$pos}")}:</label>
<div class="controls">
<select name="sticker_data[output_position_{$pos}]" id="ab__stickers_output_position_{$pos}">
{foreach fn_ab__stickers_get_enum_list('OutputPositions') as $output_position}
<option value="{$output_position}"{if $sticker_data.{"output_position_`$pos`"} == $output_position} selected{/if}>{__("ab__stickers.output_position.`$output_position`")}</option>
{/foreach}
</select>
</div>
</div>
<div class="control-group">
<label class="control-label" for="ab__stickers_{$pos}_class">{__("ab__stickers.params.class")}:</label>
<div class="controls">
<input id="ab__stickers_{$pos}_class" type="text" name="sticker_data[appearance][{$pos}][user_class]" value="{$sticker_data.appearance.{$pos}.user_class}">
</div>
</div>
<div class="control-group">
<label class="control-label" for="ab__stickers_{$pos}_display_on">{__("block_manager.availability.show_on")}:</label>
{include file="addons/ab__stickers/views/ab__stickers/components/display_on_toggler.tpl" place=$pos name="ab__stickers_`$pos`_display_on"}
</div>
<hr/>
</div>