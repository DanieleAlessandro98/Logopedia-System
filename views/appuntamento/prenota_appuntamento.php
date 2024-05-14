<?php

use yii\helpers\Html;
use app\models\Utente;
use app\models\Logopedista;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Appuntamento */

$this->title = 'Prenota Appuntamento';
$this->params['breadcrumbs'][] = ['label' => 'Appuntamenti', 'url' => ['lista_appuntamenti']];
$this->params['breadcrumbs'][] = $this->title;

$query_utente =  Utente::find()
    ->joinWith('listaAssistiti')
    ->where(['ListaAssistiti.id_caregiver' => Yii::$app->user->identity->id])
    ->all();

    $query_logopedista =  Logopedista::find()
    ->joinWith('utenti')
    ->leftJoin('ListaAssistiti', '`Utente`.`id_logopedista` = `Logopedista`.`id`')
    ->where(['ListaAssistiti.id_caregiver' => Yii::$app->user->identity->id])
    ->andWhere(['IS NOT','Utente.id_logopedista', null ])
    ->all();
?>

<div class="appuntamento-prenota">

    <h1 class="mb-3"> Prenota Appuntamento </h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_utente')->dropDownList(
        ArrayHelper::map($query_utente, 'id', 'codice_fiscale'), ['prompt'=>'Seleziona']);
    ?>

    <?= $form->field($model, 'id_logopedista')->dropDownList(
        ArrayHelper::map($query_logopedista, 'id', 'nome'), ['prompt'=>'Seleziona']);
    ?>

    <?= $form->field($model, 'data')->input('datetime-local');?>

    <div class="form-group">
        <?= Html::submitButton('Prenota appuntamento', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
