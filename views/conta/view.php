<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Conta $model */

$this->title = $model->numero;
$this->params['breadcrumbs'][] = ['label' => 'Contas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="conta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'numero' => $model->numero], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Deletar', ['delete', 'numero' => $model->numero], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => ' Deseja realmente excluir este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numero',
            'tipo',
            'saldo',
            'cliente_id',
        ],
    ]) ?>

</div>
