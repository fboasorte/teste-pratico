<?php

use app\models\Cliente;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\ClienteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adicionar Cliente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= 
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'nome:ntext',
            'cpf',
            'endereco:ntext',
            [
                'attribute' => 'nascimento',
                'filter' => DatePicker::widget([
                    'value'  => $searchModel->nascimento,
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'name' => 'ClienteSearch[nascimento]',
                    'pluginOptions' => [
                        'autoclose' => true,
                    ]
                ]),
                'value' => static function ($dataProvider) {
                    return $dataProvider->nascimento ? Yii::$app->formatter->asDate($dataProvider->nascimento, 'dd/MM/Y') : 'Não definido';
                },
                'label' => 'Data de Nascimento',
                'options' => ['style' => 'width:10%'],
            ],
            'telefone',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Cliente $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
