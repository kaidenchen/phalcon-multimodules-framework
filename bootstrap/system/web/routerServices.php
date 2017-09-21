<?php

$router = $di->get("router");

foreach ($application->getModules() as $key => $module) {
	
    $namespace = preg_replace('/Module$/', 'Controllers', $module["className"]);

    // 只指定模块的默认路由, module首字母大小写都支持
    $router->add('/'.$key, [
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 'index',
        'action' => 'md',
    ])->setName($key);


    // 指定全路径路由设置, module首字母大小写都支持
    $router->add('/'.$key.'/:controller/:action', [
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 1,
        'action' => 2,
    ]);
}
