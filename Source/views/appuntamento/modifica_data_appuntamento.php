<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Appuntamento */

$this->title = 'Modifica data Appuntamento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Appuntamenti', 'url' => ['lista_appuntamenti']];
$this->params['breadcrumbs'][] = ['label' => 'Appuntamento numero: ' . $model->id, 'url' => ['visualizza_appuntamento', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modifica data Appuntamento';
?>
<div class="appuntamento-modifica-data">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data')->input('datetime-local');?>

    <div class="form-group">
        <?= Html::submitButton('Modifica', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
