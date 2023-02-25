{foreach $product_features as $feature}
    {if $feature.feature_type != "ProductFeatures::GROUP"|enum}
        <div class="ty-product-feature">
        <div class="ty-product-feature__label"><span>{$feature.description nofilter}{if $feature.full_description|trim}{if $settings.abt__ut2.products.view.show_features_in_two_col[$settings.abt__device] != 'Y'}{include file="common/help.tpl" text=$feature.description content=$feature.full_description id=$feature.feature_id show_brackets=false link_text="<span class=\"ty-tooltip-block\"><i class=\"ty-icon-help-circle\"></i></span>" wysiwyg=true}{else} <span class="ty-tooltip-block cm-tooltip" title="{$feature.full_description}"><i class="ty-icon-help-circle"></i></span>{/if}{/if}:</span></div>

        {$hide_affix = $feature.feature_type == "ProductFeatures::MULTIPLE_CHECKBOX"|enum}

        {strip}
        <div class="ty-product-feature__value">
            {if $feature.prefix && !$hide_affix}<span class="ty-product-feature__prefix">{$feature.prefix}</span>{/if}
            {if $feature.feature_type == "ProductFeatures::SINGLE_CHECKBOX"|enum}
                {include file="views/products/components/ab__similar_filter.tpl" feature=$feature variant_id="Y"}
            {if $feature.value === "YesNo::YES"|enum}{hook name="abt__ut2_features:variant"}{__("yes")}{/hook}{else}{__("no")}{/if}
{*            <span class="ty-compare-checkbox">{if $feature.value === "YesNo::YES"|enum}<i class="ty-compare-checkbox__icon ty-icon-ok"></i>{/if}</span>*}
            {elseif $feature.feature_type == "ProductFeatures::DATE"|enum}
                {$feature.value_int|date_format:"`$settings.Appearance.date_format`"}
            {elseif $feature.feature_type == "ProductFeatures::MULTIPLE_CHECKBOX"|enum && $feature.variants}
                <ul class="ty-product-feature__multiple {if $ab__search_similar_in_category && $feature.filter_id}abt__ut2_checkboxes{/if}">
                {foreach from=$feature.variants item="var" name="foo"}
                    {$hide_variant_affix = !$hide_affix}
                    {if $var.selected}<li class="ty-product-feature__multiple-item">{include file="views/products/components/ab__similar_filter.tpl" feature=$feature variant_id=$var.variant_id}{if !$hide_variant_affix}<span class="ty-product-feature__prefix">{$feature.prefix}</span>{/if}
                        {hook name="abt__ut2_features:variant"}
                            {$var.variant}
                        {/hook}
                        {if !$hide_variant_affix}{if !$smarty.foreach.foo.last}{if !$feature.filter_id},{/if}{/if}<span class="ty-product-feature__suffix">{$feature.suffix}</span>{/if}</li>{/if}
                {/foreach}
                </ul>
            {elseif in_array($feature.feature_type, ["ProductFeatures::TEXT_SELECTBOX"|enum, "ProductFeatures::EXTENDED"|enum, "ProductFeatures::NUMBER_SELECTBOX"|enum])}
                {foreach from=$feature.variants item="var"}
                    {if $var.selected}
                        {$filter_value=$var.variant_id}
                        {if $feature.filter_style=="slider"}
                            {$filter_value="`$var.variant`-`$var.variant`"}
                        {/if}
                        {include file="views/products/components/ab__similar_filter.tpl" feature=$feature variant_id=$filter_value}
                        {if $feature.filter_style == "ProductFilterStyles::COLOR"|enum && $var.color}<div class="abt__ut2_color_mark" style="background-color: {$var.color};width:15px;height:15px;display:inline-block;margin-right:5px;margin-top:-2px;border-radius: 50%;{if $var.color == "#ffffff"}border: 1px solid{/if}"></div>{/if}{hook name="abt__ut2_features:variant"}{$var.variant}{/hook}{/if}
                {/foreach}
            {elseif $feature.feature_type == "ProductFeatures::NUMBER_FIELD"|enum}
                {$feature.value_int|floatval|default:"-"}
            {else}
                {$feature.value|default:"-"}
            {/if}
            {if $feature.suffix && !$hide_affix}<span class="ty-product-feature__suffix">{$feature.suffix}</span>{/if}
        </div>
        {/strip}
        </div>
    {/if}
{/foreach}

{foreach $product_features as $feature}
    {if $feature.feature_type == "ProductFeatures::GROUP"|enum && $feature.subfeatures}
        <div class="ty-product-feature-group">
        {include file="common/subheader.tpl" title=$feature.description tooltip=$feature.full_description text=$feature.description}
        {include file="views/products/components/product_features.tpl" product_features=$feature.subfeatures}
        </div>
    {/if}
{/foreach}
