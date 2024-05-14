<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use app\models\ListaEserciziTerapia;

/* @var $this yii\web\View */
/* @var $model app\models\Terapia */
/* @var $searchModel app\models\TerapiaRicerca */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProvider2 yii\data\ActiveDataProvider */

$this->title = 'Terapia id: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Terapie', 'url' => ['controller/UtenteController']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
    <div class="terapia-view">

    <h1><?= Html::encode($this->title) ?></h1>


<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'nome',
        'disturbo',
        'stato',
    ],
]) ?>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => null,
            'layout' => '{items}{pager}',
            'columns' => [
                [
                    'label' => 'Esercizi',
                    'value' => 'nome',
                ],
                [
                    'label' => 'Assegnato in data',
                    'value' => 'giorno',
                ],

            ],
        ]); ?>


