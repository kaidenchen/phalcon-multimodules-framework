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
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Handle Modules settings
     */
    foreach($config->moduleSettings as $key=>$val) {
        $registerClasses[$val->className] = $val->path;
        $registerModules[$key] = ['className' => $val->className];
    }

    /**
     * Include Phalcon Autoloader
     */
    include BOOTSTRAP_PATH . '/loader.php';

    /**
     * Include web environment specific services
     */
    require BOOTSTRAP_SYSTEM_PATH . '/api/services_api.php';

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
    $application->useImplicitView(false);

    /**
     * Include routes
     */
    require BOOTSTRAP_SYSTEM_PATH . '/api/routerServices.php';
    echo $application->handle()->getContent();

} catch (\Exception $e) {
    header("content-type:application/json;charset=utf-8");
    $msg = $e->getMessage();
    if ( isset($di['logger']) )  {
        $di->getLogger('EXCEPTION')->log(json_encode($msg));
        $di->getLogger('EXCEPTION')->log('GET: '. json_encode($_GET));
        $di->getLogger('EXCEPTION')->log('POST: '. json_encode($_POST));
    }
    $result = [ 'ret' => "500", 'data' => [] , 'msg' => 'HTTP/1.1 500 Internal Server Error' ];
    echo json_encode($result);

    if ( isset($di['config']['exceptionDebug']) && $di['config']['exceptionDebug'] ) {
        error_log($e->getMessage());
        error_log($e->getTraceAsString());
    }

}
