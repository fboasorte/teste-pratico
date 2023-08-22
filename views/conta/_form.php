<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use helpers\BancoHelper;

/** @var yii\web\View $this */
/** @var app\models\Conta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="conta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'tipo_conta_id')->widget(Select2::class, [
        'data' =>  ArrayHelper::map(
            array_filter(
                BancoHelper::tipoContas(),
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
                BancoHelper::clientes()
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