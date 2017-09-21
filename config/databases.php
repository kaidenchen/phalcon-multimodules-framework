<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

return new \Phalcon\Config([
    'database' => [
        'adapter'  => 'Mysql',
        'host'     => '172.168.6.6',
        'username' => 'root',
        'password' => '111111',
        'dbname'   => 'test',
        'charset'  => 'utf8',
    ]
]);
