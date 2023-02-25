{strip}
<script data-no-defer>
    (function(_, $) {
        {* Init abt__ut2 - settings, data and functions *}
        $.extend(_, {
            abt__ut2: {
                settings: {$settings.abt__ut2|json_encode nofilter},
                controller : '{$runtime.controller}',
                mode : '{$runtime.mode}',
                device : '{$settings.abt__device}',
                temporary: { },
            }
        });
    }(Tygh, Tygh.$));
</script>
{/strip}
{script src="js/addons/abt__unitheme2/abt__ut2.js"}
{script src="js/addons/abt__unitheme2/abt__ut2_ajax_blocks.js"}
{script src="js/addons/abt__unitheme2/abt__ut2_grid_tabs.js"}
{script src="js/addons/abt__unitheme2/abt__ut2_light_menu.js"}
{script src="js/addons/abt__unitheme2/abt__ut2_youtube.js"}
{script src="js/addons/abt__unitheme2/abt__ut2_load_more.js"}
{script src="js/addons/abt__unitheme2/abt__ut2_custom_combination.js"}
{script src="js/addons/abt__unitheme2/abt__ut2_discussion.js"}

{*{if $settings.abt__ut2.general.lazy_load === "YesNo::YES"|enum}*}
{*    {script src="js/addons/abt__unitheme2/abt__ut2_lazy_load.js"}*}
{*{/if}*}

{if $settings.abt__ut2.category.use_swipe_to_close_filters.{$settings.abt__device} == "YesNo::YES"|enum}
    {script src="js/addons/abt__unitheme2/abt__ut2_swipe_menu.js"}
{/if}

{if $addons.product_variations.status == "A" && $settings.abt__ut2.general.change_main_image_on_variation_hover.{$settings.abt__device} == "YesNo::YES"|enum}
    {script src="js/addons/abt__unitheme2/abt__ut2_variation_images.js"}
{/if}


{if $settings.abt__ut2.general.push_history_on_popups.{$settings.abt__device} === "YesNo::YES"|enum}
    {script src="js/addons/abt__unitheme2/abt__ut2_history_on_popups.js"}
{/if}