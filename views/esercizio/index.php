<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Esercizio;
use app\models\Account;
use yii\bootstrap4\ButtonDropdown;

$identity = new Account();

/* @var $this yii\web\View */
/* @var $searchModel app\models\EsercizioRicerca */
/* @var $dataProvider yii\data\ActiveDataProvider */

if ($terapia_id == -1) :
    $this->title = 'Lista Esercizi';
    $this->params['breadcrumbs'][] = $this->title;

 elseif ($terapia_id !== -1) :
    $this->title = 'Terapia numero: ' . $terapia_id;
    $this->params['breadcrumbs'][] = ['label' => 'Terapie', 'url' => ['terapia/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Terapia numero: ' . $terapia_id, 'url' => ['terapia/visualizza_terapia', 'id' => $terapia_id]];

    if ($aggiungi == true) :
        $this->params['breadcrumbs'][] = 'Assegna Esercizi';
    elseif ($aggiungi == false) :
        $this->params['breadcrumbs'][] = 'Rimuovi Esercizi';
    endif;
endif;

?>
<div class="esercizio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">

        <div class="col-12 d-flex justify-content-end">
            <?= !Yii::$app->user->isGuest ? (

                $identity->isLogopedista(Yii::$app->user->identity->ruolo) ? (ButtonDropdown::widget([
                    'label' => 'Crea Esercizio',
                    'buttonOptions' => ['class' => 'btn-primary'],
                    'dropdown' => [
                        'items' => [
                            ['label' => 'Crea Esercizio Denominazione ', 'url' => ['/esercizio/crea_es_denominazione_immagini']],
                            ['label' => 'Crea Esercizio Ripetizione Parole ', 'url' => ['/esercizio/crea_es_ripetizione_parole']],
                            ['label' => 'Crea Esercizio Coppie Minime ', 'url' => ['/esercizio/crea_es_coppie_minime']],
                        ],
                    ],
                    ])
                    ) : ('<div></div>'
                    )
                ) : (
                    '<div></div>'
                )
            ?>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'nome',
            'tipologia',
            'disturbo',
            'parola',
            'fonema',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {add_exercise} {remove_exercise}',
                'visibleButtons' => [
                    'update' => function ($model) use ($terapia_id) {
                        return \Yii::$app->user->identity->ruolo == 'Logopedista' && $terapia_id == -1;
                    },

                    'view' => function ($model) use ($terapia_id) {
                        return $terapia_id == -1;
                    },

                    'add_exercise' => function ($model) use ($terapia_id, $aggiungi) {
                        return \Yii::$app->user->identity->ruolo == 'Logopedista' && $terapia_id !== -1 && $aggiungi == true;
                    },

                    'remove_exercise' => function ($model) use ($terapia_id, $aggiungi) {
                        return \Yii::$app->user->identity->ruolo == 'Logopedista' && $terapia_id !== -1 && $aggiungi == false;
                    },
                ],
                'buttons' => [
                    'add_exercise' => function ($url, $model, $key) use ($terapia_id) {
                        return Html::a(
                            'Assegna',
                            ['terapia/assegna_esercizio', 'id_terapia' => $terapia_id, 'id_esercizio' => $model->id],
                            ['class' => 'btn btn-primary']
                        );
                    },

                    'remove_exercise' => function ($url, $model, $key) use ($terapia_id) {
                        return Html::a(
                            'Rimuovi',
                            ['terapia/rimuovi_esercizio', 'id_terapia' => $terapia_id, 'id_esercizio' => $model->id],
                            ['class' => 'btn btn-primary']
                        );
                    },
                ],
                'urlCreator' => function ($action, Esercizio $model, $key, $index, $column) {
                    if ($action === 'view') {

                            $url = 'index.php?r=esercizio/visualizza_esercizio&id=' . $model->id;


                        return $url;
                    }
                    if ($action === 'update') {

                        if ($model->tipologia == 'Denominazione immagini') {
                            $url = 'index.php?r=esercizio/modifica_esercizio_denominazione&esercizio=' . $model->id;
                        } else if ($model->tipologia == 'Coppie minime') {
                            $url = 'index.php?r=esercizio/modifica_esercizio_coppie&esercizio=' . $model->id;
                        } else if ($model->tipologia == 'Ripetizione parole') {
                            $url = 'index.php?r=esercizio/modifica_esercizio_ripetizione&esercizio=' . $model->id;
                        }
                        
                        return $url;
                    }

                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>