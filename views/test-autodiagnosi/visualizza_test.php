<?php

use app\models\Account;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TestAutodiagnosi */

$identity = new Account();

$this->title = 'Test Autodiagnosi compilato';
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="test-autodiagnosi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->isGuest || $identity->isUtente(Yii::$app->user->identity->ruolo)) : ?>
            <?= Html::a('Visualizza pdf', ['visualizza_pdf', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Contatta un logopedista', ['/logopedista/lista_logopedisti'], ['class' => 'btn btn-danger']) ?>

        <?php elseif ($identity->isLogopedista(Yii::$app->user->identity->ruolo)) : ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'domanda_1',
            'domanda_2',
            'domanda_3',
            'domanda_4',
            'id_utente',
        ],
    ]) ?>

</div>