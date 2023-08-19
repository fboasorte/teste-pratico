<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoConta $model */

$this->title = 'Adicionar Tipo de Conta';
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Contas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-conta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
