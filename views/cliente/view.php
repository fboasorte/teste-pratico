<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\i18n\Formatter;


/** @var yii\web\View $this */
/** @var app\models\Cliente $model */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$formatter = new Formatter();
?>
<div class="cliente-view">

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
            'nome:ntext',
            'cpf',
            'endereco:ntext',
            [
                'label' => 'Data de Nascimento',
                'format' => 'html',
                'value' => Yii::$app->formatter->asDate($model->nascimento, 'dd/MM/Y'),
            ],
            'telefone',
        ],
    ]) ?>

</div>
