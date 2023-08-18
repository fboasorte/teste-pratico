<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Conta $model */

$this->title = 'Update Conta: ' . $model->numero;
$this->params['breadcrumbs'][] = ['label' => 'Contas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->numero, 'url' => ['view', 'numero' => $model->numero]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="conta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
