<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/** @var app\models\Logopedista $modelLogopedista */
/** @var app\models\Account $modelAccount */
/* @var $form ActiveForm */


$this->title = 'Registrazione Logopedista';
?>


<div class="RegistrazioneLogopedista">

    <?php $form = ActiveForm::begin(); ?>


        <div id="form-logopedista">

            <div class="row mt-4">
                <div class="col-12 col-lg-8">
                    <h3 class="mb-3">Registrazione Logopedista</h3>
                    <?= $form->field($modelLogopedista, 'matricola') ?>
                    <?= $form->field($modelAccount, 'username') ?>
                    <?= $form->field($modelAccount, 'password')->passwordInput() ?>
                    <?= $form->field($modelLogopedista, 'nome') ?>
                    <?= $form->field($modelLogopedista, 'cognome') ?>
                    <?= $form->field($modelLogopedista, 'email') ?>
                </div>
            </div>

        </div>

    <div class="form-group">
        <?= Html::submitButton('Registrati', ['class' => 'btn btn-primary signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>


<!-- RegistrazioneLogopedista -->


