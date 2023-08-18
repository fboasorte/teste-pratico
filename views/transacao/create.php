<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Transacao $model */

$this->title = 'Create Transacao';
$this->params['breadcrumbs'][] = ['label' => 'Transacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
