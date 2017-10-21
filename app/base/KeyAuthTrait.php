<?php

namespace App;

trait KeyAuthTrait
{
    /**
     * @brief keyAuth 
     *
     * @return 
     */
    public function keyAuthenticate()
    {
        $di = \phalcon\DI\FactoryDefault::getDefault();

        $apiKeyList = $di->getConfig()['apiKeyList'];

        $apiKey = $di->getRequest()->getHeader('apikey');
        if ( !$apiKey ) {
        }

        if ( !array_key_exists($apiKeyList, $apiKey) ) {
        }
    }


}
