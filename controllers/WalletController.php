<?php

namespace app\controllers;

use app\repository\RFCBRepository;
use app\repository\ThailandCBRepository;
use yii\filters\AccessControl;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class WalletController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['thailand-wallets', 'russia-wallets'],
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionThailandWallets(): string
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('Page not found');
        }

        $data = $this->prepareCache('thailand');

        return $this->renderPartial('index', ['data' => $data]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionRussiaWallets(): string
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('Page not found');
        }

        $data = $this->prepareCache('russia');

        return $this->renderPartial('index', ['data' => $data]);
    }

    private function prepareCache(string $source)
    {
        $cache = Yii::$app->cache;
        $cacheKey = 'allCurrencies_' . $source;
        $cacheKeyReserve = 'lastCurrencies_' . $source;

        $currencies = $cache->get($cacheKey);

        if ($currencies === false) {
            $currencies = match ($source) {
                'thailand' => ThailandCBRepository::findAll(),
                'russia' =>  RFCBRepository::findAll(),
                default => null,
            };
            if (is_array($currencies)) {
                $currenciesData = [];
                foreach ($currencies as $currency) {
                    $currenciesData[] = $currency->attributes;
                }

                $cache->set($cacheKey, $currenciesData, 12 * 3600);
                $cache->set($cacheKeyReserve, $currenciesData, 30 * 24 * 3600);
            } else {
                $currencies = $cache->get($cacheKeyReserve);
            }
        }

        return $currencies;
    }
}