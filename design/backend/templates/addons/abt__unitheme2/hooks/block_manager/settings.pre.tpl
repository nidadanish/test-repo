{if $runtime.layout.theme_name == 'abt__unitheme2'}
<div id="abt__ut2_block_settings_{$elm_id}">
<div class="abt-ut2-doc">{__('abt__ut2.block.availability.show_on',
['[show_on]' => "{__("block_manager.availability.show_on")}: {__("block_manager.availability.phone")}/{__("block_manager.availability.tablet")}/{__("block_manager.availability.desktop")}"])}</div>
<input type="hidden" name="block_data[properties][abt__ut2_demo_block_id]" value="{$block.properties.abt__ut2_demo_block_id}" />
</div>
{/if}