<?php

use app\models\Utente;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Listaassistiti */
/* @var $form yii\widgets\ActiveForm */

$query =  Utente::find()
    ->joinWith('listaAssistiti')
    ->where(['ListaAssistiti.id_caregiver' => null])
    ->all();
?>

<div class="listaassistiti-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'id_utente')->dropDownList(
        ArrayHelper::map($query, 'id', 'codice_fiscale'), ['prompt'=>'Seleziona']);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Aggiungi'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
