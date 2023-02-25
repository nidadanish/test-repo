{** block-description:block_vendor_information **}

<div class="ty-vendor-information">

    <div class="ut2-vendor-name"><a href="{"companies.view?company_id=`$vendor_info.company_id`"|fn_url}">{$vendor_info.company}</a></div>
    
    {if $settings.abt__ut2.vendor.truncate_short_description[$settings.abt__device] != "0"}
    	<p>{$vendor_info.company_description|strip_tags|truncate:$settings.abt__ut2.vendor.truncate_short_description[$settings.abt__device]:"...":true nofilter}</p>
    {/if}
    
    <p><a href="{"companies.view?company_id=`$vendor_info.company_id`"|fn_url}" class="ty-btn" rel="nofollow">{__("extra")}</a></p>
    
    {if "MULTIVENDOR"|fn_allowed_for && $settings.abt__ut2.vendor.show_ask_question_link[$settings.abt__device] == "Y" && $addons.vendor_communication.show_on_vendor == "Y"}
	    <div class="vendor_communication-btn">
	    {include file="addons/vendor_communication/views/vendor_communication/components/new_thread_button.tpl" object_id=$company_id show_form=true}
		</div>
		
	    {include
	        file="addons/vendor_communication/views/vendor_communication/components/new_thread_form.tpl"
	        object_type=$smarty.const.VC_OBJECT_TYPE_COMPANY
	        object_id=$company_id
	        company_id=$company_id
	        vendor_name=$company_id|fn_get_company_name
	    }
	{/if}
</div>
