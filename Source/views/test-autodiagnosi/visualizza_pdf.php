<?php
use yii\helpers\Html;
?>

<p>
    Test Autodiagnosi compilata con successo. Dati del test:<br><br>
    
    <?= Html::encode($model->domanda_1) ?><br>
    <?= Html::encode($model->domanda_2) ?><br>
    <?= Html::encode($model->domanda_3) ?><br>
    <?= Html::encode($model->domanda_4) ?><br>
</p>