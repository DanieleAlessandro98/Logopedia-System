<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form ActiveForm */
?>
<div class="EffettuaAccesso">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row mt-4">
        <div class="col-12 col-lg-8">
            <h3 class="mb-3">Accedi</h3>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Accedi', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- EffettuaAccesso -->