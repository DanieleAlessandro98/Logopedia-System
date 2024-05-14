<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use app\models\Caregiver;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Comunica con un tuo Caregiver';
$this->params['breadcrumbs'][] = $this->title;

$query_caregiver = Caregiver::find()
    ->joinWith('utente')
    ->leftJoin('Logopedista', '`Utente`.`id_logopedista` = `Logopedista`.`id`')
    ->where(['Logopedista.id' => 1])
    ->all();
?>

<div class="comunica-logopedista">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'comunica-logopedista-form']); ?>

            <?= $form->field($model, 'destinatario')->dropDownList(
                ArrayHelper::map($query_caregiver, 'email', 'email'), ['prompt'=>'Seleziona']);
            ?>

            <?= $form->field($model, 'oggetto') ?>

            <?= $form->field($model, 'testo')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Invia Email', ['class' => 'btn btn-primary', 'name' => 'comunica-logopedista-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>