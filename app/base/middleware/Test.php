<?php
namespace App\Base\Middleware;

class Test extends \Phalcon\Mvc\User\Plugin implements \Sid\Phalcon\AuthMiddleware\MiddlewareInterface
{
    use \App\Base\ResponseTrait;

    public function authenticate()
    {
        $this->rspJson('-1', null, '我是中间件');
        return true;
    }

}
