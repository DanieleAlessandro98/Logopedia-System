<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Modifica esercizio numero: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Esercizio', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modifica';
?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php include 'modifica_esercizio.php'; ?>

    <div>
        <?= $form->field($modelRipetizione, 'parola_1')->textInput(['maxlength' => true]) ?>
    </div>

    <div>
        <?= $form->field($modelRipetizione, 'parola_2')->textInput(['maxlength' => true]) ?>
    </div>

    <div>
        <?= $form->field($modelRipetizione, 'parola_3')->textInput(['maxlength' => true]) ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Modifica', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>