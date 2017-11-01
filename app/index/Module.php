<?php

namespace App\Index;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Config;


class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'App\Index\Controllers' => __DIR__ . '/controllers/',
            'App\Index\Models'      => __DIR__ . '/models/',
            'App\Index\Services'      => __DIR__ . '/services/' ]);

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /*
        $di->setShared('view', function () use ($config, $di) {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir(ROOT_PATH . '/app/index/views/');
            $view->registerEngines(array(
                '.phtml' => function ($view, $di) use ($config) {
                    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                    $volt->setOptions(array(
                        'compileAlways' => false,
                        'compiledPath' => ROOT_PATH . '/app/cache/compiled/frontend'
                    ));
                    return $volt;
                },
            ));
            return $view;
        });
        */
    }

}
