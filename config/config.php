<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

return new \Phalcon\Config([
    'version' => '1.0',

    /**
     * SQL statement调试语句记录, data/logs/DB****.log中
     */
    'sqlDebug' => true, 

    /**
     * 请求URL和参数、返回值打印至data/logs/API***.log中
     */
    'apiDebug' => true, 

    'application' => [
        'appDir'         => APP_PATH . '/',
        'modelsDir'      => APP_PATH . '/base/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'cacheDir'       => BASE_PATH . '/data/cache/',
        'baseUri'        => '/'
    ],

    /**
     * 自动注册service到di中
     */
    'services' => [
        'utils' => 'App\Library\Utils',
        'arr' => 'App\Library\Arr',
    ],


    /**
     * if true, then we print a new line at the end of each CLI execution
     *
     * If we dont print a new line,
     * then the next command prompt will be placed directly on the left of the output
     * and it is less readable.
     *
     * You can disable this behaviour if the output of your application needs to don't have a new line at end
     */
    'printNewLine' => true,

]);
