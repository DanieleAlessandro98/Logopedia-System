<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\Esercizio */
/* @var $modelDenominazione  app\models\EsercizioDenominazione */

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
        <?= Html::encode('Immagine:') ?>
        <img src="<?= $modelDenominazione->immagine ?>" width="100" height="100" />
    </div>

    <?= $form->field($modelDenominazione, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Modifica', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>