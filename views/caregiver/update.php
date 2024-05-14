<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Listaassistiti */

$this->title = Yii::t('app', 'Aggiorna assistito: {name}', [
    'name' => $model->id_caregiver,
]);
$this->params['breadcrumbs'][] = ['label' => 'Lista assistiti', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_caregiver, 'url' => ['view', 'id_caregiver' => $model->id_caregiver, 'id_utente' => $model->id_utente]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="listaassistiti-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
