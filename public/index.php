<?php
/**
 * @file index.php
 * @brief 
 * @author xuewei.chen@ttyun.com
 * @version 
 * @date 2016-11-08
 */

/*
 *---------------------------------------------------------------
 * 系统环境设置,  四种环境, 分别为dev、test、yf、prod
 *---------------------------------------------------------------
 */
define('ENVIRONMENT', isset($_SERVER['PHALCON_ENV']) ? $_SERVER['PHALCON_ENV'] : 'dev');

/*
 *---------------------------------------------------------------
 * SYS_TYPE 有2种模式 : 1) web 模式； 2) api 模式 
 *---------------------------------------------------------------
 */
define('SYS_TYPE', isset($_SERVER['SYS_TYPE']) ? $_SERVER['SYS_TYPE'] : 'api');

require __DIR__.'/../bootstrap/start.php';

