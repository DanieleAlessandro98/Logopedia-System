<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Listaassistiti */

$this->title = $model->id_caregiver;
$this->params['breadcrumbs'][] = ['label' => 'Lista assistiti', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="listaassistiti-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id_caregiver' => $model->id_caregiver, 'id_utente' => $model->id_utente], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id_caregiver' => $model->id_caregiver, 'id_utente' => $model->id_utente], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_caregiver',
            'id_utente',
            'nome',
            'cognome',
            'codice_fiscale',
        ],
    ]) ?>

</div>
