<?php

namespace app\repository;

class RFCBRepository extends BasicRepository
{
    public function rules(): array
    {
        return [
            [['name', 'value'], 'safe'],
        ];
    }

    public static function findAll(): ?array
    {

        $endpoint = 'http://www.cbr.ru/scripts/XML_daily.asp';

        $dataArray = self::fetchData($endpoint, true)->getBody()->getContents();

        $xml = simplexml_load_string($dataArray);

        if ($xml !== false) {
            $date = (string)$xml['Date'];
            $models = [];

            foreach ($xml->Valute as $valute) {
                $model = new self();
                $model->name = (string)$valute->Name;
                $model->value = (string)str_replace(',', '.', (string)$valute->Value);

                $models[] = $model;
            }

            return $models;
        }

        return null;
    }
}