<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $model app\models\Utente */
?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nome',
            'cognome',
            'email:email',
            'codice_fiscale',
            'id_logopedista',
            'diagnosi:ntext',
            'disturbo',
        ],
    ]) ?>

</div>
