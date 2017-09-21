<?php
/*
 * Modified: preppend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */

return new \Phalcon\Config([
    'errCode' => [
        '0000' => '成功',
        '0001' => '没有数据',

        '9000' => '签名验证失败：无法获取ip',
        '9001' => '签名验证失败：缺少必要参数',
        '9002' => '签名验证失败：签名过期或时间传值错误',
        '9003' => '签名验证失败：密钥不正确',
        '9004' => '签名验证失败：sign不正确',
        '9999' => '系统异常',
    ]
]);
