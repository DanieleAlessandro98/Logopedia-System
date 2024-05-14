<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\Esercizio */
/* @var $modelCoppieMinime  app\models\EsercizioCoppieMinime */

$this->title = 'Crea Esercizio';
$this->params['breadcrumbs'][] = ['label' => 'Esercizio', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div>
        <?php include '_form_esercizio.php'; ?>

        <?= $form->field($modelCoppieMinime, 'file_registrazione')->fileInput() ?>
        <?= $form->field($modelCoppieMinime, 'file1')->fileInput() ?>
        <?= $form->field($modelCoppieMinime, 'file2')->fileInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Crea', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




