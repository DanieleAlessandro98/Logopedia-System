<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Lista esercizi da convalidare';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="lista-esercizi-svolti">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'esercizio.nome',
            'esercizio.tipologia',
            [
                'class' => ActionColumn::className(),
                'template' => ' {convalida}',
                'buttons' => [
                    'convalida' => function ($url, $model, $key) {
                        return Html::a(
                            'Convalida esercizio',
                            ['convalida_esercizio', 'id_esercizio' => $model->esercizio->id, 'id_esercizio_svolto' => $model->id],
                            ['class' => 'btn btn-primary']
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>