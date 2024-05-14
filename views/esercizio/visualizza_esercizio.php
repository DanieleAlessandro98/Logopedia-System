<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Account;

/* @var $this yii\web\View */
/* @var $model app\models\Esercizio */

$this->title = 'Esercizio numero: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Esercizio', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$identity = new Account();
?>
<div class="esercizio-view">

    <h1 class="mb-3"><?= $model->nome ?></h1>

    <?php if (Yii::$app->user->isGuest == False && $identity->isLogopedista(Yii::$app->user->identity->ruolo)) : ?>
    <div class="row mb-4">
        <div class="col-lg-6 col-12">
            <?php if ($model->tipologia == 'Denominazione immagini') : ?>
                <?= Html::a('Modifica', ['modifica_esercizio_denominazione', 'esercizio' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php elseif ($model->tipologia == 'Ripetizione parole') : ?>
                <?= Html::a('Modifica', ['modifica_esercizio_ripetizione', 'esercizio' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php elseif ($model->tipologia == 'Coppie minime') : ?>
                <?= Html::a('Modifica', ['modifica_esercizio_coppie', 'esercizio' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>

            <?= Html::a('Aggiungi Aiuto', ['aggiungi_aiuto','esercizio' => $model->id], ['class' => 'btn btn-primary']) ?>

        </div>
    </div>

    <?php endif; ?>

    <?php if ($model->tipologia == 'Denominazione immagini') : ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'nome',
                'tipologia',
                'disturbo',
                'aiuto',
                'parola',
                'fonema',

                [
                    'attribute'=>'photo',
                    'label' => 'Immagine',
                    'value' => $model->esercizioDenominazione[0]->immagine,
                    'format' => ['image',['width'=>'100','height'=>'100']],
                ],
            ],
        ]) ?>
    <?php elseif ($model->tipologia == 'Ripetizione parole') : ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'nome',
                'tipologia',
                'disturbo',
                'aiuto',
                'parola',
                'fonema',

                [
                    'attribute'=>'text',
                    'label' => 'Parola 1',
                    'value' => $model->esercizioRipetizioneParole[0]->parola_1,
                ],
                [
                    'attribute'=>'text',
                    'label' => 'Parola 2',
                    'value' => $model->esercizioRipetizioneParole[0]->parola_2,
                ],
                [
                    'attribute'=>'text',
                    'label' => 'Parola 3',
                    'value' => $model->esercizioRipetizioneParole[0]->parola_3,
                ],
            ],
        ]) ?>
    <?php elseif ($model->tipologia == 'Coppie minime') : ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'nome',
                'tipologia',
                'disturbo',
                'aiuto',
                'parola',
                'fonema',
                [
                    'attribute' => 'Descrizione Vocale',
                    'format'=>'raw',
                    'value'=>
                        "<audio controls>
							<source src='". $model->esercizioCoppieMinime[0]->descrizione_vocale . " ' type='audio/mp3'>
							Your browser does not support the audio element.
						</audio>",
                ],
                [
                    'attribute'=>'photo',
                    'label' => 'Immagine',
                    'value' => $model->esercizioCoppieMinime[0]->immagine_1,
                    'format' => ['image',['width'=>'100','height'=>'100']],
                ],

                [
                    'attribute'=>'photo',
                    'label' => 'Immagine',
                    'value' => $model->esercizioCoppieMinime[0]->immagine_2,
                    'format' => ['image',['width'=>'100','height'=>'100']],
                ],
            ],
        ]) ?>
    <?php endif; ?>


</div>
