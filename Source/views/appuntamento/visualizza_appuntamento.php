<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Appuntamento */

$this->title = 'Appuntamento numero: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Appuntamenti', 'url' => ['lista_appuntamenti']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="appuntamento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Caregiver',
                'value' => $model->caregiver->nome . ' ' . $model->caregiver->cognome
            ],

            [
                'label' => 'Logopedista',
                'value' => $model->logopedista->nome . ' ' . $model->logopedista->cognome
            ],

            [
                'label' => 'Utente',
                'value' => $model->utente->nome . ' ' . $model->utente->cognome
            ],

            [
                'label' => 'Data',
                'value' => function ($model) {
                    return $model->getData();
                }
            ],
            
            [
                'label' => 'Stato',
                'value' => function ($model) {
                    return $model->getStato();
                }
            ],
        ],
    ]) ?>

</div>
