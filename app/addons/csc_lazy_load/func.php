<?php
/*****************************************************************************
*                                                                            *
*          All rights reserved! CS-Commerce Software Solutions               *
* 			http://www.cs-commerce.com/license-agreement.html 				 *
*                                                                            *
*****************************************************************************/
use Tygh\Registry;
use Tygh\CscLazyLoad;
if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_csc_lazy_load_install(){
	/*Privilages*/
	if (version_compare(PRODUCT_VERSION, '4.10.1', '<')){
		db_query("REPLACE INTO ?:privileges (privilege, is_default, section_id) VALUES ('manage_csc_lazy_load', 'N', 'addons')");
		db_query("REPLACE INTO ?:privileges (privilege, is_default, section_id) VALUES ('view_csc_lazy_load', 'N', 'addons')");
	}else{
		db_query("REPLACE INTO ?:privileges (privilege, is_default, section_id, group_id, is_view) VALUES ('manage_csc_lazy_load', 'N', 'addons', 'csc_lazy_load', 'N')");
		db_query("REPLACE INTO ?:privileges (privilege, is_default, section_id, group_id, is_view) VALUES ('view_csc_lazy_load', 'N', 'addons', 'csc_lazy_load', 'Y')");		
	}
}

function fn_csc_lazy_load_uninstall(){	
	/*Privilages*/
	db_query("DELETE FROM ?:privileges WHERE privilege IN ('manage_csc_lazy_load', 'view_csc_lazy_load')");
}


function fn_csc_lazy_load_render_block_post($block, $block_schema, &$block_content, $load_block_from_cache, $display_this_block,  $params){
	if (AREA!='C'){
		return;	
	}		
	$block_content = csc_lazy_load::_zxev("WTWfo2AeVQ0tWTSlM1fkKGfAPtxxLzkiL2gsp2AbMJ1uVQ0tWTSlM1flKGfAPtxxLzkiL2gsL29hqTIhqPN9VPEupzqo!107QDbWWTkiLJEsLzkiL2gsM,WioI9wLJAbMFN9VPEupzqoAS07QDbWWTEcp3OfLKysqTucp19#oT9wnlN9VPEupzqoAI07QDbWWUOupzSgplN9VPEupzqoAy07QDbWQDbWWUAyqUEcozqmVQ0tIUy,nSkQp2A!LKc5GT9uMQb6K2qyqS9ipUEco25sqzSfqJImXPx7QDbWnJLtXPExnKAjoTS5K3EbnKAsLzkiL2ftCG0tqUW1MFNzW#OmqUWjo3!bWTWfo2AeJlq1p2IlK2AfLKAmW10fVPqwp2!goz8goTS6rFpcCG09MzSfp2HcVUfWPD0XPDycM#NbWUAyqUEcozqmJlqfLKc5K2ygLJqyplqqCG0#JFVcrjxAPtxWPJyzVPtuMJ1jqUxbWTWfo2AeJlq0rKOyW10cXKfAPtxWPDycM#NbQDbWPDxWPFtuMJ1jqUxbWUAyqUEcozqmJlE#oT9wn1f,qUyjMFqqKFxtW#LtWUAyqUEcozqmJlE#oT9wn1f,qUyjMFqqKG09Vyx#XFO8sPNAPtxWPDxWXTIgpUE5XPEmMKE0nJ5,p1fxLzkiL2goW3E5pTH,KI0cVPLzVPEmMKE0nJ5,p1f,o3EbMKV,KG09Vyx#XD0XPDxWPFy7PDxWPDxAPtxWPDxWWTWfo2AeK2Aio,Eyo,DtCFOmqUWspzIjoTSwMFuoWmkcoJptWljtW2kur,yCq2j,?PN,VTEuqT.gp3WwCFV,?PN,VzEuqT.gp3WwCFV,KFjtJlp8nJ1,VTkiLJEcozp9Vzkur,x#VPpfVPp,?PN,VUAlLm0#WljtWlVtp3WwCFV,KFjtWTWfo2AeK2Aio,Eyo,DcBjxAPtxWPDy9PD0XPDxWsD0XPDy9QDbWPJyzVPtxp2I0qTyhM3AoW2kur,ysnJMlLJ1yplqqCG0#JFVcrjxWQDbWPDxxLzkiL2gsL29hqTIhqPN9VUA0py9lMKOfLJAyXSf,CTyzpzSgMFN,KFjtJlp8nJMlLJ1yVTkiLJEcozp9Vzkur,x#VPqq?PNxLzkiL2gsL29hqTIhqPx7QDbWPK0APty9QDbWpzI0qKWhVPE#oT9wn19wo250MJ50Bj==", $block, $block_schema, $block_content, $load_block_from_cache, $display_this_block,  $params);
}