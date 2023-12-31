<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TipoConta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tipo-conta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
