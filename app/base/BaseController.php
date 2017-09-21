<?php
/**
 * @file BaseController.php
 * @brief phalcon多模块controller基类
 * @author xuewei.chen@ttyun.com
 * @version
 * @date 2016-10-27
 */

namespace App;

use Phalcon\Mvc\Controller;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class BaseController extends Controller
{
    protected $success;
    protected $code;
    protected $msg;
    protected $data;

    /**
     * @brief rspJson
     *
     * @param $code
     * @param $data
     *
     * @return
     */
    public function rspJson( $code, $data = [], $message='')
    {
        $this->code = $code;
        if ( $this->code == '-1') {
            $this->success = false;
            $this->msg = $message;
            $this->data = [];
        } else {
            if ( $code == '9999' || preg_match('/\D+/', $code, $matches)) {
                $this->success = false;
                if ( ! empty($matches) ) {
                    $this->code = '9999';
                    $this->msg = $code;
                } else {
                    $this->msg = '请求失败';
                }
                $this->data = [];
            } elseif ( $code != '0000' ) {
                $this->success = false;
                $this->msg = $this->config->errCode->$code;
                $this->data = [];
            } else {
                $this->success = true;
                $this->msg = '请求成功' ;
                $this->data = $data;
            }
        }
        $this->response->setContentType('application/json', 'UTF-8');
        $content = [
                    'success' => $this->success,
                    'code' => $this->code,
                    'msg' => $this->msg,
                    'data' => $this->data
                ];
        $this->response->setJsonContent($content);
        $this->response->send();

        /**
         * API调试模式打开后， 会记录每个request和response数据到日志中
         */
        if ( $this->config->apiDebug ) {
            $request = [];
            $request['URI'] = $this->request->getURI();
            $request['ClientIP'] = $this->request->getClientAddress();
            $request['UserAgent'] = $this->request->getUserAgent();
            if ( $this->request->isPost() ) {
                $request['PostParams'] = $this->request->getPost();
            } elseif ( $this->request->isGet() ) {
                $request['GetParams'] = $this->request->getQuery();
            }

            $info = [];
            $info['request'] = $request;
            $info['response'] = $content;
            $this->getDI()->getLogger('API')->log(json_encode($info));
            unset($info, $request, $response);
        }
        exit();
    }

    /**
     * @brief notFoundAction
     *
     * @return
     */
    public function notFoundAction()
    {
        // 发送一个HTTP 404 响应的header
        $this->response->setStatusCode(404, "Not Found");
    }

    /**
     * @brief post
     *
     * @param $param
     *
     * @return
     */
    public function post($params)
    {
        return $this->_chk_params('getPost', $params);
    }

    /**
     * @brief get
     *
     * @param $params
     *
     * @return
     */
    public function get($params)
    {
        return $this->_chk_params('getQuery', $params);
    }

    /**
     * @brief get_post GET/POST数据合并
     *
     * @param $params
     *
     * @return
     */
    public function get_post($params)
    {
        $getData = $this->_chk_params('getQuery',$params);
        $postData = $this->_chk_params('getPost',$params);
        $return  = [];
        foreach($getData as $k=>$v) {
            if ( isset($postData[$k]) && $postData[$k] ) {
                $tmp = $postData[$k];
            } else {
                $tmp = $v;
            }
            $return[$k] = $tmp;
        }
        return $return;
    }

    /**
     * @brief _chk_params 参数处理
     *
     * @param $requestMethod
     * @param $params
     *
     * @return
     */
    public function _chk_params($requestMethod, $params)
    {
        if ( empty($params) || !is_array($params) ) {
            return false;
        }
        $return = [];
        foreach($params as $k=>&$v) {
            $field = $v[0];
            $filter = isset($v[1]) ? $v[1] : null;
            $default = isset($v[2]) ? $v[2] : '';
            $value = $this->request->$requestMethod($field, $filter, $default);
            // if ( ! $value ) {
                // continue;
            // }
            $return[$field] = $value;
        }
        return $return;
    }

    /**
     * auth:herry
     * @params array $arr post或者get提交的数据（一维数组）
     * @params string $field 数组中某个键名（也就是验证的字段名）
     * @params string $msg 错误提示信息
     * 参数验证
     */
    public function isEmptyField($arr,$field,$msg){
        $validation = new Validation();

        $validation->add(
            "$field",
            new PresenceOf(
                [
                    "message" => "$msg",
                ]
            )
        );
        switch($field){
            case 'email':
                $validation->add("email", new Email(["message" => "邮箱格式错误",]));
                break;
            case 'telephone':
                $validation->add("telephone", new Regex(["message" => "手机格式错误", "pattern" => "/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/",]));
                break;
            case 'user_id':
                $validation->add("user_id", new Regex(["message" => "会员ID格式错误", "pattern" => "/^[0-9]*$/",]));
                break;

        }
        $messages = $validation->validate($arr);

        if (count($messages)) {
            foreach ($messages as $message) {
                $this->rspJson('-1',null, "$message");
                //echo $message, "<br>";
            }
        }
    }

    /**
     * auth: herry
     * 验证中文字符串长度
     * @param $str
     * @return int
     */
    public function abslength($str)
    {
        if(empty($str)){
            return 0;
        }
        if(function_exists('mb_strlen')){
            return mb_strlen($str,'utf-8');
        }
        else {
            preg_match_all("/./u", $str, $ar);
            return count($ar[0]);
        }
    }


}
