{if ($product.discount_prc || $product.list_discount_prc) && $show_price_values}
    {if $product.discount}
        {$label_text = "{__("save_discount")} <em>{$product.discount_prc}%</em>"}
    {else}
        {$label_text = "{__("save_discount")} <em>{$product.list_discount_prc}%</em>"}
    {/if}

    {include "views/products/components/product_label.tpl"
        label_meta    = "ty-product-labels__item--discount"
        label_text    = $label_text
        label_mini    = $product_labels_mini
        label_static  = $product_labels_static
        label_rounded = $product_labels_rounded
    }
{/if}