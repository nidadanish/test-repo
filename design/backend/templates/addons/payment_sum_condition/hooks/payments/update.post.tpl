<div class="control-group" data-ca-form-group="min_value">
    <label class="control-label" for="elm_payment_min_value_{$id}">{__("addons.payment_sum_condition.min_value")}:</label>
    <div class="controls">
        <input id="elm_payment_min_value_{$id}" type="text" name="payment_data[min_value]" class="input-long cm-numeric" value="{$payment.min_value}" size="8">{$currencies.$primary_currency.symbol nofilter}
        <p class="muted description">{__("addons.payment_sum_condition.min_value.description")}</p>
    </div>
</div>
<div class="control-group" data-ca-form-group="max_value">
    <label class="control-label" for="elm_payment_max_value_{$id}">{__("addons.payment_sum_condition.max_value")}:</label>
    <div class="controls">
        <input id="elm_payment_max_value_{$id}" type="text" name="payment_data[max_value]" class="input-long cm-numeric" value="{$payment.max_value}" size="8">{$currencies.$primary_currency.symbol nofilter}
        <p class="muted description">{__("addons.payment_sum_condition.max_value.description")}</p>
    </div>
</div>