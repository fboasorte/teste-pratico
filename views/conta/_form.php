<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\db\Query;

/** @var yii\web\View $this */
/** @var app\models\Conta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="conta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'tipo')->widget(Select2::class, [
        'data' =>  ArrayHelper::map(
            array_filter(
                (new Query())->select(['tipo_conta_id' => 'id', 'nome' => 'nome'])
                    ->from('banco.tipo_conta')->all(),
            ),
            'tipo_conta_id',
            'nome'
        ),
        'hideSearch' => true,
        'options' => ['placeholder' => 'Selecione um tipo de conta...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>

    <?= $form->field($model, 'saldo')->textInput() ?>

    <?=
    $form->field($model, 'cliente_id')->widget(Select2::class, [
        'data' =>  ArrayHelper::map(
            array_filter(
                (new Query())->select(['cliente_id' => 'id', 'nome' => 'nome'])
                    ->from('banco.cliente')->all(),
            ),
            'cliente_id',
            'nome'
        ),
        'hideSearch' => true,
        'options' => ['placeholder' => 'Selecione um cliente...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>