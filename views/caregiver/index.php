<?php

use app\models\Listaassistiti;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ListaAssistitiRicerca */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lista assistiti');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="listaassistiti-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Aggiungi assistito'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nome',
            'cognome',
            'codice_fiscale',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Listaassistiti $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_caregiver' => $model->id_caregiver, 'id_utente' => $model->id_utente]);
                 }
            ],
        ],
    ]); ?>


</div>
