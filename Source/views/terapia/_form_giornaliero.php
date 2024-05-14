<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\NomeGiorno;
use app\models\ListaEserciziTerapia;
?>

<div class="esercizio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($modelEsercizio->tipologia == 'Denominazione immagini') : ?>
        <?= DetailView::widget([
            'model' => $modelEsercizio,
            'attributes' => [
                'id',
                'disturbo',

                [
                    'attribute'=>'photo',
                    'label' => 'Immagine',
                    'value' => $modelEsercizio->esercizioDenominazione[0]->immagine,
                    'format' => ['image',['width'=>'100','height'=>'100']],
                ],
            ],
        ]) ?>
    <?php elseif ($modelEsercizio->tipologia == 'Ripetizione parole') : ?>
        <?= DetailView::widget([
            'model' => $modelEsercizio,
            'attributes' => [
                'id',
                'disturbo',

                [
                    'attribute'=>'text',
                    'label' => 'Parola 1',
                    'value' => $modelEsercizio->esercizioRipetizioneParole[0]->parola_1,
                ],
                [
                    'attribute'=>'text',
                    'label' => 'Parola 2',
                    'value' => $modelEsercizio->esercizioRipetizioneParole[0]->parola_2,
                ],
                [
                    'attribute'=>'text',
                    'label' => 'Parola 3',
                    'value' => $modelEsercizio->esercizioRipetizioneParole[0]->parola_3,
                ],
            ],
        ]) ?>
    <?php elseif ($modelEsercizio->tipologia == 'Coppie minime') : ?>
        <?= DetailView::widget([
            'model' => $modelEsercizio,
            'attributes' => [
                'id',
                'disturbo',

                [
                    'attribute'=>'photo',
                    'label' => 'Immagine',
                    'value' => $modelEsercizio->esercizioCoppieMinime[0]->immagine_1,
                    'format' => ['image',['width'=>'100','height'=>'100']],
                ],

                [
                    'attribute'=>'photo',
                    'label' => 'Immagine',
                    'value' => $modelEsercizio->esercizioCoppieMinime[0]->immagine_2,
                    'format' => ['image',['width'=>'100','height'=>'100']],
                ],
            ],
        ]) ?>
    <?php endif; ?>

</div>


<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div>
        <?php
            $subquery = ListaEserciziTerapia::find()->select(['giorno'])->where(['id_esercizio' => $id_esercizio, 'id_terapia' => $id_terapia]);
            $query = NomeGiorno::find()->where(['not in','giorno', $subquery])->all();
            $giorni = Arrayhelper::map($query,'giorno','giorno');
        ?>
        <?= $form->field($modelLista, 'giorno')->dropDownList($giorni); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Assegna', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>