<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\Esercizio */

$this->title = "Aggiungi Aiuto all'esercizio numero: " . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Esercizio', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modifica';
?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?=
    $form->field($model, 'tipologia')->dropDownList([
        '0' => 'Denominazione immagini',
        '1' => 'Coppie minime',
        '2' => 'Ripetizione parole',
    ], ['disabled' => 'disabled', 'options' => [ 1 => ['Selected'=>'selected']]]);
    ?>

    <?= $form->field($model, 'aiuto')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Modifica', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>