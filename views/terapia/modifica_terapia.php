<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Terapia */

$this->title = 'Modifica Terapia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Terapie', 'url' => ['monitora_terapie_utenti']];
$this->params['breadcrumbs'][] = ['label' => 'Terapia numero: ' . $model->id, 'url' => ['visualizza_terapia', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modifica';
?>
<div class="terapia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Assegna Esercizi', ['esercizio/assegna_esercizio', 'id_terapia' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Rimuovi Esercizi', ['esercizio/rimuovi_esercizio', 'id_terapia' => $model->id], ['class' => 'btn btn-danger']) ?>
    </p>

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Salva Terapia', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
