 {if $auth.user_id}
<li class="ty-account-info__item ty-dropdown-box__item"><a class="ty-account-info__a" href="{"wishlist.view"|fn_url}" rel="nofollow">{__("wishlist")}{if $wishlist_count > 0} ({$wishlist_count}){/if}</a></li>
{/if}