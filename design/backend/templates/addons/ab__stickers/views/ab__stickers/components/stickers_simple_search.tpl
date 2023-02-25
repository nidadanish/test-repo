<div class="sidebar-field">
<label for="ab_stickers_admin_name">{__("name")}</label>
<div class="break">
<input type="text" name="name_for_admin" id="ab_stickers_admin_name" value="{$search.name_for_admin}" size="30" class="search-input-text" />
</div>
</div>
<div class="sidebar-field">
<label for="ab__stickers_style">{__("ab__stickers.style")}</label>
<div class="break">
<select name="styles[]" id="ab__stickers_style">
<option value="">- {__("all")} -</option>
{foreach fn_ab__stickers_get_enum_list() as $style}
<option value="{$style}"{if $search.styles[0] == $style} selected{/if}>{__("ab__stickers.style.$style")}</option>
{/foreach}
</select>
</div>
</div>
<div class="sidebar-field">
<label for="ab__stickers_type">{__("ab__stickers.params.type")}</label>
<select name="type" id="ab__stickers_type">
<option value=" ">- {__('ab__stickers.params.type.A')} -</option>
{foreach fn_ab__stickers_get_enum_list("StickerTypes") as $type}
<option value="{$type}"{if $search.type == $type} selected{/if}>{__("ab__stickers.params.type.`$type`")}</option>
{/foreach}
</select>
</div>
<h6 style="margin: 15px 0 5px; font-size: 14px">{__("ab__stickers.output_positions")}</h6>
<div class="sidebar-field">
<label for="ab__stickers_output_position_list">{__("ab__stickers.output_position.list")}</label>
<select name="output_position_list" id="ab__stickers_output_position_list">
<option value=" ">- {__('ab__stickers.output_position.AP')} -</option>
{foreach fn_ab__stickers_get_enum_list("OutputPositions") as $output_position}
<option value="{$output_position}"{if $search.output_position_list == $output_position} selected{/if}>{__("ab__stickers.output_position.`$output_position`")}</option>
{/foreach}
</select>
</div>
<div class="sidebar-field">
<label for="ab__stickers_output_position_detailed_page">{__("ab__stickers.output_position.detailed_page")}</label>
<select name="output_position_detailed_page" id="ab__stickers_output_position_detailed_page">
<option value=" ">- {__('ab__stickers.output_position.AP')} -</option>
{foreach fn_ab__stickers_get_enum_list('OutputPositions') as $output_position}
<option value="{$output_position}"{if $search.detailed_page == $output_position} selected{/if}>{__("ab__stickers.output_position.`$output_position`")}</option>
{/foreach}
</select>
</div>