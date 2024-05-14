<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/** @var app\models\Utente $modelUtente */
/** @var app\models\Account $modelAccount */
/* @var $form ActiveForm */


$this->title = 'Registrazione Utente';
?>


<div class="RegistrazioneUtente">

    <?php $form = ActiveForm::begin(); ?>


        <div id="form-utente">

            <div class="row mt-4">
                <div class="col-12 col-lg-8">
                    <h3 class="mb-3">Registrazione Utente</h3>
                    <?= $form->field($modelAccount, 'username') ?>
                    <?= $form->field($modelAccount, 'password')->passwordInput() ?>
                    <?= $form->field($modelUtente, 'nome') ?>
                    <?= $form->field($modelUtente, 'cognome') ?>
                    <?= $form->field($modelUtente, 'email') ?>
                    <?= $form->field($modelUtente, 'codice_fiscale') ?>
                </div>
            </div>

        </div>

    <div class="form-group">
        <?= Html::submitButton('Registrati', ['class' => 'btn btn-primary signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>




<!-- Registrazione Utente-->


