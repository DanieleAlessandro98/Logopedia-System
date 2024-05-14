<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin()?>

Inserisci il codice fiscale dell'utente che vuoi associare alla lista dei tuoi pazienti.<br><br>
<?= $form->field($model, 'codice_fiscale') ?>

<div class="form-group">
    <?= Html::submitButton('Aggiungi', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>
