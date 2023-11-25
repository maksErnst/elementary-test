<?php

use yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-6">
        <?= Html::dropDownList('currency1', null, array_column($data, 'name', 'value'), ['prompt' => 'Выберите конвертируемую валюту', 'class' => 'form-control', 'style' => 'width: 350px;',]) ?>
    </div>

    <div class="col-md-6">
        <?= Html::dropDownList('currency2', null, array_column($data, 'name', 'value'), ['prompt' => 'Выберите конечную валюту', 'class' => 'form-control', 'style' => 'width: 350px;',]) ?>
    </div
</div>

<div class="row">
    <?= Html::label('Введите сумму', 'wallet_sum') ?>
    <?= Html::textInput('wallet_sum', null, ['id' => 'wallet_sum', 'class' => 'form-control', 'style' => 'width: 150px; margin: 20px;',]) ?>
</div>

<div>
    <?= Html::button('Конвертировать', ['id' => 'convert', 'class' => 'btn btn-primary', 'style' => 'width: 150px; margin: 20px;']) ?>
</div>

<?= Html::label('Результат', 'result') ?>
<?= Html::textInput('result', null, ['id' => 'result', 'class' => 'form-control', 'style' => 'width: 150px; margin: 20px;',]) ?>

