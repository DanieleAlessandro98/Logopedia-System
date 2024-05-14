<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use hosanna\audiojs\AudioJs;

/* @var $this yii\web\View */
/* @var $model app\models\Esercizio */
/* @var $modelSvolto app\models\Esercizio */

$this->title = 'Esercizio numero: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lista esercizi da convalidare', 'url' => ['lista_esercizi_svolti']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="convalida-esercizio">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->tipologia == 'Denominazione immagini') : ?>
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
                [
                    'attribute' => 'id_terapia',
                    'label' => 'ID Terapia',
                    'value' => $modelSvolto->id_terapia,
                ],
				[
					'attribute' => 'photo',
					'label' => 'Immagine',
					'value' => $model->esercizioDenominazione[0]->immagine,
					'format' => ['image', ['width' => '200', 'height' => '200']],
				],

				[
					'attribute' => 'Risposta',
					'format'=>'raw',
					'value'=>
						"<audio controls>
							<source src='". $modelSvolto->risposta . " ' type='audio/mp3'>
							Your browser does not support the audio element.
						</audio>",
				],


				[
					'attribute' => 'Convalida',
					'format'=>'raw',
					'value'=> Html::a('Giusto', ['convalida_esercizio', 'id_esercizio' => $model->id,  'id_esercizio_svolto' => $modelSvolto->id, 'valutazione' => 'Giusta',], ['class' => 'btn btn-success']) . ' ' . Html::a('Sbagliato', ['convalida_esercizio', 'id_esercizio' => $model->id,  'id_esercizio_svolto' => $modelSvolto->id, 'valutazione' => 'Sbagliata',], ['class' => 'btn btn-secondary'])
			   ],
			],
		]) ?>
    <?php elseif ($model->tipologia == 'Ripetizione parole') : ?>
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
                [
                    'attribute' => 'id_terapia',
                    'label' => 'ID Terapia',
                    'value' => $modelSvolto->id_terapia,
                ],
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
				
				[
					'attribute' => 'Risposta',
					'format'=>'raw',
					'value'=>
						"<audio controls>
							<source src='". $modelSvolto->risposta . " ' type='audio/mp3'>
							Your browser does not support the audio element.
						</audio>",
				],

				[
					'attribute' => 'Convalida',
					'format'=>'raw',
					'value'=> Html::a('Giusto', ['convalida_esercizio', 'id_esercizio' => $model->id,  'id_esercizio_svolto' => $modelSvolto->id, 'valutazione' => 'Giusta',], ['class' => 'btn btn-success']) . ' ' . Html::a('Sbagliato', ['convalida_esercizio', 'id_esercizio' => $model->id,  'id_esercizio_svolto' => $modelSvolto->id, 'valutazione' => 'Sbagliata',], ['class' => 'btn btn-secondary'])
			   ],
			],
		]) ?>
    <?php elseif ($model->tipologia == 'Coppie minime') : ?>
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
                [
                    'attribute' => 'id_terapia',
                    'label' => 'ID Terapia',
                    'value' => $modelSvolto->id_terapia,
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

				[
					'attribute' => 'Risposta',
					'format'=>'text',
					'value'=> $modelSvolto->risposta,
				],

				[
					'attribute' => 'Convalida',
					'format'=>'raw',
					'value'=> Html::a('Giusto', ['convalida_esercizio', 'id_esercizio' => $model->id,  'id_esercizio_svolto' => $modelSvolto->id, 'valutazione' => 'Giusta',], ['class' => 'btn btn-success']) . ' ' . Html::a('Sbagliato', ['convalida_esercizio', 'id_esercizio' => $model->id,  'id_esercizio_svolto' => $modelSvolto->id, 'valutazione' => 'Sbagliata',], ['class' => 'btn btn-secondary'])
			   ],
			],
		]) ?>
    <?php endif; ?>

</div>
