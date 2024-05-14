<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Utente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="utente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cognome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codice_fiscale')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_logopedista')->textInput() ?>

    <?= $form->field($model, 'diagnosi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'disturbo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
