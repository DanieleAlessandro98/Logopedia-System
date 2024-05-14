
<?php

use app\models\Account;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Terapia;


$identity = new Account();

/* @var $this yii\web\View */
/* @var $searchModel app\models\TerapiaRicerca */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Terapie';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="terapia-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea Terapia', ['crea_terapia'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Utente',
                'value' => function ($model) {
                    return $model->utente->nome . ' ' . $model->utente->cognome;
                }
            ],

            [
                'label' => 'Nome Terapia',
                'value' => 'nome'
            ],

            'disturbo',
            'stato',

              !Yii::$app->user->isGuest ? (
        $identity->isCaregiver(Yii::$app->user->identity->ruolo) ? (
            [
                'class' => ActionColumn::className(),

                'template' => '{view}',
                'urlCreator' => function ($action, Terapia $model, $key, $index, $column) {
                    if ($action === 'view')
                        $url = 'index.php?r=terapia/monitora_terapia_utente&id=' . $model->id;
                    else if ($action === 'update')
                        $url = 'index.php?r=terapia/modifica_terapia&id=' . $model->id;
                    else if ($action === 'delete')
                        $url = 'index.php?r=terapia/elimina_terapia&id=' . $model->id;

                    return $url;
                 }
            ]
        ) : ([
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Terapia $model, $key, $index, $column) {
                if ($action === 'view')
                    $url = 'index.php?r=terapia/monitora_terapia_utente&id=' . $model->id;
                else if ($action === 'update')
                    $url = 'index.php?r=terapia/modifica_terapia&id=' . $model->id;
                else if ($action === 'delete')
                    $url = 'index.php?r=terapia/elimina_terapia&id=' . $model->id;

                return $url;
            }
        ])
    ) : ('<div></div>'),

        ],
    ]); ?>


</div>
