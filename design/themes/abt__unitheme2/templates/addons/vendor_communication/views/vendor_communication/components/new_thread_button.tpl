{$communication_type = "Addons\\VendorCommunication\\CommunicationTypes::VENDOR_TO_CUSTOMER"|enum}
{$allow_new_thread = fn_vendor_communication_is_communication_type_active($communication_type)}
{$title=$title|default:__("vendor_communication.ask_a_question")}

{if $allow_new_thread}
    {if $auth.user_id}
        <a title="{$title}" class="vc__l{if "MULTIVENDOR"|fn_allowed_for} ty-vendor-communication__post-write{/if} cm-dialog-opener cm-dialog-auto-size {$meta}" data-ca-target-id="new_thread_dialog_{$object_id}" rel="nofollow">
            <i class="ut2-icon-outline-announcement"></i>
            <span class="ajx-link">{$title}</span>
        </a>
    {else}
        {assign var="return_current_url" value=$config.current_url|escape:url}
    
        <a title="{$title}" data-ca-target-id="new_thread_login_form" class="vc__l cm-dialog-opener cm-dialog-auto-size{if "MULTIVENDOR"|fn_allowed_for} ty-vendor-communication__post-write{/if}" rel="nofollow">
            <i class="ut2-icon-outline-announcement"></i>
            <span class="ajx-link">{$title}</span>
        </a>
    
        {if $show_form}
            {include file="addons/vendor_communication/views/vendor_communication/components/login_form.tpl"}
        {/if}
    {/if}
{/if}