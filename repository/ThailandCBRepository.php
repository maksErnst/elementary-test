<?php

namespace app\repository;

class ThailandCBRepository extends BasicRepository
{
    public $period;
    public $name;
    public $value;


    public function rules()
    {
        return [
            [['name', 'value'], 'safe'],
        ];
    }

    public static function findAll()
    {
        $start_period = '2023-11-24';
        $end_period = '2023-11-24';
        $endpoint = 'https://apigw1.bot.or.th/bot/public/Stat-ExchangeRate/v2/DAILY_AVG_EXG_RATE/?start_period=' . $start_period . '&end_period='. $end_period ;

        $dataArray = json_decode(self::fetchData($endpoint, true)->getBody(), true);

        if (!empty($dataArray['result']['data']['data_detail'])) {
            $models = [];

            foreach ($dataArray['result']['data']['data_detail'] as $data) {
                $model = new self();
                $model->name = $data['currency_name_eng'];
                $model->value = $data['mid_rate'];

                $models[] = $model;
            }

            return $models;
        }

        return null;
    }
}