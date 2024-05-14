<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Listaassistiti */

$this->title = Yii::t('app', 'Aggiungi assistito');
$this->params['breadcrumbs'][] = ['label' => 'Lista assistiti', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="listaassistiti-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
