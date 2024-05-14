<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Svolgi Esercizi giornalieri';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="esercizio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'nome',
            'tipologia',
            [
                'class' => ActionColumn::className(),
                'template' => ' {svolgi}',
                'buttons' => [
                    'svolgi' => function ($url, $model, $key) {
                        return Html::a(
                            'Svolgi esercizio',
                            ['svolgi_esercizio', 'id' => $model->id],
                            ['class' => 'btn btn-primary']
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>