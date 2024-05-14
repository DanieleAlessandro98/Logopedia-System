<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\EsercizioDenominazione $modelDenominazione */
/** @var app\models\Esercizio $model */
?>

<div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div>
        <?= $form->field($model, 'nome') ?>

        <?= $form->field($modelDenominazione, 'file')->fileInput() ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Crea', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




