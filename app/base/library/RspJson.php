<?php
namespace App\Base\Library;

/**
 * ResponseJson 响应类
 *
 * - 拥有各种结果返回状态 ，以及对返回结果 的格式化
 * - 其中：200成功，400非法请求，500服务器错误
 *
 */

class RspJson {

    protected $di;

    protected $response;

	/**
	 * @var int $ret 返回状态码，其中：200成功，400非法请求，500服务器错误
	 */
    protected $ret = 200;
    
    /**
     * @var array 待返回给客户端的数据
     */
    protected $data = array();

    protected $msg = '';
    

    public function __construct() {
        $this->di = \phalcon\DI\FactoryDefault::getDefault();
        $this->response = $this->di->getResponse();
    }

    /**
     * 设置返回状态码
     * @param int $ret 返回状态码，其中：200成功，400非法请求，500服务器错误
     */
    public function setRet($ret) {
    	$this->ret = $ret;
        $this->adjustHttpStatus();
    	return $this;
    }
    
    /**
     * 设置返回数据
     * @param array/string $data 待返回给客户端的数据，建议使用数组，方便扩展升级
     */
    public function setData($data) {
    	$this->data = $data;
    	return $this;
    }

    public function setMsg($msg) {
    	$this->msg = $msg;
    	return $this;
    }

    /**
     * @brief getContent 
     *
     * @return 
     */
    public function getContent() {
        $content =  [
                    'ret' => $this->ret,
                    'data' => $this->data,
                    'msg' => $this->msg,
                ];
        return $content;
    }

    /**
     * 结果输出
     */
    public function output() {
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setJsonContent($this->getContent());
        $this->response->send();
    }

    /**
     * 根据状态码调整Http响应状态码
     */
    public function adjustHttpStatus() {
        $httpStatus = array ( 
            100 => 'HTTP/1.1 100 Continue', 
            101 => 'HTTP/1.1 101 Switching Protocols', 
            200 => 'HTTP/1.1 200 OK', 
            201 => 'HTTP/1.1 201 Created', 
            202 => 'HTTP/1.1 202 Accepted', 
            203 => 'HTTP/1.1 203 Non-Authoritative Information', 
            204 => 'HTTP/1.1 204 No Content', 
            205 => 'HTTP/1.1 205 Reset Content', 
            206 => 'HTTP/1.1 206 Partial Content', 
            300 => 'HTTP/1.1 300 Multiple Choices', 
            301 => 'HTTP/1.1 301 Moved Permanently', 
            302 => 'HTTP/1.1 302 Found', 
            303 => 'HTTP/1.1 303 See Other', 
            304 => 'HTTP/1.1 304 Not Modified', 
            305 => 'HTTP/1.1 305 Use Proxy', 
            307 => 'HTTP/1.1 307 Temporary Redirect', 
            400 => 'HTTP/1.1 400 Bad Request', 
            401 => 'HTTP/1.1 401 Unauthorized', 
            402 => 'HTTP/1.1 402 Payment Required', 
            403 => 'HTTP/1.1 403 Forbidden', 
            404 => 'HTTP/1.1 404 Not Found', 
            405 => 'HTTP/1.1 405 Method Not Allowed', 
            406 => 'HTTP/1.1 406 Not Acceptable', 
            407 => 'HTTP/1.1 407 Proxy Authentication Required', 
            408 => 'HTTP/1.1 408 Request Time-out', 
            409 => 'HTTP/1.1 409 Conflict', 
            410 => 'HTTP/1.1 410 Gone', 
            411 => 'HTTP/1.1 411 Length Required', 
            412 => 'HTTP/1.1 412 Precondition Failed', 
            413 => 'HTTP/1.1 413 Request Entity Too Large', 
            414 => 'HTTP/1.1 414 Request-URI Too Large', 
            415 => 'HTTP/1.1 415 Unsupported Media Type', 
            416 => 'HTTP/1.1 416 Requested range not satisfiable', 
            417 => 'HTTP/1.1 417 Expectation Failed', 
            500 => 'HTTP/1.1 500 Internal Server Error', 
            501 => 'HTTP/1.1 501 Not Implemented', 
            502 => 'HTTP/1.1 502 Bad Gateway', 
            503 => 'HTTP/1.1 503 Service Unavailable', 
            504 => 'HTTP/1.1 504 Gateway Time-out',
            505 => 'HTTP/1.1 505 HTTP Version not supported',  
        );

        $this->msg = isset($httpStatus[$this->ret]) ? $httpStatus[$this->ret] : "HTTP/1.1 {$this->ret} API Unknown Status";
    }

}
