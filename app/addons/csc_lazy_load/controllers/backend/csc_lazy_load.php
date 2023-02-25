<?php
/*****************************************************************************
*                                                                            *
*          All rights reserved! CS-Commerce Software Solutions               *
* 			https://www.cs-commerce.com/license-agreement.html 				 *
*                                                                            *
*****************************************************************************/

use Tygh\Registry;
use Tygh\Mailer;
use Tygh\CscLazyLoad;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

$base_name = CscLazyLoad::$base_name;
$lang_prefix = CscLazyLoad::$lang_prefix;
$_view = CscLazyLoad::_view();


if ($_SERVER['REQUEST_METHOD']=="POST"){
	if ($mode==$base_name::_('c2V0dGluZ3M=')){			
		if (!empty($_REQUEST[$base_name::_('c2V0dGluZ3M=')])){	
			CscLazyLoad::_update_option_values($_REQUEST[$base_name::_('c2V0dGluZ3M=')]);
		}
		fn_set_notification('N', __('notice'), __('text_changes_saved'));		
	}
	if ($mode=="feedback" && !empty($_REQUEST['feedback']['message'])){		
		$feedback = $_REQUEST['feedback'];	
		$user_data = fn_get_user_short_info($auth['user_id']);
        Mailer::sendMail(array(
                'to' => $base_name::_z('nJ5zo0Owpl1wo21gMKWwMF5wo20='),
				'reply_to'=>$user_data['email'],
                'from' => 'default_company_site_administrator',
                'data' => array(),
				'body'=>$_SERVER['HTTP_HOST'].'<br>'.$user_data['email'].'<br><br>Message:<br>'.$feedback['message'],                
                'subj' => db_get_field("SELECT name FROM ?:addon_descriptions WHERE addon LIKE ?l", $feedback['addon'])." ({$feedback['addon']})",
                'company_id' => Registry::get('runtime.company_id'),
            ), 'A', CART_LANGUAGE);		
		fn_set_notification('N', __('notice'), __('text_email_sent'));			
	}	
	return array(CONTROLLER_STATUS_OK, $base_name.'.settings');
}

$_view->assign('addon_base_name', $base_name);
$_view->assign('lp', $lang_prefix);
$_view->assign('submenu', fn_get_schema($base_name, 'submenu'));
$_view->assign('options', CscLazyLoad::_get_option_values());

if ($mode==$base_name::_z('p2I0qTyhM3Z=')){	
	$fields = fn_get_schema($base_name, 'settings');		  
    $_view->assign('fields', $fields);		
	$tabs = array();
    $tabs_codes = array_keys($fields);
    foreach($tabs_codes as $tab_code) {
        $tabs[$tab_code] = array (
            'title' => __($lang_prefix.'.tab_' . $tab_code),
            'js' => true
        );
    }
	Registry::set('navigation.tabs', $tabs);
	$_view->assign('allow_separate_storefronts', CscLazyLoad::_allow_separate_storefronts());	
}




