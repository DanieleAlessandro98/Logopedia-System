<?php

namespace app\controllers;

use Yii;

use app\models\Account;
use app\models\Appuntamento;
use app\models\AppuntamentoRicerca;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class AppuntamentoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],

                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['prenota_appuntamento'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return $this->autentificazioneCaregiver($rule, $action);
                            }
                        ],
    
                        [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return $this->autentificazione($rule, $action);
                            }
                        ],
                    ],
                ],
            ]
        );
    }

    protected function autentificazioneCaregiver($rule, $action)
    {
        $identity = new Account();
        return $identity->isCaregiver(Yii::$app->user->identity->ruolo);
    }

    protected function autentificazione($rule, $action)
    {
        $identity = new Account();
        return $identity->isLogopedista(Yii::$app->user->identity->ruolo) || $identity->isCaregiver(Yii::$app->user->identity->ruolo);
    }

    public function actionLista_appuntamenti($fissati = false)
    {
        $searchModel = new AppuntamentoRicerca();
        $dataProvider = $searchModel->search($this->request->queryParams, $fissati);

        return $this->render('lista_appuntamenti', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVisualizza_appuntamento($id)
    {
        return $this->render('visualizza_appuntamento', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPrenota_appuntamento()
    {
        $model = new Appuntamento();
        $model->scenario = "form_prenota";

        if ($model->load($this->request->post()))
        {
            if (!$model->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('prenota_appuntamento', ['model' => $model]);
            }

            $appuntamento = Appuntamento::prenotaAppuntamento($model);
            return $this->redirect(['visualizza_appuntamento', 'id' => $appuntamento]);
        }

        return $this->render('prenota_appuntamento', ['model' => $model]);
    }

    public function actionConferma_appuntamento($id)
    {
        Appuntamento::confermaAppuntamento($id);
        return $this->redirect(['visualizza_appuntamento', 'id' => $id]);
    }

    public function actionModifica_data_appuntamento($id)
    {
        $model = $this->findModel($id);
        $model->scenario = "form_modifica";

        if ($model->load($this->request->post()))
        {
            if (!$model->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('modifica_data_appuntamento', ['model' => $model]);
            }

            Appuntamento::modificaDataAppuntamento($model);
            return $this->redirect(['lista_appuntamenti', 'fissati' => false]);
        }

        return $this->render('modifica_data_appuntamento', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Appuntamento::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
