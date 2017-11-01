<?php
/**
 * @file BaseController.php
 * @brief phalcon多模块controller基类
 * @author xuewei.chen@ttyun.com
 * @version
 * @date 2016-10-27
 */

namespace App\Base;

use Phalcon\Mvc\Controller;

use Violin\Violin;

class BaseController extends Controller
{
    use \App\Base\ResponseTrait;

    public function initialize()
    {
        //  Key-Auth 验证
        /*
        $apiKeyList = $this->config['apiKeyList']->toArray();
        $apiKey = $this->request->getHeader('apikey');
        if ( ! $apiKey ) {
            $this->rspJson('0001');
        }
        if ( ! in_array($apiKey, $apiKeyList) ) {
            $this->rspJson('0001');
        }
        */
    }

    /**
     * @brief notFoundAction
     *
     * @return
     */
    public function notFoundAction()
    {
        $this->rspJson->setRet('200');
        $this->rspJson->output();
    }

    /**
     * @brief post
     * 获取POST数据
     *
     * @param $param
     *
     * @return
     */
    public function getPost($params)
    {
        return $this->checkParams('getPost', $params);
    }

    /**
     * @brief get
     * 获取GET数据
     *
     * @param $params
     *
     * @return
     */
    public function getQuery($params)
    {
        return $this->checkParams('getQuery', $params);
    }

    /**
     * @brief checkParams 参数处理
     *
     * @param $requestMethod
     * @param $params
     *
     * @return
     */
    public function checkParams($requestMethod, $params)
    {
        if ( empty($params) || !is_array($params) ) {
            return false;
        }
        $return = $validateRules = $defaultParams = [];

        // 获取并过滤参数且验证规则
        foreach($params as $k=>$v) {
            $field = $v[0];
            $filter = isset($v['filter']) ? $v['filter'] : 'trim';
            $value = $this->request->$requestMethod($field, $filter);
            if ( is_null($value) || $value == '' ) {
                if ( isset($v['default']) )  $defaultParams[$field] = $v['default'];
            }
            $return[$field] = (!is_array($value)&&!is_object($value))?rtrim($value):$value;
            if ( isset($v['rules']) ) {
                $validateRules[$field] = [ $value, $v['rules'] ];
            }
        }
        $return = array_filter($return, function($v, $k) {
                        return !(is_null($v) || $v == '');
                    }, ARRAY_FILTER_USE_BOTH );
        if ( ! empty($validateRules) ) {
            $this->validate($validateRules);
        }
        return array_merge($return, $defaultParams);
    }

    /**
     * @brief validate
     * 参数校验
     *
     * @param $rules
     *
     * @return
     */
    public function validate($validateRules)
    {
        if (empty($validateRules) ) return true;
        $v = $this->di->getValidator();
        $v->validate($validateRules);
        if(!$v->passes()) {
            $msg = $v->errors()->first();
            $this->rspJson('0002', null, $msg);
        }
        return true;
    }

}
