<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

return new \Phalcon\Config([
    'database' => [
        'adapter'  => 'Mysql',
        'host'     => '172.168.6.12',
        'username' => 'test',
        'password' => 'test123',
        'dbname'   => 'test',
        'charset'  => 'utf8',
    ]
]);
