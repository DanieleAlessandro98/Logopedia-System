<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\EsercizioRipetizioneParole $modelRipetizioneParole */
/** @var app\models\Esercizio $model */
?>


<div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div>
        <?= $form->field($model, 'nome') ?>

        <?= $form->field($modelRipetizioneParole, 'parola_1') ?>
        <?= $form->field($modelRipetizioneParole, 'parola_2') ?>
        <?= $form->field($modelRipetizioneParole, 'parola_3') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Crea', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
