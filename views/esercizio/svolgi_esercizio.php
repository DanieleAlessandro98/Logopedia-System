<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Esercizio */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Svolgi Esercizi giornalieri', 'url' => ['lista_esercizi_giornalieri']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="svolgi-esercizio">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <?php if($aiuto) : ?>
    <div class="row">
        <div class="col-12">
            <div class="suggerimento-logopedista">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48"><path fill="none" d="M0 0h24v24H0z"/><path d="M9.973 18H11v-5h2v5h1.027c.132-1.202.745-2.194 1.74-3.277.113-.122.832-.867.917-.973a6 6 0 1 0-9.37-.002c.086.107.807.853.918.974.996 1.084 1.609 2.076 1.741 3.278zM10 20v1h4v-1h-4zm-4.246-5a8 8 0 1 1 12.49.002C17.624 15.774 16 17 16 18.5V21a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-2.5C8 17 6.375 15.774 5.754 15z"/></svg>
                </div>
                <div>
                    <h5>Il suggerimento del tuo logopedista</h5>
                    <p>
                        <?=$model->aiuto ?>
                    </p>
                </div>

            </div>
        </div>
         </div>
    <?php endif; ?>
	<?php if ($model->tipologia != 'Coppie minime') : ?>
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?php endif; ?>

		<?php if ($model->tipologia == 'Denominazione immagini') : ?>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <?= Html::img($model->esercizioDenominazione[0]->immagine,  ['class' => 'd-block w-100']) ?>
                    <h5 class="text-center mt-3 mb-5">Pronuncia il nome dell'oggetto mostrato </h5>
                </div>
            </div>

		<?php elseif ($model->tipologia == 'Ripetizione parole') : ?>

            <div class="row justify-content-center">
                <div class="col-12">
                    <h5 class="text-center mt-3 ">Pronuncia le tre parole mostrate</h5>
                </div>

                <div class="col-12 col-lg-4 mt-3">
                    <h2 class="text-center mt-3 mb-4 py-3 border border-primary rounded"><?= $model->esercizioRipetizioneParole[0]->parola_1 ?> </h2>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <h2 class="text-center mt-3 mb-4 py-3 border border-primary rounded"><?= $model->esercizioRipetizioneParole[0]->parola_2 ?> </h2>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <h2 class="text-center mt-3 mb-4 py-3 border border-primary rounded"><?= $model->esercizioRipetizioneParole[0]->parola_3 ?></h2>
                </div>

            </div>

		<?php elseif ($model->tipologia == 'Coppie minime') : ?>

            <div class="row justify-content-center mb-5">
                <div class="col-12">
                    <h5 class="text-center mt-3 mb-4">Seleziona l'immagine relativa alla parola ascoltata</h5>
                </div>

                <div class="col-12 col-lg-12 d-flex justify-content-center mb-4 ">
                    <audio controls>
                        <source src="<?= $model->esercizioCoppieMinime[0]->descrizione_vocale ?> "  type='audio/mp3'>
                        Your browser does not support the audio element.
                    </audio>
                </div>
                <div class="col-12 col-lg-5 d-flex justify-content-center flex-column">
                    <?= Html::img($model->esercizioCoppieMinime[0]->immagine_1,  ['class' => 'd-block w-100']) ?>
                    <?= Html::a('Immagine 1', ['svolgi_esercizio', 'id' => $model->id, 'coppie' => true, 'risposta' => 'Immagine 1',], ['class' => 'btn btn-primary mx-auto']); ?>
                </div>

                <div class="offset-1 col-12 col-lg-5 d-flex justify-content-center flex-column">
                    <?= Html::img($model->esercizioCoppieMinime[0]->immagine_2,  ['class' => 'd-block w-100']) ?>
                    <?= Html::a('Immagine 2', ['svolgi_esercizio', 'id' => $model->id, 'coppie' => true, 'risposta' => 'Immagine 2',], ['class' => 'btn btn-primary mx-auto ']) ?>
                </div>

            </div>

		<?php endif; ?>

		<?php if ($model->tipologia != 'Coppie minime') : ?>
			<?= $form->field($modelForm, 'file_registrazione')->fileInput() ?>

			<div class="form-group">
				<?= Html::submitButton('Svolgi esercizio', ['class' => 'btn btn-success']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		<?php endif; ?>

</div>
