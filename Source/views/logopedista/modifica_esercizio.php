<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div>

    <?php $form = ActiveForm::begin([
        'id' => 'esercizio_form_generico',
        'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tipologia')->dropDownList([
            'denominazione' => 'Denominazione immagini',
            'coppie' => 'Coppie minime',
            'ripetizione' => 'Ripetizione parole',
        ]) ?>

    <?php ActiveForm::end(); ?>


    <?php $form = ActiveForm::begin([
        'id' => 'denominazione_form',
        'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
    <div id="tipologia-denominazione" class="form-tipologia">
        <?= $form->field($modelDenominazione, 'file')->fileInput() ?>
        <div class="form-group">
            <?= Html::submitButton('Modifica Denominazione', ['class' => 'btn btn-success']) ?>
        </div>
    </div>



    <?php ActiveForm::end(); ?>


    <?php $form = ActiveForm::begin([
        'id' => 'coppie_form',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
        <div id="tipologia-coppie" class="form-tipologia" style="display: none">
            <?= $form->field($modelCoppie, 'file1')->fileInput() ?>
            <?= $form->field($modelCoppie, 'file2')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Modifica Coppie', ['class' => 'btn btn-success']) ?>
            </div>
        </div>



    <?php ActiveForm::end(); ?>


    <?php $form = ActiveForm::begin([
        'id' => 'ripetizione_form',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div id="tipologia-ripetizione" class="form-tipologia" style="display: none">
        <?= $form->field($modelRipetizione, 'parola_1')->textInput(['maxlength' => true]) ?>
        <?= $form->field($modelRipetizione, 'parola_2')->textInput(['maxlength' => true]) ?>
        <?= $form->field($modelRipetizione, 'parola_3')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Modifica', ['class' => 'btn btn-success']) ?>
        </div>
    </div>



    <?php ActiveForm::end(); ?>



    <?php
    $this->registerJs(
        <<< EOT_JS_CODE

$('#esercizio-tipologia').on('change', function() {
    console.log(this.value); // questo mi da il value dell'opzione selezionata alla selezione di un opzione dal select.
    
    $(".form-tipologia").hide();
    $("#tipologia-" + this.value).show();
  });

EOT_JS_CODE
    );
    ?>


</div>