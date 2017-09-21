<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

return new \Phalcon\Config([
    'modelCacheRedis' => [
        'host' => 'localhost',
        'port' => '6379',
        //'auth' => 'test',
    ]
]);
