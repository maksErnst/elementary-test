<?php
use yii\helpers\Html;
?>

<?= Html::dropDownList('source', null, [
    'thailand-wallets' => 'ЦБ Тайланда',
    'russia-wallets' => 'ЦБ РФ',
], [
    'id' => 'source-selector',
    'prompt' => 'Выберите источник',
    'class' => 'form-control',
    'style' => 'margin: 20px',
]) ?>

<div id="loading-spinner" class="loading"></div>
<div id="ajax-content"></div>
