<div class="litecheckout__group">
    <div class="litecheckout__item litecheckout__item--fill">
        <h2 class="litecheckout__step-title">{$block_title|default:__("lite_checkout.customer_information")}</h2>
    </div>

    {* login popup button *}
    {if !$auth.user_id}
        <div class="litecheckout__item">
            {$return_current_url = $config.current_url|escape:url}

            <a href="{if $runtime.controller == "auth" && $runtime.mode == "login_form"}{$config.current_url|fn_url}{else}{"auth.login_form?return_url=`$return_current_url`"|fn_url}{/if}"
                    data-ca-target-id="litecheckout_login_block"
                    class="cm-dialog-opener cm-dialog-auto-size ty-btn ty-btn__secondary"
                    rel="nofollow"
            >
                {__("sign_in")}
            </a>
        </div>
          <h2 class="litecheckout__step-title">or</h2>
        <div class="litecheckout__item litecheckout__item--center">
            <a
                    class="cm-dialog-opener cm-dialog-auto-size ty-btn ty-btn__secondary"
                    href="{"checkout.update_profile"|fn_url}"
                    data-ca-target-id="create_user_profile"
                    data-ca-dialog-title="{__("create_profile")}"
            >{__("create_profile")}</a>
        </div>
    {else}
        <div class="litecheckout__item litecheckout__item--center">
            <a
                class="cm-dialog-opener cm-dialog-auto-size ty-btn ty-btn__secondary"
                href="{"checkout.update_profile"|fn_url}"
                data-ca-target-id="create_user_profile"
                data-ca-dialog-title="{__("create_profile")}"
            >{__("create_profile")}</a>
        </div>
    {/if}
</div>
<script>
    $(document).ready(function () {
        $('#litecheckout_step_location').find('select').on('change', function() {
            fn_calculate_total_shipping_cost();
            $.ceLiteCheckout('toggleAddress', true);
            $('#shipping_rates_list').removeClass('litecheckout__overlay--active')
        });
        $('[id^=sw_terms_and_conditions]').on('click', function() {
            if($('[id^=terms_and_conditions]').hasClass('hidden')){
                $('[id^=terms_and_conditions]').removeClass('hidden')
            } else {
                $('[id^=terms_and_conditions]').addClass('hidden')
            }

        });
        $('#litecheckout_s_address').unbind('keyup change input paste').bind('keyup change input paste',function(e){
            var $this = $(this);
            var val = $this.val();
            var valLength = val.length;
            var maxCount = 60;
            if(valLength>maxCount){
                $this.val($this.val().substring(0,maxCount));
            }
        });
        $("input[name='payment_info[cvv2]']").unbind('keyup change input paste').bind('keyup change input paste',function(e){
            var $this = $(this);
            var val = $this.val();
            var valLength = val.length;
            var maxCount = 4;
            if(valLength>maxCount){
                $this.val($this.val().substring(0,maxCount));
            }
        });
        $("input[name='payment_info[expiry_month]").unbind('keyup change input paste').bind('keyup change input paste',function(e){
            var $this = $(this);
            var val = $this.val();
            var valLength = val.length;
            var maxCount = 2;
            if(valLength>maxCount){
                $this.val($this.val().substring(0,maxCount));
            }
        });
        $("input[name='payment_info[expiry_year]").unbind('keyup change input paste').bind('keyup change input paste',function(e){
            var $this = $(this);
            var val = $this.val();
            var valLength = val.length;
            var maxCount = 2;
            if(valLength>maxCount){
                $this.val($this.val().substring(0,maxCount));
            }
        });
    });
</script>
