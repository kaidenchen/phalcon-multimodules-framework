<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use App\Utils;

/**
 * Registering a router
 */
$di->setShared('router', function () {
    $router = new Router();
    return $router;
});

/**
 * The URL component is used to generate all kinds of URLs in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Starts the session the first time some component requests the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});


/**
* Set the default namespace for dispatcher
*/
$di->setShared('dispatcher', function() use ($di) {
    $eventsManager = $di->getShared('eventsManager');
    $eventsManager->attach('dispatch:beforeExecuteRoute',  new \Sid\Phalcon\AuthMiddleware\Event());
    $eventsManager->attach('dispatch:beforeException', new \App\Base\Plugins\ExceptionPlugin());
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});


/**
 * 
 * 设置模型缓存服务
 */ 
$di->set('modelsCache', function () {
    // 默认缓存时间为一天
    $frontCache = new Phalcon\Cache\Frontend\Data( [ "lifetime" => 86400 ] );

    $config = $this->getConfig();
    $backendConfig = [ "host" => $config->modelCacheRedis->host,
                       "port" => $config->modelCacheRedis->port,
                       "prefix" => "model_" ];
    if (isset($config->redis['auth'])) {
        $backendConfig['auth'] = $config->modelCacheRedis->auth;
    }
    // Memcached连接配置 这里使用的是Memcache适配器
    $cache = new Phalcon\Cache\Backend\Redis($frontCache, $backendConfig);
    return $cache;
});

