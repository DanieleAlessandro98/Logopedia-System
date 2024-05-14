<?php

use app\models\Account;
use yii\bootstrap4\ButtonDropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Esercizio;

$identity = new Account();


$this->title = 'Esercizios';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="esercizio-index">

    <h1>Esercizi</h1>

    <div class="row">

        <div class="col-12 d-flex justify-content-end"><?=
            !Yii::$app->user->isGuest ? (
                //sono loggato come logopedista --> CREA esercizio
            $identity->isLogopedista(Yii::$app->user->identity->ruolo) ? (
            ButtonDropdown::widget([
                'label' => 'Crea Esercizio',
                'buttonOptions' => ['class' => 'btn-primary'],
                'dropdown' => [

                    'items' => [
                        ['label' => 'Crea Esercizio Denominazione ', 'url' => ['/logopedista/crea_esercizio']],
                        ['label' => 'Crea Esercizio Ripetizione Parole ', 'url' => ['/logopedista/crea_es_ripetizione_parole']],
                        ['label' => 'Crea Esercizio Coppie Minime ', 'url' => ['/logopedista/crea_es_coppie_minime']],
                    ],
                ],
            ])
            ) : (
            '<div></div>'
            )

            ) :
                (
                    //entra qui dove non sei loggato avevo sbagliatooo GOOOOOOOOOOOOOOOODO
                '<div></div>'

                )

            ?>
        </div>
    </div>


<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'nome',
        'tipologia',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Esercizio $model, $key, $index, $column) {
                if ($action === 'view') {
                    $url = 'index.php?r=logopedista/visualizza_esercizio&esercizio=' . $model->id;
                    return $url;
                }
                if ($action === 'update') {

                    if ($model->tipologia == 'Denominazione immagini') {
                        $url = 'index.php?r=logopedista/modifica_esercizio_denominazione&esercizio=' . $model->id;
                    } else if ($model->tipologia == 'Coppie minime') {
                        $url = 'index.php?r=logopedista/modifica_esercizio_coppie&esercizio=' . $model->id;
                    } else if ($model->tipologia == 'Ripetizione parole') {
                        $url = 'index.php?r=logopedista/modifica_esercizio_ripetizione&esercizio=' . $model->id;
                    }
                    return $url;
                }

                return Url::toRoute([$action, 'id' => $model->id]);

            }
        ],
    ],
]); ?>