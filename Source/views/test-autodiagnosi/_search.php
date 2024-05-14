<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TestAutodiagnosiRicerca */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-autodiagnosi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'domanda_1') ?>

    <?= $form->field($model, 'domanda_2') ?>

    <?= $form->field($model, 'domanda_3') ?>

    <?= $form->field($model, 'domanda_4') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
