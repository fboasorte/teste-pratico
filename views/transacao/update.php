<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Transacao $model */

$this->title = 'Update Transacao: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
