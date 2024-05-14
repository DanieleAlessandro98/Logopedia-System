<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RicercaUtente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="utente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'cognome') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'codice_fiscale') ?>

    <?php // echo $form->field($model, 'id_logopedista') ?>

    <?php // echo $form->field($model, 'diagnosi') ?>

    <?php // echo $form->field($model, 'disturbo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
