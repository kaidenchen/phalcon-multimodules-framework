<?php

namespace AliyunMNS\Responses;

use AliyunMNS\Common\XMLParser;
use AliyunMNS\Exception\MnsException;

class DeleteQueueResponse extends BaseResponse
{
    public function __construct()
    {
    }

    public function parseResponse($statusCode, $content)
    {
        $this->statusCode = $statusCode;
        if ($statusCode == 204) {
            $this->succeed = true;
        } else {
            $this->parseErrorResponse($statusCode, $content);
        }
    }

    public function parseErrorResponse($statusCode, $content, MnsException $exception = null)
    {
        $this->succeed = false;
        $xmlReader     = $this->loadXmlContent($content);

        try {
            $result = XMLParser::parseNormalError($xmlReader);
            throw new MnsException($statusCode, $result['Message'], $exception, $result['Code'], $result['RequestId'], $result['HostId']);
        } catch (\Exception $e) {
            if ($exception != null) {
                throw $exception;
            } elseif ($e instanceof MnsException) {
                throw $e;
            } else {
                throw new MnsException($statusCode, $e->getMessage());
            }
        } catch (\Throwable $t) {
            throw new MnsException($statusCode, $t->getMessage());
        }
    }
}
