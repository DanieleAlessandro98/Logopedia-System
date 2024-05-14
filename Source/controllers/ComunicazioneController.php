<?php

namespace app\controllers;

use Yii;

use app\models\Comunicazione;
use app\models\Account;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ComunicazioneController extends Controller
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

    protected function autentificazione($rule, $action)
    {
        $identity = new Account();
        return $identity->isLogopedista(Yii::$app->user->identity->ruolo) || $identity->isCaregiver(Yii::$app->user->identity->ruolo);
    }

    public function actionComunicazione()
    {
        $model = new Comunicazione();

        if ($model->load($this->request->post()))
        {
            if (!$model->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('comunica', ['model' => $model]);
            }
            else
            {
                Comunicazione::comunica($model);

                Yii::$app->session->setFlash('success', 'Email inviata con successo.');
                return $this->refresh();
            }
        }

        return $this->render('comunica', ['model' => $model]);
    }
}