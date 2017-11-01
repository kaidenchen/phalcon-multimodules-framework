<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Events\Event;
use Phalcon\Loader;

$loader = new Loader();
$loader->registerNamespaces([
        'App\Base\Models' => APP_PATH . '/base/models/',
        'App\Base\Library' => APP_PATH . '/base/library/',
        'App\Base\Middleware' => APP_PATH . '/base/middleware/',
        'App\Base\Plugins' => APP_PATH . '/base/plugins/',
        'App\Base' => APP_PATH . '/base/',
        ]);
foreach($config->moduleSettings as $key=>$val) {
    $registerClasses[$val->className] = $val->path;
    $registerModules[$key] = ['className' => $val->className];
}
// Listen all the loader events
/*
$eventsManager = new EventsManager();
$eventsManager->attach(
        "loader:beforeCheckPath",
        function (Event $event, Loader $loader) {
            echo $loader->getCheckedPath()."\n";
        }
    );
$loader->setEventsManager($eventsManager);
*/
$loader->registerClasses($registerClasses);
$loader->register();
