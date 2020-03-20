<?php

namespace DNAFactory\Framework\Api;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Communicator
{
    protected $_client;
    protected $_target;

    public function __construct()
    {
        $this->_client = new Client();
    }

    public function setTarget($target)
    {
        $this->_target = $target;
    }

    public function call($className, $methodName, $params)
    {
        $url = $this->_target . '/api/rest/' . $className . '/' . $methodName;
        $response = $this->_client->post($url, [
            RequestOptions::JSON => $params
        ]);

        return json_decode($response->getBody());
    }
}