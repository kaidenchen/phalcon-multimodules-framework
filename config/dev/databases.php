<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

return new \Phalcon\Config([
    'database' => [
        'adapter'  => 'Mysql',
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => '111111',
        'dbname'   => 'test',
        'charset'  => 'utf8',
    ]
]);
