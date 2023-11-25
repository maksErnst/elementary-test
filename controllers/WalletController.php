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
    public function behaviors()
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

    public function actionThailandWallets()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('Page not found');
        }

        $data = $this->prepareCache('thailand');

        return $this->renderPartial('index', ['data' => $data]);
    }

    public function actionRussiaWallets()
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
        $currencies = $cache->get($cacheKey);

        if ($currencies === false) {
            // Выбираем репозиторий в зависимости от источника
            switch ($source) {
                case 'thailand':
                    $currencies = ThailandCBRepository::findAll();
                    break;
                case 'russia':
                    $currencies = RFCBRepository::findAll();
                    break;
                default:

                    $currencies = null;
            }

            $currenciesData = [];
            foreach ($currencies as $currency) {
                $currenciesData[] = $currency->attributes;
            }

            $cache->set($cacheKey, $currenciesData, 12 * 3600);
        }

        return $currencies;
    }
}