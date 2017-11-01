<?php
namespace App\Base\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class ExceptionPlugin extends Plugin
{
    use \App\Base\ResponseTrait;

    public function beforeException(Event $event, Dispatcher $dispatcher, \Exception $exception)
    {
        // TODO: 处理Dispather异常
        if ($exception instanceof DispatchException) {
            $this->rsp(404);
        } else {
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    $this->rsp(404);
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $this->rsp(404);
                default:
                    $this->rspJson($exception->getCode(), [], $exception->getMessage());
            }
        }
        exit();
    }

}
