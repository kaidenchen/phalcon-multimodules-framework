<?php

namespace App\Base\Library;

use Violin\Violin;

/**
 * 验证类
 */
class Validator extends Violin
{

    function __construct()
    {
        $this->addRuleMessages([
            'required' => '参数{field}是必填项',
            'int'      => '参数{field}必须是整数',
            'alnum' => '参数{field}必须是字母或者数字',
            'regex' => '参数{field}格式不对',
            'min' => '参数{field}小于规定的长度',
            'max' => '参数{field}超出长度',
            'url' => '参数{field}不是URL',
            'array' => '参数{field}应该为URL数组',
            'date' => '参数{field}格式不正确',

            'json' => '参数{field}必须为json格式',
            'mobile' => '参数{field}错误，请填写正确的手机号',
            'integerOrIntegerString' => '参数{field}必须是整数或已,号分隔的字符串',
        ]);
    }

    //判断是否是json格式
    public function validate_json($value, $input, $args)
    {
        if ( ! $value ) return true;
        json_decode($value);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    // 验证是否是手机号码
    public function validate_mobile($value, $input, $args)
    {
        if ( ! $value || preg_match("/^1\d{10}$/", $value)) {
            return true;
        }
        return false;
    }


    // 验证是否是整数或以指定符号分隔整数的字符串
    // $args[0] 分隔符 默认,号
    public function validate_integerOrIntegerString($value, $input, $args)
    {
        if ( ! $value ) return true;

        $sign = isset($args[0]) ? $args[0] : ',';

        if (strstr($value,$sign)) {
            $value = explode($sign, $value);
            foreach ($value as $v) {
                if (!ctype_digit((string)$v)) {
                    return false;
                }
            }
            return true;
        }else if(ctype_digit((string)$value)){
            return true;
        }
        return false;
    }


}
