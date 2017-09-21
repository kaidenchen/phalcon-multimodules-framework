<?php

defined('BASE_PATH') OR exit('No direct script access allowed'); 

return new \Phalcon\Config([
    'moduleSettings' => [
        'cli'  =>  [
                    'className' => 'App\Cli\Module', 
                    'path' => APP_PATH .'/cli/Module.php'
                    ],
        'index'  =>  [
                    'className' => 'App\Index\Module', 
                    'path' => APP_PATH .'/index/Module.php'
                    ],
        'admin'  =>  [
                    'className' => 'App\Admin\Module', 
                    'path' => APP_PATH .'/admin/Module.php'
                    ],
        'home'  =>  [
                    'className' => 'App\Home\Module', 
                    'path' => APP_PATH .'/home/Module.php'
                    ]
        ],
]);
