<?php
/*
 * Modified: preppend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */

return new \Phalcon\Config([
    'errCode' => [
        0 => '成功',
        9001 => '认证失败',
        9002 => '参数错误',
        9004 => '设置失败',
        9005 => '无权限',
        9006 => '未能获取到数据',
    ]
]);
