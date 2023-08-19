<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Conta $model */

$this->title = 'Adicionar Conta';
$this->params['breadcrumbs'][] = ['label' => 'Contas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
