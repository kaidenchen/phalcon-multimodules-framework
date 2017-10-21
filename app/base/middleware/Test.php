<?php
namespace App\Base\Middleware;

class Test extends \Phalcon\Mvc\User\Plugin implements \Sid\Phalcon\AuthMiddleware\MiddlewareInterface
{
    use \App\ResponseTrait;

    public function authenticate()
    {
        return true;
    }

}
