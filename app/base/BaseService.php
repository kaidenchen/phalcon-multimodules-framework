<?php
/**
 * @file BaseController.php
 * @brief phalcon多模块controller基类
 * @author xuewei.chen@ttyun.com
 * @version
 * @date 2016-10-27
 */

namespace App;

use Phalcon\Di;

class BaseService 
{
    protected $di;
    protected $data = [];


    public function __construct()
    {
        $this->di = Di::getDefault(); 
    }

    /**
     * @brief __set 
     *
     * @param $name
     * @param $value
     *
     * @return 
     */
    public function __set($name, $value) 
    {
        if ( $name == 'attributes' ) {
            $this->setAttributes($value);
        } else {
            $this->data[$name] = $value;
        }
    }

    /**
     * @brief __get 
     *
     * @param $name
     *
     * @return 
     */
    public function __get($name)
    {
        $value = null;
        if ( $name == 'attributes' ) {
            $value = $this->getAttributes();
        } else {
            if ( array_key_exists($name,  $this->data) ) {
                $value = $this->data[$name];
            }
        }
        return $value;
    }

    /**
     * @brief setAttributes 
     *
     * @param $values
     *
     * @return 
     */
    public function setAttributes($values) 
    {
        if ( ! is_array($values) ) {
            return ;
        }
        foreach($values as $k=>$v) {
            $this->data[$k] = $v;
        }
    }

    /**
     * @brief 
     */
    public function getAttributes()
    {
        $data = [];
        foreach($this->data as $key=>$val) {
            if ( $key == 'di' ) {
                continue;
            }
            $data[$key] = $val;
        }
        return $data;
    }

}
