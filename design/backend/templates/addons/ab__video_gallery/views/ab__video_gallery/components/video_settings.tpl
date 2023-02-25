{$href_type = "Tygh\Enum\Addons\Ab_videoGallery\VideoTypes::HREF"|constant}
<tbody class="cm-row-item" id="box_{if $new}add{else}{$key}{/if}_ab__vg_video">
{if $new}
{$hook = "videos_list_clone"}
{else}
{$hook = "videos_list_body"}
{/if}
{hook name="ab__video_gallery:`$hook`"}
<td width="2%">
<span id="on_ab__vg_video_extra_{$key}" title="{__("expand_collapse_list")}" class="hand hidden cm-combination-video_extra"><span class="exicon-expand"></span></span>
<span id="off_ab__vg_video_extra_{$key}" title="{__("expand_collapse_list")}" class="hand cm-combination-video_extra"><span class="exicon-collapse"></span></span>
</td>
<td>
<input type="hidden" name="product_data[ab__vg_videos][{$key}][video_id]"{if !$new} value="{$video.video_id}"{/if} />
<input title="{__("ab__vg.form.pos")}" type="text" name="product_data[ab__vg_videos][{$key}][pos]"{if !$new} value="{$video.pos}"{/if} class="input-micro" />
</td>
<td>
<input title="{__("ab__vg.form.title")}" type="text" name="product_data[ab__vg_videos][{$key}][title]"{if !$new} value="{$video.title}"{/if} class="input-large" />
</td>
<td>
{if !$new}
<input type="hidden" name="product_data[ab__vg_videos][{$key}][type]" value="{$video.type}">
{/if}
<select{if !$new} disabled{/if} title="{__("ab__vg.form.type")}" name="product_data[ab__vg_videos][{$key}][type]" onchange="Tygh.ab__vg.change_required_fields({$key}, this.value)">
{foreach fn_ab__video_gallery_get_enum_list("VideoTypes") as $type}
<option value="{$type}"{if $video.type == $type} selected{/if}{if fn_is_lang_var_exists("ab__vg.form.type.`$type`.descr")} title="{__("ab__vg.form.type.`$type`.descr")}"{/if}>{__("ab__vg.form.type.`$type`")}</option>
{/foreach}
</select>
</td>
<td>
{if $new}
{include file="common/select_status.tpl" input_name="product_data[ab__vg_videos][{$new_key}][status]" id="ab__vg_status_`$new_key`" hidden=false display="popup"}
{else}
{include file="common/select_popup.tpl" popup_additional_class="dropleft" id=$video.video_id status=$video.status hidden=false object_id_name="video_id" table="ab__video_gallery"}
{/if}
</td>
{/hook}
<td class="nowrap right">
{if $new}
{include file="buttons/multiple_buttons.tpl" item_id="add_ab__vg_video" on_add="fn_ab__vg_remove_required_from_new()"}
{else}
{include file="buttons/clone_delete.tpl" microformats="cm-delete-row" no_confirm=true}
{/if}
</td>
</tr>
<tr class="cr-table-detail" id="ab__vg_video_extra_{$key}">
<td colspan="6">
<div class="control-group">
<label class="control-label{if !$new} cm-required{/if} cm-ab-vg-required" for="ab__vg__video_path__{$key}">{__("ab__vg.form.video_path")}:</label>
<div class="controls">
<input type="text" name="product_data[ab__vg_videos][{$key}][video_path]" id="ab__vg__video_path__{$key}" size="55" value="{$video.video_path}" />
<p class="description muted">{__("ab__vg.form.video_path.tooltip")}</p>
</div>
</div>
<div class="control-group" id="ab__vg__icon_type__{$key}">
<label class="control-label" for="ab__vg__icon_type__{$key}">{__("ab__vg.form.icon_type")}:</label>
<div class="controls">
<label class="radio inline" for="ab__vg__icon_type__{$key}__snapshot"><input type="radio" name="product_data[ab__vg_videos][{$key}][icon_type]" id="ab__vg__icon_type__{$key}__snapshot"{if $video.icon_type == 'snapshot'} checked="checked"{/if}{if $video.type == $href_type} disabled{/if} value="snapshot" />{__("ab__vg.form.icon_type.snapshot")}</label>
<label class="radio inline" for="ab__vg__icon_type__{$key}__icon"><input type="radio" name="product_data[ab__vg_videos][{$key}][icon_type]" id="ab__vg__icon_type__{$key}__icon"{if $video.icon_type == 'icon'} checked="checked"{/if} value="icon" />{__("ab__vg.form.icon_type.icon")}</label>
</div>
</div>
<div class="control-group">
<label class="control-label" for="ab__vg__icon__{$key}">{__("ab__vg.form.icon")}</label>
<div class="controls">
{include file="common/attach_images.tpl" image_name="video_icon" image_object_type="ab__vg_video" image_key=$key image_pair=$video.icon no_detailed=true hide_titles=true}
</div>
</div>
<div class="control-group">
<label class="control-label" for="ab__vg__description__{$key}">{__("ab__vg.form.description")}:</label>
<div class="controls">
<textarea id="ab__vg__description__{$key}" name="product_data[ab__vg_videos][{$key}][description]" cols="55" rows="8" class="cm-wysiwyg">{$video.description}</textarea>
</div>
</div>
<div class="control-group">
<div class="controls">
<input type="hidden" name="product_data[ab__vg_videos][{$key}][settings][]">
{if $new}
{foreach fn_ab__video_gallery_get_enum_list("VideoTypes") as $type}
<div id="ab__vg_video_settings_{$key}_{$type}_wrapper" class="cm-ab-video-settings-wrapper{if !$type@first} hidden{/if}">
{include file="addons/ab__video_gallery/views/ab__video_gallery/components/`$type`_settings.tpl"}
</div>
{/foreach}
{else}
{include file="addons/ab__video_gallery/views/ab__video_gallery/components/`$video.type`_settings.tpl"}
{/if}
</div>
</div>
{hook name="ab__video_gallery:video_extended_data"}{/hook}
</td>
</tr>
</tbody>