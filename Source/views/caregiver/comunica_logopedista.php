<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use app\models\Logopedista;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Comunica con il tuo Logopedista';
$this->params['breadcrumbs'][] = $this->title;

$query_logopedista = Logopedista::find()
    ->joinWith('utenti')
    ->leftJoin('ListaAssistiti', '`Utente`.`id_logopedista` = `Logopedista`.`id`')
    ->where(['ListaAssistiti.id_caregiver' => 5])
    ->andWhere(['IS NOT','Utente.id_logopedista', null ])
    ->all();
?>

<div class="comunica-logopedista">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'comunica-logopedista-form']); ?>

            <?= $form->field($model, 'logopedista')->dropDownList(
                ArrayHelper::map($query_logopedista, 'email', 'email'), ['prompt'=>'Seleziona']);
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