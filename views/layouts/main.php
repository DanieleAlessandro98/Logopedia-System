<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Account;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

$identity = new Account();

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
        'containerOptions' => ['class' => 'justify-content-between']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [

            Yii::$app->user->isGuest ? (
                ['label' => 'Test Autodiagnosi', 'url' => ['test-autodiagnosi/crea_testautodiagnosi']]
            ) : (
                Yii::$app->user->isGuest == False && $identity->isLogopedista(Yii::$app->user->identity->ruolo) ?
                (
                    ['label' => 'Effettua Diagnosi', 'url' => ['/logopedista/lista_utenti_senzadiagnosi']]
                ) :
                (
                Yii::$app->user->isGuest == False && $identity->isUtente(Yii::$app->user->identity->ruolo) ?
                    (
                    ['label' => 'Test Autodiagnosi', 'url' => ['test-autodiagnosi/crea_testautodiagnosi']]
                    ) :(
                    '<div></div>'
                    )

                )

            ),

            Yii::$app->user->isGuest ? (['label' => 'Contatta Logopedista', 'url' => ['logopedista/lista_logopedisti']]
            ) : (''),

            Yii::$app->user->isGuest == false ? (['label' => 'Esercizi', 'url' => ['esercizio/index']]
            ) : (''),

            Yii::$app->user->isGuest == False && ($identity->isLogopedista(Yii::$app->user->identity->ruolo)) ?
            (['label' => 'Terapie', 'url' => ['terapia/monitora_terapie_utenti']]
            ) : (''),

            Yii::$app->user->isGuest == False && ($identity->isCaregiver(Yii::$app->user->identity->ruolo)) ?
                (['label' => 'Terapie', 'url' => ['terapia/lista_terapie']]
                ) : (''),

            Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo) ?
                (['label' => 'Assistiti', 'url' => ['caregiver/index']]
                ) : (''),

            Yii::$app->user->isGuest == False && $identity->isUtente(Yii::$app->user->identity->ruolo) ?
            (['label' => 'Svolgi Esercizi', 'url' => ['esercizio/lista_esercizi_giornalieri']]
            ) : (''),

            Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo) ?
            (['label' => 'Convalida Esercizi', 'url' => ['esercizio/lista_esercizi_svolti']]
            ) : (''),
			
            Yii::$app->user->isGuest == False &&
                ($identity->isCaregiver(Yii::$app->user->identity->ruolo) ||
                $identity->isLogopedista(Yii::$app->user->identity->ruolo)) ?
            ([
                'label' => 'Appuntamenti',
                'items' => [
                    ['label' => 'Fissati ', 'url' => ['appuntamento/lista_appuntamenti', 'fissati' => true]],
                    ['label' => 'In attesa ', 'url' => ['appuntamento/lista_appuntamenti', 'fissati' => false]],
                ],
            ]) : (''),
            
            Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo) ?
            (['label' => 'Comunica con il Logopedista', 'url' => ['comunicazione/comunicazione']]
            ) : (''),

            Yii::$app->user->isGuest == False && $identity->isLogopedista(Yii::$app->user->identity->ruolo) ?
            (['label' => 'Comunica con un tuo Caregiver', 'url' => ['comunicazione/comunicazione']]
            ) : (''),
			
            Yii::$app->user->isGuest == False && $identity->isUtente(Yii::$app->user->identity->ruolo) ?
            (['label' => 'Visualizza terapia', 'url' => ['utente/visualizza_terapia']]
            ) : (''),

        ],
    ]);
    echo Nav::widget([

        'options' => ['class' => 'navbar-nav'],
        'items' => [

            Yii::$app->user->isGuest ? (
                [
                'label' => 'Registrazione',
                'items' => [
                    ['label' => 'Registrazione Utente ', 'url' => ['/profilazione/registrazione_utente']],
                    ['label' => 'Registrazione Caregiver ', 'url' => ['/profilazione/registrazione_caregiver']],
                    ['label' => 'Registrazione Logopedista ', 'url' => ['/profilazione/registrazione_logopedista']],],
                ]

            ) : ( '<div></div>'
            ),

            Yii::$app->user->isGuest ? (
            [
                'label' => 'Accedi',
                'options' => [
                    'class' => 'ml-3 btn p-0 btn-outline-secondary',
                ],

                'url' => ['/profilazione/effettua_accesso']]
            ) : (
                    [
                'label' => 'Logout '. Yii::$app->user->identity->username,
                'options' => [
                    'class' => 'ml-3 btn p-0 btn-outline-secondary',
                ],

                'url' => ['/profilazione/logout']]

            )
        ],
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; My Company <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
