<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use app\models\ListaEserciziTerapia;
use app\models\Account;

/* @var $this yii\web\View */
/* @var $model app\models\Terapia */

$identity = new Account();

$this->title = 'Terapia numero: ' . $model->id;

if (Yii::$app->user->isGuest == False && $identity->isLogopedista(Yii::$app->user->identity->ruolo))
    $this->params['breadcrumbs'][] = ['label' => 'Terapie', 'url' => ['terapia/monitora_terapie_utenti']];
elseif (Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo))
    $this->params['breadcrumbs'][] = ['label' => 'Terapie', 'url' => ['terapia/lista_terapie']];

$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="terapia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Assegna Esercizi', ['esercizio/assegna_esercizio', 'id_terapia' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Rimuovi Esercizi', ['esercizio/rimuovi_esercizio', 'id_terapia' => $model->id], ['class' => 'btn btn-danger']) ?>
    </p>

    <p>
        <?= Html::a('Modifica', ['modifica_terapia', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancella', ['elimina_terapia', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Sei sicuro di voler cancellare questa terapia?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_utente',
            'nome',
            'disturbo',
            'stato',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            [
                'label' => 'Esercizi della terapia:',
                'value' => 'esercizio.nome',
            ],
            
            [
                'label' => 'Giorno a cui assegnato:',
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