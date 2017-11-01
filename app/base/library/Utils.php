<?php

namespace App\Base\Library;

class Utils
{

    /**
     * @brief dbExecInfo
     *
     * @return
     */
    public function getSqls( $bTime = false )
    {
        $DI = \phalcon\DI\FactoryDefault::getDefault();

        $profiles = $DI->getProfiler()->getProfiles();
        foreach ($profiles as $profile) {
            echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
            if ( $bTime ) {
                echo "Start Time: ", $profile->getInitialTime(), "\n";
                echo "Final Time: ", $profile->getFinalTime(), "\n";
                echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
            }
        }
        return true;
    }

    /**
     * @brief dd 打印调试函数
     *
     * @param $data
     *
     * @return
     */
    public function dd(...$data)
    {
        foreach ($data as $value) {
            echo "<pre>";
            print_r($value);
            echo "</pre>";
            if ( !is_string($value) ) {
                $value = json_encode($value,true);
            }
            error_log($value);
        }
        die;
    }

    /**
     * @brief curlGet
     *
     * @param $url
     * @param $params
     *
     * @return
     */
    public function curlGet($url, $params=[], $headers=[])
    {
        if ( !is_array($params) ) return false;
        $curl = new \Curl\Curl();
        if ( !empty($headers) ) {
            foreach($headers as $key=>$val) $curl->setHeader($key, $val);
        }
        $DI = \phalcon\DI\FactoryDefault::getDefault();
        $curl->get($url, $params);
        if ($curl->error) {
            $curl->error_code;
            $msg = sprintf("GET curl %s failed, error_code: %s, params : %s, Request Headers: %s", $url, $curl->error_code, json_encode($params), json_encode($curl->request_headers));
            $DI->getLogger('CLI_CURL_ERROR')->log($msg);
        } else {
            $body = $curl->response;
            $msg = sprintf("POST %s SUCCESSED, params : %s,  response: %s,  Request Headers: %s, Response Headers: %s", $url, json_encode($params), $body, json_encode($curl->request_headers), json_encode($curl->response_headers));
            $DI->getLogger('CLI_CURL_DEBUG')->log($msg);
        }
        $curl->close();
        return isset($body) ? $body : false;
    }

    /**
     * @brief post
     *
     * @param $url
     * @param $params
     *
     * @return
     */
    public function curlPost($url, $params=[], $headers=[])
    {
        if ( !is_array($params) ) return false;
        $curl = new \Curl\Curl();
        if ( !empty($headers) ) {
            foreach($headers as $key=>$val) $curl->setHeader($key, $val);
        }
        $curl->post($url, $params);

        $DI = \phalcon\DI\FactoryDefault::getDefault();
        if ($curl->error) {
            $curl->error_code;
            $msg = sprintf("POST curl %s failed, error_code: %s, params : %s, Request Headers: %s", $url, $curl->error_code, json_encode($params), json_encode($curl->request_headers));
            $DI->getLogger('CLI_CURL_ERROR')->log($msg);
        } else {
            $body = $curl->response;
            $msg = sprintf("POST %s SUCCESSED, params : %s,  response: %s,  Request Headers: %s, Response Headers: %s", $url, json_encode($params), $body, json_encode($curl->request_headers), json_encode($curl->response_headers));
            $DI->getLogger('CLI_CURL_DEBUG')->log($msg);
        }
        $curl->close();
        return isset($body) ? $body : false;
    }


    /**
     * auth: herry
     * 验证中文字符串长度
     * @param $str
     * @return int
     */
    public function absLength($str)
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
