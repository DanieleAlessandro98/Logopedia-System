<?php

/** @var yii\web\View $this */

use app\models\Account;
use yii\bootstrap4\Html;

$this->title = 'Home';
$identity = new Account();
?>
<div class="site-index">

    <div class="text-center bg-transparent mt-3 mb-4">
        <?php if( Yii::$app->user->isGuest ) : ?>
            <h1 class="mb-3">Benvenuti su Pronuntia!</h1>
        <?php elseif(Yii::$app->user->isGuest == False && $identity->isUtente(Yii::$app->user->identity->ruolo)) :  ?>
            <h1 class="mb-3">Benvenuto <?= Yii::$app->user->identity->utente->nome ?> </h1>
        <?php elseif(Yii::$app->user->isGuest == False && $identity->isLogopedista(Yii::$app->user->identity->ruolo)) :  ?>
            <h1 class="mb-3">Benvenuto <?= Yii::$app->user->identity->logopedista->nome ?> </h1>
        <?php elseif(Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo)) :  ?>
            <h1 class="mb-3">Benvenuto <?= Yii::$app->user->identity->caregiver->nome ?> </h1>
        <?php endif; ?>


        <img  class="d-block w-100" src="upload/img/logopedista_img.jpg" />
    </div>

    <?php if( Yii::$app->user->isGuest ) : ?>
        <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2 class="text-center">Logopedista</h2>

                <p class="text-center">Un sistema automatico e veloce per la gestione delle terapie degli utenti.</p>

                <p class="text-center"><a class="btn btn-outline-secondary" href="index.php?r=profilazione/registrazione_logopedista">Registrati come Logopedista</a></p>
            </div>
            <div class="col-lg-4">
                <h2 class="text-center">Caregiver</h2>

                <p class="text-center">Un sistema automatico e veloce per la gestione delle terapie dei tuoi assistiti.</p>

                <p class="text-center"><a class="btn btn-outline-secondary" href="index.php?r=profilazione/registrazione_caregiver">Registrati come Caregiver</a></p>
            </div>
            <div class="col-lg-4">
                <h2 class="text-center">Utente</h2>

                <p class="text-center">Scopri le funzionalità a te riservate per migliorare quotidiamente e parlare bene </p>

                <p class="text-center"><a class="btn btn-outline-secondary" href="index.php?r=profilazione/registrazione_utente">Registrati come Utente</a></p>
            </div>
        </div>

    </div>
    <?php else :  ?>
        <div class="text-center">Nella parte superiore del sistema trovi le funzionalità a te riservate</div>
    <?php endif; ?>

</div>
