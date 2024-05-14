<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use app\models\Account;
use app\models\Caregiver;
use app\models\Logopedista;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$identity = new Account();

if (Yii::$app->user->isGuest == False && $identity->isLogopedista(Yii::$app->user->identity->ruolo))
    $this->title = 'Comunica con un tuo Caregiver';
elseif (Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo))
    $this->title = 'Comunica con il tuo Logopedista';

$this->params['breadcrumbs'][] = $this->title;

$query_logopedista = Logopedista::find()
    ->joinWith('utenti')
    ->leftJoin('ListaAssistiti', '`Utente`.`id_logopedista` = `Logopedista`.`id`')
    ->where(['ListaAssistiti.id_caregiver' => Yii::$app->user->identity->id])
    ->andWhere(['IS NOT','Utente.id_logopedista', null])
    ->all();

$query_caregiver = Caregiver::find()
    ->joinWith('utente')
    ->leftJoin('Logopedista', '`Utente`.`id_logopedista` = `Logopedista`.`id`')
    ->where(['Logopedista.id' => Yii::$app->user->identity->id])
    ->all();
?>

<div class="comunica">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'comunica-form']); ?>

            <?php if (Yii::$app->user->isGuest == False && $identity->isLogopedista(Yii::$app->user->identity->ruolo)) : ?>
                <?= $form->field($model, 'destinatario')->dropDownList(
                    ArrayHelper::map($query_caregiver, 'email', 'email'), ['prompt'=>'Seleziona']);
                ?>
            <?php elseif (Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo)) : ?>
                <?= $form->field($model, 'destinatario')->dropDownList(
                    ArrayHelper::map($query_logopedista, 'email', 'email'), ['prompt'=>'Seleziona']);
                ?>
            <?php endif; ?>

            <?= $form->field($model, 'oggetto') ?>

            <?= $form->field($model, 'testo')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Invia Email', ['class' => 'btn btn-primary', 'name' => 'comunica-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>