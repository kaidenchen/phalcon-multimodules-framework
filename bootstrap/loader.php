<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

use Phalcon\Loader;

$loader = new Loader();


/**
 * Register Namespaces
 */
$loader->registerNamespaces([
    'App\Base\Models' => APP_PATH . '/base/models/',
    'App\Base\Library' => APP_PATH . '/base/library/',
    'App\Base\Middleware' => APP_PATH . '/base/middleware/',
    'App\Base\Plugins' => APP_PATH . '/base/plugins/',
    'App' => APP_PATH . '/base/',
]);

/**
 * Register module classes
 */
$loader->registerClasses($registerClasses);

$loader->register();
