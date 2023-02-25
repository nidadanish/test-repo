<p class="muted" style="margin-bottom: 15px;">{__("ab__stickers.output_settings.tooltip")}</p>
{foreach fn_get_schema('ab__stickers', 'display') as $product_template}
<div class="control-group">
<label class="control-label" for="ab__stickers_display_on_{$product_template@key}">{if fn_is_lang_var_exists($product_template@key)}{__($product_template@key)}{else}{$product_template@key}{/if}:</label>
<div class="controls">
{$val = fn_ab__stickers_get_templates_display_size($product_template.display_on, $sticker_data|default:[])}
{if is_array($val)}
{$val = null}
{/if}
<select name="sticker_data{$product_template.display_on}" id="ab__stickers_display_on_{$product_template@key}" style="vertical-align:top">
{foreach ["not_display", "small_size", "full_size"] as $display_size}
<option{if $product_template.prohibited_display_size && in_array($display_size, $product_template.prohibited_display_size)} disabled{/if} value="{$display_size}"{if $val|default:$product_template.default_value == $display_size} selected{/if}>
{__("ab__stickers.output_settings.{$display_size}")}
</option>
{/foreach}
</select>
{if $product_template.prohibited_list_positions}
<ul class="muted description" style="list-style-type:none;margin-left:0">
<li><b style="color:red">{__("warning")}</b>. {__("ab__stickers.list_has_prohibited_positions")}:</li>
{foreach $product_template.prohibited_list_positions as $prohibited_postion}
<li>{__("ab__stickers.output_position.`$prohibited_postion`")}</li>
{/foreach}
<li>{__("ab__stickers.list_has_prohibited_positions.docs")}</li>
</ul>
{/if}
</div>
</div>
{/foreach}