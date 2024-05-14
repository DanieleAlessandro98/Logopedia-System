<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $model app\models\Esercizio */
/* @var $modelCoppie  app\models\EsercizioCoppieMinime */

$this->title = 'Modifica esercizio numero: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Esercizio', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modifica';
?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php include 'modifica_esercizio.php'; ?>

    <audio controls>
        <source src=" , <?= $modelCoppie->descrizione_vocale ?>"  type='audio/mp3'>
        Your browser does not support the audio element.
    </audio>
    <div>
        <?= Html::encode('Immagine1:') ?>
        <img src="<?= $modelCoppie->immagine_1 ?>" width="100" height="100" />
    </div>

    <div>
        <?= Html::encode('Immagine2:') ?>
        <img src="<?= $modelCoppie->immagine_2 ?>" width="100" height="100" />
    </div>

    <?= $form->field($modelCoppie, 'file_registrazione')->fileInput() ?>
    <?= $form->field($modelCoppie, 'file1')->fileInput() ?>
    <?= $form->field($modelCoppie, 'file2')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Modifica', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>