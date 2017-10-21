<?php
/*
 * Modified: preppend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */

return new \Phalcon\Config([
    'errCode' => [
        '0000' => '成功',
        '0001' => '认证失败',
    ]
]);
