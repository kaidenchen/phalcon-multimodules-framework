<?php

/* Copyright(C)
 * For free
 * All right reserved
 *
 */
namespace App\Base\Library;

class Time
{
    const BASE_RATE = 1000;

    /**
     * @brief 获取毫秒数
     *
     * @param
     */
    public function getMillisecond() {
        return (int)sprintf("%.0f", microtime(true) * self::BASE_RATE);
    }

    /**
     * @brief 通过毫秒数获取时间
     * @param  [type] $timestamp [毫秒时间戳]
     * @param  string $format    [格式]
     * @param  string $x         [毫秒占位符]
     * @return [string]          [时间]
     * @author zicai
     * @date 2017年10月24日15:50:49
     */
    public function getFormat(string $timestamp= null, string $format = 'Y-m-d H:i:s', $x = 'x') : string
    {
        if (is_null($timestamp)) {
            $timestamp = $this->getMillisecond();
        }
        list($sec, $usec) = explode(".", (float)($timestamp / self::BASE_RATE));
        $date = date($format.'.'.$x,$sec);
        return str_replace($x, $usec, $date);
    }

}
