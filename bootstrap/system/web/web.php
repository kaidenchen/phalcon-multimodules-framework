<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

ini_set('date.timezone', 'Asia/Shanghai');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include general services
     */
    require BOOTSTRAP_SYSTEM_PATH . '/services.php';

    /**
     * Include web environment specific services
     */
    require BOOTSTRAP_SYSTEM_PATH . '/web/services_web.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Auto register
     */
    require BOOTSTRAP_PATH . '/loader.php';

    /**
     * Handle the request
     */
    $application = new Application($di);

    /**
     * Register application modules
     */
    $application->registerModules($registerModules);

    /**
     * Disable view 
     *
     */
    // $application->useImplicitView(false);

    /**
     * Include routes
     */
    require BOOTSTRAP_SYSTEM_PATH . '/web/routerServices.php';
    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
