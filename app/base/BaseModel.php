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
    public function rspJson( $code, $data = [])
    {
        $this->code = $code;
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
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setJsonContent([
                    'success' => $this->success,
                    'code' => $this->code,
                    'msg' => $this->msg,
                    'data' => $this->data
                ]); 
        $this->response->send();
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


}
