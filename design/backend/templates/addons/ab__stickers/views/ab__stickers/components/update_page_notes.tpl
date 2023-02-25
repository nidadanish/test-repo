{strip}
<div class="sidebar-row">
<h6>{__("ab__stickers.available_placeholders.header")}</h6>
<p class="muted" style="word-break: break-word;">{__("ab__stickers.available_placeholders")}</p>
{__("ab__stickers.default_placeholders")}
{$showed = []}
{foreach $sticker_data.conditions.conditions as $condition}
{$condition_schema = $schema.conditions[$condition.condition]}
{foreach $condition_schema.available_placeholders as $placeholder}
{if !in_array($placeholder@key, $showed)}
{$showed[] = $placeholder@key}
<p><code>{$placeholder@key}</code> - {__($placeholder.title)}</p>
{/if}
{/foreach}
{/foreach}
{capture name="available_tags"}
<br/>
{foreach fn_ab__stickers_get_available_tags() as $tag}
<code>{$tag}</code>{if !$tag@last},{else}<br/><br/>{/if}
{/foreach}
{/capture}
<h6>{__("ab__stickers.available_tags.header")}</h6>
<p class="muted" style="word-break: break-word;">{__("ab__stickers.available_tags")}</p>
{__("ab__stickers.available_tags.content", [
"[available_tags]" => $smarty.capture.available_tags,
"[href_demo]" => "ab__stickers.demodata"|fn_url
])}
</div>
{/strip}