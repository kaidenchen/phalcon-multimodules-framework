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

use Violin\Violin;

class BaseController extends Controller
{
    use \App\ResponseTrait;

    public function initialize()
    {
        //  Key-Auth 验证
        $apiKeyList = $this->config['apiKeyList']->toArray();
        $apiKey = $this->request->getHeader('apikey');
        if ( ! $apiKey ) {
            $this->rspJson('0001');
        }
        if ( ! in_array($apiKey, $apiKeyList) ) {
            $this->rspJson('0001');
        }
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
     * @brief get_post GET/POST数据合并
     *
     * @param $params
     *
     * @return
     */
    public function get_post($params)
    {
        $getData = $this->checkParams('getQuery',$params);
        $postData = $this->checkParams('getPost',$params);
        $return = array_merge($getData, $postData);
        return $return;
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

        // 获取参数并验证规则
        foreach($params as $k=>$v) {
            $field = $v[0];
            $value = $this->request->$requestMethod($field);
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
        $v = new Violin();
        $v->addRuleMessages([
                'required' => '参数{field}是必填项.',
                'int'      => '参数{field}必须是整数',
                'alnum' => '参数{field}必须是字母或者数字',
                'regex' => '参数{field}格式不对',
                'min' => '参数{field}小于规定的长度',
                'max' => '参数{field}超出长度',
                'url' => '参数{field}不是URL',
                'array' => '参数{field}应该为URL数组',
                'date' => '参数{field}格式不正确',
                ]);
        $v->validate($validateRules);
        if(!$v->passes()) {
            $msg = $v->errors()->first();
            $this->rspJson('-1', null, $msg);
        }
        return true;
    }

}
