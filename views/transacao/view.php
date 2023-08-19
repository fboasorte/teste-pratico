<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Transacao $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transacões', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="transacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja realmente excluir este item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Tipo',
                'format' => 'html',
                'value' => $model->tipoTransacao->nome,
            ],
            [
                'attribute' => 'data_hora',
                'value' => static function ($model) {
                    return Yii::$app->formatter->asDate($model->data_hora, 'dd/MM/Y H:mm');
                },
                'label' => 'Data/Hora',
                'options' => ['style' => 'width:10%'],
            ],
            [
                'attribute' => 'valor',
                'value' => static function ($model) {
                    return 'R$ ' . number_format((float)$model->valor, 2, '.', '');
                },
            ],
            [
                'attribute' => 'conta_origem_numero',
                'value' => static function ($model) {
                    return $model->conta_origem_numero . ' / ' . $model->contaOrigem->cliente->nome;
                },
            ],
            [
                'attribute' => 'conta_destino_numero',
                'value' => static function ($model) {
                    return $model->conta_destino_numero . ' / ' . $model->contaDestino->cliente->nome;
                },
            ],
        ],
    ]) ?>

</div>