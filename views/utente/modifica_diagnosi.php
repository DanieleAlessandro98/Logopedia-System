<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/** @var app\models\Utente $model */
/* @var $form ActiveForm */

$this->title = 'Effettua Diagnosi';

?>


<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'disturbo') ?>
        <?= $form->field($model, 'diagnosi')->textarea(['rows' => '4']) ?>
        <div class="form-group">
            <?= Html::submitButton('Salva Utente', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>


</div>