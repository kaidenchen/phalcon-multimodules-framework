<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

use Phalcon\Loader;

$loader = new Loader();


/**
 * Register Namespaces
 */
$loader->registerNamespaces([
    'App\Models' => APP_PATH . '/base/models/',
    'App\Library' => APP_PATH . '/base/library/',
    'App' => APP_PATH . '/base/',
]);

/**
 * Register module classes
 */
$loader->registerClasses($registerClasses);

$loader->register();
