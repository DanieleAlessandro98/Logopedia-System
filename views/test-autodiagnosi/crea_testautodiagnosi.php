<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TestAutodiagnosi */

$this->title = 'Compila Test Autodiagnosi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-autodiagnosi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
