<?php
/**
 * @file index.php
 * @brief 
 * @author xuewei.chen@ttyun.com
 * @version 
 * @date 2017-10-18
 */

/*
 *---------------------------------------------------------------
 * 系统环境设置,  四种环境, 分别为dev、test、yf、prod
 *---------------------------------------------------------------
 */
$env = get_cfg_var('env.name');
if ( empty($env) ) {
    $env = 'dev';
}
define('ENVIRONMENT', $env);

/*
 *---------------------------------------------------------------
 * SYS_TYPE 有2种模式 : 1) web 模式； 2) api 模式  
 *---------------------------------------------------------------
 */
$sType = get_cfg_var('env.sType');
if ( empty($sType) ) {
    $sType = 'api';
}
define('SYS_TYPE', $sType);

require __DIR__.'/../bootstrap/start.php';

