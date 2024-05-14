<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/** @var app\models\Caregiver $modelCaregiver */
/** @var app\models\Account $modelAccount */
/* @var $form ActiveForm */


$this->title = 'Registrazione Caregiver';
?>


<div class="RegistrazioneCaregiver">

    <?php $form = ActiveForm::begin(); ?>


        <div id="form-caregiver">
            <h3>Registrazione Caregiver</h3>
            <?= $form->field($modelAccount, 'username') ?>
            <?= $form->field($modelAccount, 'password')->passwordInput() ?>
            <?= $form->field($modelCaregiver, 'nome') ?>
            <?= $form->field($modelCaregiver, 'cognome') ?>
            <?= $form->field($modelCaregiver, 'email') ?>
            <?= $form->field($modelCaregiver, 'codice_fiscale') ?>



        </div>

    <div class="form-group">
        <?= Html::submitButton('Registrati', ['class' => 'btn btn-primary signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>




<!-- Registrazione Caregiver -->


