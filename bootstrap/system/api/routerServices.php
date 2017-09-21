<?php

//路由列表
$routerList = require BOOTSTRAP_PATH . '/routes.php';
$router = $di->get("router");
foreach($routerList as &$routerItem){
	if(count($routerItem['list'])){
		foreach($routerItem['list'] as &$actionItem) {
			if(isset($actionItem['display']) && $actionItem['display']){
				$action = explode('/', $actionItem['action']);
				$router->add( '/'.$actionItem['url'],[
						'namespace'  => $routerItem['namespace'],
						'module'     => (isset($action[0]) ? $action[0] : ''),
						'controller' => (isset($action[1]) ? $action[1] : ''),
						'action'     => (isset($action[2]) ? $action[2] : '')
					]
				);	
			}
		}
	}
}
unset($routerList);
$di->set("router", $router);
