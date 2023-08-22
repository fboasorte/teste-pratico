<?php

use app\models\Conta;
use helpers\BancoHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\ContaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Contas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adicionar Conta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'numero',
            [
                'attribute' => 'tipo_conta_id',
                'label'     => 'Tipo de Conta',
                'value' => 'tipoConta.nome',
                'filter' => ArrayHelper::map(
                    array_filter(
                        BancoHelper::tipoContas()
                    ),
                    'tipo_conta_id',
                    'nome'
                )
            ],
            [
                'attribute' => 'saldo',
                'value' => static function ($dataProvider) {
                    return 'R$ ' . number_format((float)$dataProvider->saldo, 2, '.', '');
                },
            ],
            [
                'attribute' => 'cliente',
                'label'     => 'Cliente',
                'value' => 'cliente.nome',
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Conta $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'numero' => $model->numero]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
