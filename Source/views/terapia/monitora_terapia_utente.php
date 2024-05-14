<?php

use app\models\Account;
use braunmar\yii\easypiechart\EasyPieChart;
use braunmar\yii\easypiechart\EasyPieChartRegister;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use app\models\ListaEserciziTerapia;




$identity = new Account();

/* @var $this yii\web\View */
/* @var $model app\models\Terapia */
/* @var $searchModel app\models\TerapiaRicerca */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProvider2 yii\data\ActiveDataProvider */

$this->title = 'Terapia numero: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Terapie', 'url' => ['terapia/monitora_terapie_utenti']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$terapia_stato = $model->stato;
$esercizi_completati = $esercizi_corretti + $esercizi_errati;

$perc_esercizi_corretti =( $esercizi_completati == 0) ? 0*100 : ($esercizi_corretti/$esercizi_completati)*100;

?>
<div class="monitora_terapia-container">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= !Yii::$app->user->isGuest ? (
        $identity->isLogopedista(Yii::$app->user->identity->ruolo) ? (
            '<div class="row mb-4 mt-3">
                <div class="col-lg-6 col-12">'.
                    Html::a('Assegna Esercizi', ['esercizio/assegna_esercizio', 'id_terapia' => $model->id], ['class' => 'btn btn-primary mr-2']) .
                    Html::a('Rimuovi Esercizi', ['esercizio/rimuovi_esercizio', 'id_terapia' => $model->id], ['class' => 'btn btn-danger']).
               '</div>
                <div class="col-lg-6 col-12 d-flex justify-content-end">'.
                    Html::a('Modifica Terapia', ['modifica_terapia', 'id' => $model->id], ['class' => 'btn btn-primary mr-2']).
                     Html::a('Elimina Terapia', ['elimina_terapia', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Sei sicuro di voler cancellare questa terapia?',
                    'method' => 'post',
                ],
            ]).'
                </div>
            </div>'
        ) : ('<div></div>')
    ) : ('<div></div>')
    ?>


    <div class="row justify-content-center">
        <div class="col-12 col-lg-4 mb-4">
            <h4 class="text-center">Stato terapia</h4>
            <?= EasyPieChart::widget([
                'content' => Html::tag('h3', $terapia_stato.'%', ['class' => 'position-absolute mb-0']),
                'element' => 'div',
                'options' => ['data-percent' => $terapia_stato, 'class' => 'easypiechart d-flex align-items-center justify-content-center'],
                'pluginOptions' => [
                    'scaleColor' => false,
                    'trackColor' => '#d6d6d6',
                    'lineWidth' => 8,
                    'barColor' => '#232323',
                    'size' => 120,
                ],
            ]); ?>
        </div>
        <div class="col-12 col-lg-4">
            <h4 class="text-center">Esercizi corretti</h4>
            <?= EasyPieChart::widget([
                'content' => Html::tag('h3', $perc_esercizi_corretti.'%', ['class' => 'position-absolute mb-0']),
                'element' => 'div',
                'options' => ['data-percent' => $perc_esercizi_corretti, 'class' => 'easypiechart d-flex align-items-center justify-content-center'],
                'pluginOptions' => [
                    'scaleColor' => false,
                    'trackColor' => '#b11f00',
                    'lineWidth' => 8,
                    'barColor' => '#008d04',
                    'size' => 120,
                ],
            ]); ?>
        </div>


    </div>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_utente',
            [
                'label' => 'Nome Terapia',
                'value' => $model->nome
            ],
            [
                    'label' => 'Nome e Cognome Utente',
                    'value' => $model->utente->nome . ' '.$model->utente->cognome
            ],
            'disturbo',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                    'label' => 'Esercizi svolti',
                    'value' => 'esercizio.nome',
            ],
            [
                    'label' => 'Svolto in data',
                    'value' => 'data',
            ],
            [
                    'label' => 'Esito',
                    'value' => 'valutazione',
            ]

        ],
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'filterModel' => null,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'label' => 'Esercizi non svolti',
                'value' => 'esercizio.nome',
            ],

            [
                'label' => 'Assegnato il giorno',
                'value' => 'giorno',
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'urlCreator' => function ($action, ListaEserciziTerapia $model, $key, $index, $column) {
                    $url = 'index.php?r=esercizio/visualizza_esercizio&id=' . $model->id_esercizio;
                    return $url;
                }
            ],

        ],
    ]); ?>



</div>