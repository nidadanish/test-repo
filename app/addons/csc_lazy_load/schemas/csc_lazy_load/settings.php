<?php
/*****************************************************************************
*                                                                            *
*          All rights reserved! CS-Commerce Software Solutions               *
* 			https://www.cs-commerce.com/license-agreement.html 				 *
*                                                                            *
*****************************************************************************/
if (!defined('BOOTSTRAP')) { die('Access denied'); }
$schema = array(   
	'general' => array(		
		'lazy_images'=>array(
			'type' => 'checkbox',
			'default'=>'Y',
			'tooltip'=>true				
		),
		'main'=>array(
			'type' => 'checkbox',
			'default'=>'Y',
			'tooltip'=>true,
			'show_when'=>['lazy_images'=>['Y']]			
		),		
		'products'=>array(
			'type' => 'checkbox',
			'default'=>'Y',
			'tooltip'=>true,
			'show_when'=>['lazy_images'=>['Y']]			
		),
		'banners'=>array(
			'type' => 'checkbox',
			'default'=>'Y',
			'tooltip'=>true	,
			'show_when'=>['lazy_images'=>['Y']]						
		),
		'smarty_block'=>array(
			'type' => 'checkbox',
			'default'=>'Y',
			'tooltip'=>true	,
			'show_when'=>['lazy_images'=>['Y']]						
		),
		'html_block'=>array(
			'type' => 'checkbox',
			'default'=>'Y',
			'tooltip'=>true	,
			'show_when'=>['lazy_images'=>['Y']]						
		),
		'other'=>array(
			'type' => 'checkbox',
			'default'=>'Y',
			'tooltip'=>true	,
			'show_when'=>['lazy_images'=>['Y']]						
		),		
		'lazy_iframes'=>array(
			'type' => 'checkbox',
			'default'=>'Y',
			'tooltip'=>true				
		),
		'info'=>array(
			'type' => 'warning'					
		)
		
	),	 	 	 	 	
);

return $schema;