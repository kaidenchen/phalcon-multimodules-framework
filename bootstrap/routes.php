<?php

/**
 * @file routes.php
 * @brief 仅适用于api模式    作用：路由表设置， 请再此维护您的接口地址
 * @author 
 * @version 
 * @date 2016-11-11
 */

return [

	'index' => [
		'label' => '公用列表', 
		'namespace' => 'App\Index\Controllers',
		'list' => [
		]
	],
	'home' => [
		'label' => '前台默认路由', 
		'namespace' => 'App\Home\Controllers',
		'list' => [
			['label'=>'index', 'url'=>'home/index/index', 'action'=>'home/index/index', 'display'=>true, 'ver'=> 1.0],
		]
	],
	'admin' => [
		'label' => '后台默认路由', 
		'namespace' => 'App\Admin\Controllers',
		'list' => [
			['label'=>'index', 'url'=>'admin/index/index', 'action'=>'admin/index/index', 'display'=>true, 'ver'=> 1.0],
		]
	],
];
