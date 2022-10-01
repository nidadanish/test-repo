{if 1}
    {if $payout.payout_type = "VendorPayoutTypes::PAYOUT"|enum && $payout.payout_amount < 0}
        <small class="muted">
            {include file="common/price.tpl" value=$payout.display_amount}
        </small>
    {else}
        {assign var="vendor_profit" value=fn_get_vendor_profit($payout.order_id)}
        <div>
            {__("profit")}: {include file="common/price.tpl" value=$vendor_profit}
        </div>
        <div>
            <small class="muted">
                {__("total")}: {include file="common/price.tpl" value=$payout.display_amount}
            </small>
        </div>
    {/if}
{/if}