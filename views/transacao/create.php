<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Transacao $model */

$this->title = 'Criar Transação';
$this->params['breadcrumbs'][] = ['label' => 'Transacões', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
