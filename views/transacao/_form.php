<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Transacao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo')->textInput() ?>

    <?= $form->field($model, 'data_hora')->textInput() ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'conta_origem_numero')->widget(Select2::class, [
        'data' =>  ArrayHelper::map(
            array_filter(
                (new Query())->select(['cliente_id' => 'id', 'nome' => 'nome'])
                    ->from('banco.cliente')->all(),
            ),
            'cliente_id',
            'nome'
        ),
        'hideSearch' => true,
        'options' => ['placeholder' => 'Selecione a conta de origem...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'conta_destino_numero')->widget(Select2::class, [
        'data' =>  ArrayHelper::map(
            array_filter(
                (new Query())->select(['cliente_id' => 'id', 'nome' => 'nome'])
                    ->from('banco.cliente')->all(),
            ),
            'cliente_id',
            'nome'
        ),
        'hideSearch' => true,
        'options' => ['placeholder' => 'Selecione a conta de destino...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>