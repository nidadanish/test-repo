{if $payout.payout_type = "VendorPayoutTypes::PAYOUT"|enum && $payout.payout_amount < 0}
    <small class="muted">
        {include file="common/price.tpl" value=$payout.display_amount}
    </small>
{else}
    {if $runtime.company_id == 0}
        {assign var="vendor_profit" value=fn_get_vendor_profit($payout.order_id)}
        {assign var="order_info" value=fn_get_order_info($payout.order_id)}
        <div>
            {__("profit")}: {include file="common/price.tpl" value=$vendor_profit}
        </div>
        <div>
            <small class="muted">
                {__("total")}: {include file="common/price.tpl" value=$order_info.total}
            </small>
        </div>
    {else}
        <div>
            {assign var="vendor_total" value=fn_get_vendor_order_product_total($payout.order_id)}
            {__("total")}: {include file="common/price.tpl" value=$vendor_total}
        </div>
    {/if}
{/if}