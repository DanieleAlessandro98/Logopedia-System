<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TestAutodiagnosi */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="test-autodiagnosi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'domanda_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'domanda_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'domanda_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'domanda_4')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Compila', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
