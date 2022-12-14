{$id = 0}
{if $destination}
    {$id = $destination.destination_id}
{/if}

{capture name="mainbox"}

    {capture name="tabsbox"}

        <form action="{""|fn_url}"
              enctype="multipart/form-data"
              method="post"
              name="destinations_form"
              class="form-horizontal form-edit {if ""|fn_check_form_permissions} cm-hide-inputs{/if}"
        >
            <div class="hidden" id="content_detailed">
                <input type="hidden" name="destination_id" value="{$id}" />
                <input type="hidden" name="selected_section" id="selected_section" value="{$smarty.request.selected_section}" />

                {hook name="destinations:update_name"}
                    <div class="control-group">
                        <label for="elm_destination_name" class="control-label cm-required">{__("name")}:</label>
                        <div class="controls">
                            <input type="text"
                                   name="destination_data[destination]"
                                   id="elm_destination_name"
                                   size="25"
                                   value="{$destination.destination}"
                                   class="input-large"
                            />
                        </div>
                    </div>
                {/hook}

                {include file="views/localizations/components/select.tpl"
                    data_name="destination_data[localization]"
                    data_from=$destination.localization
                }

                {include file="common/select_status.tpl"
                    input_name="destination_data[status]"
                    id="elm_destination_status"
                    obj=$destination
                }

                {hook name="destinations:ec_all_selectors"}
                {* Countries list *}
                {include file="common/double_selectboxes.tpl"
                    title=__("countries")
                    first_name="destination_data[countries]"
                    first_data=$destination_data.countries
                    second_name="all_countries"
                    second_data=$countries
                    class_name="destination-countries"
                }

                {* States list *}
                {include file="common/double_selectboxes.tpl"
                    title=__("states")
                    first_name="destination_data[states]"
                    first_data=$destination_data.states
                    second_name="all_states"
                    second_data=$states
                    class_name="destination-states"
                }

                
                {* Cities list *}
                {include file="common/double_selectboxes.tpl"
                    title=__("cities")
                    first_name="destination_data[cities]"
                    first_data=$destination_data.cities
                    second_name="all_cities"
                    second_data=$cities
                    class_name="destination_cities"
                }
                 {* Districts list *}
                {include file="common/double_selectboxes.tpl"
                    title=__("ec_districts")
                    first_name="destination_data[districts]"
                    first_data=$destination_data.districts
                    second_name="all_districts"
                    second_data=$districts
                    class_name="destination_districts"
                }

                {hook name="destinations:ec_extra_type"}{/hook}
                {/hook}
                {* {include file="common/subheader.tpl" title=__("cities")}
                <div class="table-wrapper">
                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                    <tr>
                        <td width="48%">
                            <textarea name="destination_data[cities]"
                                      id="elm_destination_cities"
                                      rows="8"
                                      class="input-full"
                            >{$destination_data.cities}</textarea>
                        </td>
                        <td>&nbsp;</td>
                        <td width="48%">{__("text_cities_wildcards")}</td>
                    </tr>
                    </table>
                </div> *}

                {* Addresses list *}
                {include file="common/subheader.tpl" title=__("addresses")}
                <div class="table-wrapper">
                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                    <tr>
                        <td width="48%">
                            <textarea name="destination_data[addresses]"
                                      id="elm_destination_cities"
                                      rows="8"
                                      class="input-full"
                            >{$destination_data.addresses}</textarea>
                        </td>
                        <td>&nbsp;</td>
                        <td width="48%">{__("text_addresses_wildcards")}</td>
                    </tr>
                    </table>
                </div>
            </div>
            {* Zipcodes list *}
            {include file="common/subheader.tpl" title=__("zipcodes")}
            <div class="table-wrapper">
                <table width="100%">
                <tr>
                    <td width="48%">
                        <textarea name="destination_data[zipcodes]"
                                    id="elm_destination_zipcodes"
                                    rows="8"
                                    class="input-full"
                        >{$destination_data.zipcodes}</textarea>
                    </td>
                    <td>&nbsp;</td>
                    <td width="48%">{__("text_zipcodes_wildcards")}</td>
                </tr>
                </table>
            </div>

            
            {hook name="destinations:tabs_content"}{/hook}

            {capture name="buttons"}
                {include file="buttons/save_cancel.tpl"
                    but_name="dispatch[destinations.update]"
                    but_target_form="destinations_form"
                    save=$id
                }
            {/capture}

        </form>

        {hook name="destinations:tabs_extra"}{/hook}

    {/capture}

    {include file="common/tabsbox.tpl"
        content=$smarty.capture.tabsbox
        group_name=$runtime.controller
        active_tab=$smarty.request.selected_section
        track=true
    }
{/capture}

{$title = __("new_rate_area")}
{if $id}
    {$title_start = __("editing_rate_area")}
    {$title_end = $destination.destination}
{/if}

{include file="common/mainbox.tpl"
    title_start=$title_start
    title_end=$title_end
    title=$title
    content=$smarty.capture.mainbox
    buttons=$smarty.capture.buttons
    select_languages=true
}
