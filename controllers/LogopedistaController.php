<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Utente;
use app\models\Account;
use app\models\Logopedista;
use app\models\RicercaUtente;
use app\models\Caregiver;

class LogopedistaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['lista_logopedisti'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return $this->autentificazione($rule, $action);
                        }
                    ],

                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->autentificazioneLogopedista($rule, $action);
                        }
                    ],
                ],
            ],
        ];
    }

    protected function autentificazione($rule, $action)
    {
        $identity = new Account();
        return Yii::$app->user->isGuest || $identity->isUtente(Yii::$app->user->identity->ruolo);
    }

    protected function autentificazioneLogopedista($rule, $action)
    {
        $identity = new Account();
        return $identity->isLogopedista(Yii::$app->user->identity->ruolo);
    }

    public function actionLista_logopedisti()
    {
        $dataProvider = new Logopedista();

        return $this->render('lista_logopedisti', [
            'dataProvider' => $dataProvider->getListaLogopedisti(),
        ]);
    }

    public function actionLista_utenti_senzadiagnosi(){
        $searchModel = new RicercaUtente();
        $dataProvider = $searchModel->getListaUtentiSenzaTerapia($this->request->queryParams);

        return $this->render('lista_utenti_senzadiagnosi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEffettua_diagnosi($utente){
        $model = Utente::trovaUtente($utente);
        $model->scenario="form_effettua_diagnosi";
        if($model->load(Yii::$app->request->post())){
            if(!$model->validate()){
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
            }
            else{
                Utente::modificaDiagnosi($model);

                Yii::$app->session->setFlash('success', 'Diagnosi effettuata con successo.');
                return $this->redirect(['utente/visualizza_utente', 'utente' => $model->id]);
            }
        }
        else{
            return $this->render('effettua_diagnosi', ['model' => $model]);
        }
    }

}
