<?php

use app\models\Transacao;
use lib\helpers\BancoHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\TransacaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Transações';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transacao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adicionar Transação', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'tipo_transacao_id',
                'label'     => 'Tipo de Transação',
                'value' => 'tipoTransacao.nome',
                'filter' => ArrayHelper::map(
                    array_filter(
                        BancoHelper::tipoTransacoes(),
                    ),
                    'tipo_transacao_id',
                    'nome'
                )
            ],
            [
                'attribute' => 'data_hora',
                'filter' => DatePicker::widget([
                    'value'  => $searchModel->data_hora,
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'name' => 'TransacaoSearch[data_hora]',
                    'pluginOptions' => [
                        'autoclose' => true,
                    ]
                ]),
                'value' => static function ($dataProvider) {
                    return Yii::$app->formatter->asDate($dataProvider->data_hora, 'dd/MM/Y H:mm');
                },
                'label' => 'Data/Hora',
                'options' => ['style' => 'width:10%'],
            ],
            [
                'attribute' => 'valor',
                'value' => static function ($dataProvider) {
                    return 'R$ ' . number_format((float)$dataProvider->valor, 2, '.', '');
                },
            ],
            [
                'attribute' => 'conta_origem_numero',
                'value' => static function ($dataProvider) {
                    return $dataProvider->conta_origem_numero . ' / ' . $dataProvider->contaOrigem->cliente->nome;
                },
            ],
            [
                'attribute' => 'conta_destino_numero',
                'value' => static function ($dataProvider) {
                    return $dataProvider->conta_destino_numero . ' / ' . $dataProvider->contaDestino->cliente->nome;
                },
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Transacao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>