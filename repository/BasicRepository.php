<?php

namespace app\repository;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Yii;
use yii\base\Model;

class BasicRepository extends Model
{
    public string $name;
    public string $value;

    private static string $api_key = 'X-IBM-Client-Id';
    private static string $key_value = 'c2bbe063-d0ff-456c-bc08-fbd5115fb340';

    protected static function fetchData($endpoint, $auth): \Psr\Http\Message\ResponseInterface
    {
        $client = new Client();
        $options = [];

        if ($auth) {
            $options['headers'][self::$api_key] = self::$key_value;
            $options['headers']['Accept'] = 'application/json';
        }
        try {
            return $client->get($endpoint, $options);
        } catch (ClientException $e) {
            $response = $e->getResponse();

            http_response_code($response->getStatusCode());
            echo json_encode(['error' => $response->getReasonPhrase()]);
            exit();
        }

    }

}