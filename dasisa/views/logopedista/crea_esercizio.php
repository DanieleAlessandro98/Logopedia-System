<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/** @var app\models\EsercizioDenominazione $model */
/* @var $form ActiveForm */


$this->title = 'Crea Esercizio';
?>


<div class="creaEsercizio">

    <?php $form = ActiveForm::begin(); ?>

    <div>
        <?= $form->field($model, 'nome') ?>
        <?= $form->field($model, 'tipologia')->dropDownList([
            1 => 'Denominazione immagini',
            2 => 'Coppie minime'
        ],
            ['prompt' => 'Seleziona tipologia']
        ); ?>
        <?= $form->field($model,'file')->fileInput() ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Crea Esercizio', ['class' => 'btn btn-primary signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>




