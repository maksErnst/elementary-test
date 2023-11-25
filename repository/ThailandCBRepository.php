<?php

namespace app\repository;

use DateTime;

class ThailandCBRepository extends BasicRepository
{
    public function rules(): array
    {
        return [
            [['name', 'value'], 'safe'],
        ];
    }

    public static function  findAll(): ?array
    {
        $currentDate = new DateTime();

        if ($currentDate->format('N') == 6 || $currentDate->format('N') == 7) {
            $currentDate->modify('last friday');
        }

        $start_period = $currentDate->format('Y-m-d');
        $end_period = $currentDate->format('Y-m-d');
        $endpoint = 'https://apigw1.bot.or.th/bot/public/Stat-ExchangeRate/v2/DAILY_AVG_EXG_RATE/?start_period=' . $start_period . '&end_period='. $end_period ;

        $dataArray = json_decode(self::fetchData($endpoint, true)->getBody(), true);

        $dataDetail = $dataArray['result']['data']['data_detail'] ?? null;

        if ($dataDetail) {
            $models = [];

            foreach ($dataDetail as $data) {
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