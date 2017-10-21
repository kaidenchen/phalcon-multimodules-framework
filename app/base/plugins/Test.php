<?php
namespace App\Base\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class Test extends Plugin
{
    use \App\ResponseTrait;

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $this->rspJson('-1', null, 'test');
        return false;
    }

}
