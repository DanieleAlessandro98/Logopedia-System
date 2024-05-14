<?php
use yii\helpers\Html;
?>

<p>
    Utente associato con successo. Dati dell'utente aggiunto:<br><br>
    <?= Html::encode($utente->nome) ?><br>
    <?= Html::encode($utente->cognome) ?><br>
    <?= Html::encode($utente->codice_fiscale) ?><br>
</p>