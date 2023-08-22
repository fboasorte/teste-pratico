<?php

use helpers\BancoHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\file\FileInput;

/** @var yii\web\View $this */
/** @var app\models\Transacao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transacao-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?=
    $form->field($model, 'tipo_transacao_id')->widget(Select2::class, [
        'data' =>  ArrayHelper::map(
            array_filter(
                BancoHelper::tipoTransacoes()
            ),
            'tipo_transacao_id',
            'nome'
        ),
        'hideSearch' => true,
        'options' => ['placeholder' => 'Selecione o tipo de transação...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'conta_origem_numero')->widget(Select2::class, [
        'data' =>  ArrayHelper::map(
            array_filter(
                BancoHelper::contas()
            ),
            'conta_numero',
            'nome'
        ),
        'hideSearch' => true,
        'options' => ['placeholder' => 'Selecione a conta de origem...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <?=
    $form->field($model, 'conta_destino_numero')->widget(Select2::class, [
        'data' =>  ArrayHelper::map(
            array_filter(
                BancoHelper::contas()
            ),
            'conta_numero',
            'nome'
        ),
        'hideSearch' => true,
        'options' => ['placeholder' => 'Selecione a conta de destino...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'comprovante')->widget(FileInput::class);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>