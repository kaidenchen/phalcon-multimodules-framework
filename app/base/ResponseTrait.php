<?php

namespace App\Base;

trait ResponseTrait
{
    public function rsp(int $code = 200, string $msg = '') : RspJson
    {
        $di = \phalcon\DI\FactoryDefault::getDefault();
        $di->getRspJson()->setRet($code);
        if (!empty($msg)) {
            $di->getRspJson()->setMsg($msg);
        }
        $di->getRspJson()->output();
        self::__rspLog();
        exit;
    }

    public function rspSuccess($info = [], string $msg ='') : RspJson
    {
        self::rspJson( 0, $info = [], $msg ='');
    }

    /**
     * @brief rspJson
     *
     * @param $code
     * @param $info
     * @param $msg
     *
     * @return
     */
    public function rspJson(int $code = 0, $info = [], string $msg ='') : RspJson
    {
        $di = \phalcon\DI\FactoryDefault::getDefault();
        $data = [];
        $data['code'] = $code;
        $data['info'] = $info;
        $data['msg'] = $msg;
        $di->getRspJson()->setRet('200');
        if ( $code != '-1') {
            if ( $code == '9999' || preg_match('/\D+/', $code, $matches)) {
                if ( ! empty($matches) ) {
                    $data['code'] = '9999';
                    $data['msg'] = $code;
                } else {
                    $data['msg'] = '请求失败';
                }
                $data['info'] = [];
            } elseif ( $code != 0 ) {
                $data['msg'] = $msg ? $msg : $di->getConfig()->errCode->$code;
                $data['info'] = [];
            } else {
                $data['msg'] = '请求成功';
            }
        }
        $di->getRspJson()->setData($data);
        $di->getRspJson()->output();

        self::__rspLog();
        exit();
    }


    private static function __rspLog(array $data = [])
    {
        $di = \phalcon\DI\FactoryDefault::getDefault();
        /**
         * API调试模式打开后， 会记录每个request和response数据到日志中
         */
        if ( $di->getConfig()->apiDebug ) {
            $request = [];
            $request['URI'] = $di->getRequest()->getURI();
            $request['ClientIP'] = $di->getRequest()->getClientAddress();
            $request['UserAgent'] = $di->getRequest()->getUserAgent();
            if ( $di->getRequest()->isPost() ) {
                $request['PostParams'] = $di->getRequest()->getPost();
            } elseif ( $di->getRequest()->isGet() ) {
                $request['GetParams'] = $di->getRequest()->getQuery();
            }

            $data = [];
            $data['request'] = $request;
            $data['response'] = $di->getRspJson()->getContent();
            $di->getLogger('API')->log(json_encode($data));
            unset($data, $request, $response);
        }
    }

}
