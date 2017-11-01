<?php
/*
 *---------------------------------------------------------------
 *  设置内存限制  
 *---------------------------------------------------------------
 */
@ini_set('memory_limit', '32M');


/*
 *---------------------------------------------------------------
 *  设置时区
 *---------------------------------------------------------------
 */
@ini_set('date.timezone', 'Asia/Shanghai');

/*
 *---------------------------------------------------------------
 *  定义目录常量
 *---------------------------------------------------------------
 */
require __DIR__.'/paths.php';

/*
 *---------------------------------------------------------------
 *  定义业务常量
 *---------------------------------------------------------------
 */
require __DIR__.'/constants.php';


/*
 *---------------------------------------------------------------
 *  Error Reporting 设置
 *---------------------------------------------------------------
 */
switch (ENVIRONMENT) 
{
    case 'dev':
    case 'test': 
    case 'yf':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;
    case 'prod': 
        ini_set('display_errors', 0);
        break;
    default: 
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 *   设置Autoloader
 *---------------------------------------------------------------
 */
require __DIR__.'/autoload.php';


/*
 *---------------------------------------------------------------
 *  进入Phalcon WebApi框架引导程序
 *---------------------------------------------------------------
 */
$bootstrapFile = BOOTSTRAP_PATH.'/system/' . SYS_TYPE .'/' . SYS_TYPE . '.php';
if ( file_exists($bootstrapFile) ) {
    require $bootstrapFile;
} else {
    header('HTTP/1.1 503 Please defind system type.', TRUE, 503);
    echo 'Please defind system type.';
}

