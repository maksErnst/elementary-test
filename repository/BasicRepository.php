<?php

namespace app\repository;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\base\Model;

class BasicRepository extends Model
{
    protected static $instance;
    private string $api_key = 'X-IBM-Client-Id';
    private string $key_value = 'c2bbe063-d0ff-456c-bc08-fbd5115fb340';

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }



    public static function fetchData($endpoint, $auth = false)
    {
        return self::getInstance()->fetchDataInternal($endpoint, $auth);
    }

    /**
     * @throws GuzzleException
     */

    private function apiBase(): Client
    {
        return new Client([
        ]);
    }

    protected function fetchDataInternal($endpoint, $auth)
    {
        $client = new Client();
        $options = [];

        if ($auth) {
            $options['headers'][$this->api_key] = $this->key_value;
            $options['headers']['Accept'] = 'application/json';
        }

        return $this->apiBase()->get($endpoint, $options);
    }

}