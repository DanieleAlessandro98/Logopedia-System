<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Utente;

/* @var $this yii\web\View */
/* @var $model app\models\Terapia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="terapia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_utente')->dropDownList(
        ArrayHelper::map(
            Utente::find()
                ->where(['IS NOT','diagnosi', null])
                ->andWhere('NOT EXISTS (SELECT 1 FROM Terapia WHERE id_utente = Utente.id AND stato <> 100)')
                ->all(),
        'id', 'codice_fiscale'), ['prompt'=>'Seleziona']);
    ?>
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salva', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
