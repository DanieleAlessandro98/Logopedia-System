<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Utente;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RicercaUtente */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Utentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Utente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nome',
            'cognome',
            'email:email',
            'codice_fiscale',
            //'id_logopedista',
            //'diagnosi:ntext',
            'disturbo',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Utente $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
