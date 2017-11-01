<?php
defined('BASE_PATH') OR exit('No direct script access allowed'); 

use Phalcon\Loader;
use Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter;
use Phalcon\Mvc\Model\MetaData\Strategy\Annotations as StrategyAnnotations;



/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    $globalConfig = glob(CONFIG_PATH ."/*php");
    foreach($globalConfig as $file) {
        $tmpConfig = include  $file;
        if ( isset($config)) {
            $config->merge($tmpConfig);
        }else{
            $config = $tmpConfig;
        }
    }

    $envConfigPath = CONFIG_PATH .'/'.ENVIRONMENT;
    if ( is_dir($envConfigPath) ) {
        $envConfig = glob($envConfigPath ."/*php");
        foreach($envConfig as $envfile) {
            $tmpEnvConfig = include $envfile;
            $config->merge($tmpEnvConfig);
        }
    }
    return $config;
});

/**
 * Add SQL Profiler, with this you can diagnose performance problems and to discover bottlenecks.
 */
$di->set('profiler', function(){
    return new \Phalcon\Db\Profiler();
}, true);


/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($di) {
    $config = $this->getConfig();

    $eventsManager = new \Phalcon\Events\Manager();
    $profiler = $di->getProfiler();

    $eventsManager->attach('db', function($event, $connection) use ($di,$profiler) {
        if ($event->getType() == 'beforeQuery') {
            $sql = $connection->getSQLStatement();
            $profiler->startProfile($sql);
            // 开启sqlDebug模式，会自动记录sql操作到runtime/logs/db_xxx.log中
            if ($di->getConfig()->sqlDebug) {
                $di->getLogger('DB')->log($sql);
            }
        }
        if ($event->getType() == 'afterQuery') {
            $profiler->stopProfile();
        }
    });

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $connection = new $class([
        'host'     => $config->database->host,
        'port'     => $config->database->port,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset,
        'options' => [PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC],
    ]);

    $connection->setEventsManager($eventsManager);
    return $connection;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    $metaData = new MetaDataAdapter( [ 'metaDataDir' => DATA_PATH . '/cache/metadata/', 'prefix' => 'tb_' , 'lifetime' => 86400 ] );
    $metaData->setStrategy( new StrategyAnnotations());
    return $metaData;
});

/**
 * Log writer
 */
$di->set('logger', function($type="info") {
    if ( is_dir(LOG_PATH) ) {
        if ( !is_writable(LOG_PATH) ) {
            header('HTTP/1.1 401 Log Path access denied.', TRUE, 401);
            echo 'Log path access denied.';
            exit(1); // EXIT_ERROR
        }
    } else {
        if (!mkdir(LOG_PATH, 0777, true)) {
            header('HTTP/1.1 401 create  log path failed.', TRUE, 401);
            echo 'Create log path failed .';
            exit(1); // EXIT_ERROR
        }
    }
    $logFile = sprintf("%s/%s_%s.log", LOG_PATH, $type, date('Y_m_d'));
    $logger = new \Phalcon\Logger\Adapter\File($logFile);
    return $logger;
});

/**
 * Extension services
 *
 */
if ( $di->getConfig()->services ) {
    foreach($di->getConfig()->services  as $key=>$service) {
        $di->setShared($key, function() use($service) {
            return new $service;
        });
    }
}

