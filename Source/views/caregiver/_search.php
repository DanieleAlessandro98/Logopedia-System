<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ListaAssistitiRicerca */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="listaassistiti-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_caregiver') ?>

    <?= $form->field($model, 'id_utente') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'cognome') ?>

    <?= $form->field($model, 'codice_fiscale') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'cerca'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'riavvia'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
