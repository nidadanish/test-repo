<?php
if (!defined('BOOTSTRAP')) { die('Access denied'); }

fn_register_hooks(
	'update_user_profile_post',
	'post_add_to_cart',
	'delete_cart_product'
);
