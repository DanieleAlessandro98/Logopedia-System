<?php

namespace app\controllers;

use app\models\Account;
use app\models\Utente;
use app\models\RicercaUtente;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ListaEserciziTerapia;
use app\models\Terapia;

/**
 * UtenteController implements the CRUD actions for Utente model.
 */
class UtenteController extends Controller
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
                            'actions' => ['visualizza_utente'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],

                        [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return $this->autentificazioneUtente($rule, $action);
                            }
                        ],
                    ],
                ],
            ]
        );
    }

    protected function autentificazioneUtente($rule, $action)
    {
        $identity = new Account();
        return $identity->isUtente(Yii::$app->user->identity->ruolo);
    }

    /**
     * Lists all Utente models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RicercaUtente();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Utente model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Utente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Utente();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Utente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Utente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Utente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Utente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Utente::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionVisualizza_utente($utente){
        return $this->render('visualizza_utente', ['model' => Utente::trovaUtente($utente),]);
    }


    public function actionVisualizza_terapia(){
        $result = Terapia::getDatiTerapiaByIDUtente(Yii::$app->user->identity->id);

        $searchModel = new ListaEserciziTerapia();
        $dataProvider = $searchModel->getListaEsercizi($result->id);

        return $this->render('visualizza_terapia', [
            'model' => $result,
            'dataProvider' => $dataProvider,
        ]);

    }
}
