<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\EsercizioCoppieMinime $modelCoppieMinime */
/** @var app\models\Esercizio $model */
?>


<div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div>
        <?= $form->field($model, 'nome') ?>

        <?= $form->field($modelCoppieMinime, 'file1')->fileInput() ?>
        <?= $form->field($modelCoppieMinime, 'file2')->fileInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Crea', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




