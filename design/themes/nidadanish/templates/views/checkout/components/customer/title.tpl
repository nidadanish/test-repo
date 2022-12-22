<div class="litecheckout__group">
    <div class="litecheckout__item litecheckout__item--fill">
        <h2 class="litecheckout__step-title">{$block_title|default:__("lite_checkout.customer_information")}</h2>
    </div>
</div>
{if !$auth.user_id}
<div class="litecheckout__group">

        <div class="litecheckout__item">
            <a id="login_btn" class="ty-btn ty-btn__secondary">
                {__("sign_in")}
            </a>
        </div>
        <h2 class="litecheckout__step-title">or</h2>
        <div class="litecheckout__item litecheckout__item--center">
            <a id="register_btn" class="ty-btn ty-btn__secondary">
                {__("create_profile")}
            </a>
        </div>
</div>

<div id="checkout_login_form" class="litecheckout__group" style="width: 90%">
    <div class="litecheckout__item litecheckout__item--fill">
        <div id="step_one_body" class="ty-step__body-active" style="width: 90%;">
            <div id="step_one_register" class="clearfix hidden">
                <form name="step_one_register_form" class="cm-ajax-full-render " action="{""|fn_url}" method="post">
                    {hook name="checkout:user_register_form"}
                        <input type="hidden" name="result_ids" value="checkout*,account*" />
                        <input type="hidden" name="return_to" value="checkout" />
                        <input type="hidden" name="user_data[register_at_checkout]" value="Y" />
                        <div class="checkout__block">
                            {include file="common/subheader.tpl" title=__("register_new_account")}
                            {include file="views/profiles/components/profiles_account.tpl" nothing_extra="Y" location="checkout"}
                            {include file="views/profiles/components/profile_fields.tpl" section="C" nothing_extra="Y" exclude=["email"]}

                            {hook name="checkout:checkout_steps"}{/hook}

                            {include file="common/image_verification.tpl" option="register"}

                            <div class="clearfix"></div>
                        </div>
                    {/hook}
                    <div class="ty-checkout-buttons clearfix">
                        {include file="buttons/button.tpl" but_meta="ty-btn__secondary" but_name="dispatch[checkout.add_profile]" but_text=__("register")}
                        {include file="buttons/button.tpl" but_onclick="Tygh.$('#step_one_register').hide(); Tygh.$('#step_one_login').show();" but_text=__("cancel") but_role="text" but_meta="ty-checkout__register-cancel"}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<form id="step_one_login" class="cm-processed-form" name="checkout_login_form" action="{fn_url()}" method="post" style="display: none; width: 90%; margin-left: 20px">
    <input type="hidden" name="return_url" value="{fn_url('checkout.checkout')}"/>
    <input type="hidden" name="redirect_url" value="{fn_url('checkout.checkout')}" />
    <div class="ty-checkout-login-form">{include file="common/subheader.tpl" title=__("returning_customer")}
        <div class="ty-control-group">
            <label for="login_{$id}" class="ty-login__filed-label ty-control-group__label cm-required cm-trim cm-email">{__("email")}</label>
            <input type="text" id="login_{$id}" name="user_login" size="30" value="{if $stored_user_login}{$stored_user_login}{else}{$config.demo_username}{/if}" class="ty-login__input cm-focus" />
        </div>

        <div class="ty-control-group ty-password-forgot">
            <label for="psw_{$id}" class="ty-login__filed-label ty-control-group__label ty-password-forgot__label cm-required">{__("password")}</label><a href="{"auth.recover_password"|fn_url}" class="ty-password-forgot__a"  tabindex="5">{__("forgot_password_question")}</a>
            <input type="password" id="psw_{$id}" name="password" size="30" value="{$config.demo_password}" class="ty-login__input" maxlength="32" />
        </div>

        {include file="common/image_verification.tpl" option="login" align="left"}

    </div>

    {hook name="index:login_buttons"}
        <div class="buttons-container clearfix">
            <div class="ty-float-right">
                {include file="buttons/login.tpl" but_name="dispatch[auth.login]" but_role="submit"}
            </div>
            <div class="ty-login__remember-me">
                <label for="remember_me_{$id}" class="ty-login__remember-me-label"><input class="checkbox" type="checkbox" name="remember_me" id="remember_me_{$id}" value="Y" />{__("remember_me")}</label>
            </div>
        </div>
    {/hook}
</form>
{/if}
<script>
    $(document).ready(function () {
        $('#register_btn').on('click', function() {
            $('#step_one_login').css('display','none')
            $('#step_one_register').css('display','block')
        });
        $('#login_btn').on('click', function() {
            $('#step_one_login').css('display','block')
            $('#step_one_register').css('display','none')
        });
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
