<?php

namespace app\controllers;

use app\models\Account;
use app\models\ListaAssistiti;
use app\models\ListaAssistitiRicerca;
use app\models\Utente;
use app\models\Caregiver;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CaregiverController implements the CRUD actions for Listaassistiti model.
 */
class CaregiverController extends Controller
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
            ]
        );
    }

    /**
     * Lists all Listaassistiti models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ListaAssistitiRicerca();
        $dataProvider = $searchModel->search($this->request->queryParams,Yii::$app->user->identity->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Listaassistiti model.
     * @param int $id_caregiver Id Caregiver
     * @param int $id_utente Id Utente
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_caregiver, $id_utente)
    {
        return $this->render('view', [
            'model' => (new \app\models\Listaassistiti)->findModel($id_caregiver, $id_utente),
        ]);
    }

    /**
     * Creates a new Listaassistiti model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ListaAssistiti();


        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $utente = Utente::trovaUtente($model->id_utente);
                $model->id_caregiver = Yii::$app->user->identity->id;

                ListaAssistiti::AggiungiAssistito($model,$utente);
                return $this->redirect(['index', 'id_caregiver' => $model->id_caregiver, 'id_utente' => $model->id_utente]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Listaassistiti model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_caregiver Id Caregiver
     * @param int $id_utente Id Utente
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_caregiver, $id_utente)
    {
        $model = (new \app\models\Listaassistiti)->findModel($id_caregiver, $id_utente);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $utente = Utente::trovaUtente($model->id_utente);
            Listaassistiti::modificaAssistito($model,$utente);
            return $this->redirect(['view', 'id_caregiver' => $model->id_caregiver, 'id_utente' => $model->id_utente]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Listaassistiti model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_caregiver Id Caregiver
     * @param int $id_utente Id Utente
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_caregiver, $id_utente)
    {
        (new \app\models\Listaassistiti)->eliminaAssistito($id_caregiver,$id_utente);
        return $this->redirect(['index']);
    }

}
