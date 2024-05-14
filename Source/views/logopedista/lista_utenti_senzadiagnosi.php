<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Utente;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RicercaUtente */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista Utenti';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nome',
            'cognome',
            'codice_fiscale',
            'id_logopedista',
            //'diagnosi:ntext',
            'disturbo',


            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update}',
                'urlCreator' => function ($action, Utente $model, $key, $index, $column) {
                    if ($action === 'view') {
                        $url = 'index.php?r=utente/visualizza_utente&utente=' . $model->id;
                        return $url;
                    }
                    if ($action === 'update') {
                        $url = 'index.php?r=logopedista/effettua_diagnosi&utente=' . $model->id;
                        return $url;
                    }

                    return Url::toRoute([$action, 'id' => $model->id]);

                }
            ],
        ],
    ]); ?>


</div>
