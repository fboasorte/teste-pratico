<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoTransacao $model */

$this->title = 'Adicionar Tipo de Transação';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Transacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-transacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
