<?php

use app\models\Appuntamento;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AppuntamentoRicerca */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista Appuntamenti';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="appuntamento-lista-appuntamenti">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->identity->ruolo != 'Logopedista') : ?>
        <p>
            <?= Html::a('Prenota Appuntamento', ['prenota_appuntamento'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Logopedista',
                'value' => function ($model) {
                    return $model->logopedista->nome . ' ' . $model->logopedista->cognome;
                }
            ],

            [
                'label' => 'Assistito',
                'value' => function ($model) {
                    return $model->utente->nome . ' ' . $model->utente->cognome;
                }
            ],

            [
                'label' => 'Data',
                'value' => function ($model) {
                    return $model->getData();
                }
            ],

            [
                'label' => 'Stato',
                'value' => function ($model) {
                    return $model->getStato();
                }
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{view} {accept} {change_data}',

                'visibleButtons' => [
                    'view' => function ($model) {
                        return $model->stato == 'CONFERMATO';
                    },

                    'accept' => function ($model) {
                        $logopedista = \Yii::$app->user->identity->ruolo == 'Logopedista' && $model->stato == 'ATTESA_LOGOPEDISTA';
                        $caregiver = \Yii::$app->user->identity->ruolo == 'Caregiver' && $model->stato == 'ATTESA_CAREGIVER';

                        return $logopedista || $caregiver;
                    },

                    'change_data' => function ($model) {
                        $logopedista = \Yii::$app->user->identity->ruolo == 'Logopedista' && $model->stato == 'ATTESA_LOGOPEDISTA';
                        $caregiver = \Yii::$app->user->identity->ruolo == 'Caregiver' && $model->stato == 'ATTESA_CAREGIVER';

                        return $logopedista || $caregiver;
                    },
                ],

                'buttons' => [
                    'accept' => function ($url, $model, $key) {
                        return Html::a(
                            'Conferma',
                            ['conferma_appuntamento', 'id' => $model->id],
                            ['class' => 'btn btn-primary']
                        );
                    },

                    'change_data' => function ($url, $model, $key) {
                        return Html::a(
                            'Modifica data',
                            ['modifica_data_appuntamento', 'id' => $model->id],
                            ['class' => 'btn btn-primary']
                        );
                    },
                ],

                'urlCreator' => function ($action, Appuntamento $model, $key, $index, $column) {
                    if ($action === 'view') {
                            $url = 'index.php?r=appuntamento/visualizza_appuntamento&id=' . $model->id;
                        return $url;
                    }

                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
