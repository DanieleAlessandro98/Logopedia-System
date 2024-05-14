<?php

namespace app\controllers;

use Yii;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Esercizio;
use app\models\EsercizioRicerca;
use app\models\EsercizioDenominazione;
use app\models\EsercizioCoppieMinime;
use app\models\EsercizioRipetizioneParole;
use app\models\Account;
use app\models\EsercizioSvolto;
use app\models\EsercizioSvoltoRicerca;


/**
 * EsercizioController implements the CRUD actions for Esercizio model.
 */
class EsercizioController extends Controller
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
                            'actions' => ['index', 'visualizza_esercizio'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],

                        [
                            'actions' => ['lista_esercizi_giornalieri', 'svolgi_esercizio'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return $this->autentificazioneUtente($rule, $action);
                            }
                        ],

                        [
                            'actions' => ['lista_esercizi_svolti', 'convalida_esercizio'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return $this->autentificazioneCaregiver($rule, $action);
                            }
                        ],

                        [
                            'actions' => [
                                'crea_es_denominazione_immagini',
                                'crea_es_ripetizione_parole',
                                'crea_es_coppie_minime',

                                'modifica_esercizio_denominazione',
                                'modifica_esercizio_coppie',
                                'modifica_esercizio_ripetizione',

                                'assegna_esercizio',
                                'rimuovi_esercizio',

                                'aggiungi_aiuto'
                            ],

                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return $this->autentificazioneLogopedista($rule, $action);
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
	
    protected function autentificazioneLogopedista($rule, $action)
    {
        $identity = new Account();
        return $identity->isLogopedista(Yii::$app->user->identity->ruolo);
    }

    protected function autentificazioneCaregiver($rule, $action)
    {
        $identity = new Account();
        return $identity->isCaregiver(Yii::$app->user->identity->ruolo);
    }

    /**
     * Lists all Esercizio models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EsercizioRicerca();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'terapia_id' => -1,
            'aggiungi' => false,
        ]);
    }

    /**
     * Displays a single Esercizio model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVisualizza_esercizio($id)
    {
        return $this->render('visualizza_esercizio', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Esercizio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Esercizio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Esercizio::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCrea_es_denominazione_immagini()
    {
        $model = new Esercizio();
        $model->scenario = "form_crea";

        $modelDenominazione = new EsercizioDenominazione();
        $modelDenominazione->scenario = "form_crea";
  
        if ($model->load($this->request->post()) && $modelDenominazione->load($this->request->post()))
        {
            if (!$model->validate() /** || !$modelDenominazione->validate()*/)
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('crea_es_denominazione_immagini', ['model' => $model, 'modelDenominazione' => $modelDenominazione]);
            }
            else
            {
                $esercizio = Esercizio::creaEsercizio($model, "Denominazione immagini");
                EsercizioDenominazione::creaEsercizio($esercizio, $modelDenominazione);

                Yii::$app->session->setFlash('success', 'Esercizio creato con successo.');
                return $this->redirect(['visualizza_esercizio', 'id' => $esercizio->id]);
            }
        }

        return $this->render('crea_es_denominazione_immagini', ['model' => $model, 'modelDenominazione' => $modelDenominazione]);
    }

    public function actionCrea_es_ripetizione_parole()
    {
        $model = new Esercizio();
        $model->scenario = "form_crea";

        $modelRipetizioneParole = new EsercizioRipetizioneParole();
        $modelRipetizioneParole->scenario= "form_crea";

        if ($model->load($this->request->post()) && $modelRipetizioneParole->load($this->request->post()))
        {
            if (!$model->validate() || !$modelRipetizioneParole->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('crea_es_ripetizione_parole', ['model' => $model, 'modelRipetizioneParole' => $modelRipetizioneParole]);
            }
            else
            {
                $esercizio = Esercizio::creaEsercizio($model, "Ripetizione Parole");
                EsercizioRipetizioneParole::creaEsercizio($esercizio, $modelRipetizioneParole);

                Yii::$app->session->setFlash('success', 'Esercizio creato con successo.');
                return $this->redirect(['visualizza_esercizio', 'id' => $esercizio->id]);
            }
        }

        return $this->render('crea_es_ripetizione_parole', ['model' => $model, 'modelRipetizioneParole' => $modelRipetizioneParole]);
    }

    public function actionCrea_es_coppie_minime()
    {
        $model = new Esercizio();
        $model->scenario = "form_crea";

        $modelCoppieMinime = new EsercizioCoppieMinime();
        $modelCoppieMinime->scenario= "form_crea";

        if ($model->load($this->request->post()) && $modelCoppieMinime->load($this->request->post()))
        {
            if (!$model->validate() || !$modelCoppieMinime->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('crea_es_coppie_minime', ['model' => $model, 'modelCoppieMinime' => $modelCoppieMinime]);
            }
            else
            {
                $esercizio = Esercizio::creaEsercizio($model, "Coppie Minime");
                EsercizioCoppieMinime::creaEsercizio($esercizio, $modelCoppieMinime);

                Yii::$app->session->setFlash('success', 'Esercizio creato con successo.');
                return $this->redirect(['visualizza_esercizio', 'id' => $esercizio->id]);
            }
        }

        return $this->render('crea_es_coppie_minime', ['model' => $model, 'modelCoppieMinime' => $modelCoppieMinime]);
    }

    
    public function actionModifica_esercizio_denominazione($esercizio)
    {
        $model = Esercizio::getDatiEsercizio($esercizio);
        $model->scenario = "form_modifica";

        $modelDenominazione = EsercizioDenominazione::getDatiEsercizio($model->id);
        $modelDenominazione->scenario = "form_modifica";

        if ($model->load($this->request->post()) && $modelDenominazione->load($this->request->post()))
        {
            if (!$model->validate() || !$modelDenominazione->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('modifica_esercizio_denominazione', ['model' => $model, 'modelDenominazione' => $modelDenominazione,]);
            }
            else
            {
                Esercizio::modificaEsercizio($model);
                EsercizioDenominazione::modificaEsercizio($modelDenominazione);

                Yii::$app->session->setFlash('success', 'Esercizio modificato con successo.');
                return $this->redirect(['visualizza_esercizio', 'id' => $model->id]);
            }
        }
        else
        {
            return $this->render('modifica_esercizio_denominazione', ['model' => $model, 'modelDenominazione' => $modelDenominazione,]);
        }
    }

    public function actionModifica_esercizio_coppie($esercizio)
    {
        $model = Esercizio::getDatiEsercizio($esercizio);
        $model->scenario = "form_modifica";

        $modelCoppie = EsercizioCoppieMinime::getDatiEsercizio($model->id);
        $modelCoppie->scenario = "form_modifica";

        if ($model->load($this->request->post()) && $modelCoppie->load($this->request->post()))
        {
            if (!$model->validate() || !$modelCoppie->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('modifica_esercizio_coppie', ['model' => $model, 'modelCoppie' => $modelCoppie,]);
            }
            else
            {
                Esercizio::modificaEsercizio($model);
                EsercizioCoppieMinime::modificaEsercizio($modelCoppie);

                Yii::$app->session->setFlash('success', 'Esercizio modificato con successo.');
                return $this->redirect(['visualizza_esercizio', 'id' => $model->id]);
            }
        }
        else
        {
            return $this->render('modifica_esercizio_coppie', ['model' => $model, 'modelCoppie' => $modelCoppie,]);
        }
    }

    public function actionModifica_esercizio_ripetizione($esercizio)
    {
        $model = Esercizio::getDatiEsercizio($esercizio);
        $model->scenario = "form_modifica";

        $modelRipetizione = EsercizioRipetizioneParole::getDatiEsercizio($model->id);
        $modelRipetizione->scenario = "form_modifica";

        if ($model->load($this->request->post()) && $modelRipetizione->load($this->request->post()))
        {
            if (!$model->validate() || !$modelRipetizione->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('modifica_esercizio_ripetizione', ['model' => $model, 'modelRipetizione' => $modelRipetizione,]);
            }
            else
            {
                Esercizio::modificaEsercizio($model);
                EsercizioRipetizioneParole::modificaEsercizio($modelRipetizione);

                Yii::$app->session->setFlash('success', 'Esercizio modificato con successo.');
                return $this->redirect(['visualizza_esercizio', 'id' => $model->id]);
            }
        }
        else
        {
            return $this->render('modifica_esercizio_ripetizione', ['model' => $model, 'modelRipetizione' => $modelRipetizione,]);
        }
    }

    public function actionAssegna_esercizio($id_terapia)
    {
        $searchModel = new EsercizioRicerca();
        $dataProvider = $searchModel->search($this->request->queryParams, $id_terapia, true);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'terapia_id' => $id_terapia,
            'aggiungi' => true,
        ]);
    }

    public function actionRimuovi_esercizio($id_terapia)
    {
        $searchModel = new EsercizioRicerca();
        $dataProvider = $searchModel->search($this->request->queryParams, $id_terapia, false);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'terapia_id' => $id_terapia,
            'aggiungi' => false,
        ]);
    }
	
    public function actionSvolgi_esercizio($id, $coppie = false, $risposta = null)
    {
        $aiuto = $this->getModelEsercizio($id);

        if ($coppie && $risposta != null)
        {
            EsercizioSvolto::svolgiEsercizio($id, null, $risposta);
            
            Yii::$app->session->setFlash('success', 'Esercizio svolto con successo.');
            return $this->redirect(['lista_esercizi_giornalieri']);
        }

        $model = new EsercizioSvolto();
        $model->scenario = 'form';

        if ($model->load($this->request->post()))
        {
            if (!$model->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('svolgi_esercizio', ['model' => $this->findModel($id), 'modelForm' => $model, 'aiuto' => $aiuto]);
            }
            else
            {
                EsercizioSvolto::svolgiEsercizio($id, $model);
        
                Yii::$app->session->setFlash('success', 'Esercizio svolto con successo.');
                return $this->redirect(['lista_esercizi_giornalieri']);
            }
        }

        return $this->render('svolgi_esercizio', ['model' => $this->findModel($id), 'modelForm' => $model, 'aiuto' => $aiuto]);
    }

    public function actionLista_esercizi_giornalieri()
    {
        $searchModel = new EsercizioRicerca();
        $dataProvider = $searchModel->trovaEserciziTerapia($this->request->queryParams);

        return $this->render('lista_esercizi_giornalieri', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionConvalida_esercizio($id_esercizio, $id_esercizio_svolto, $valutazione = null)
    {
        $esercizioSvolto = EsercizioSvolto::find()->where(['id' => $id_esercizio_svolto])->one();

        if ($valutazione != null) {
            EsercizioSvolto::convalidaEsercizio($esercizioSvolto, $valutazione);

            Yii::$app->session->setFlash('success', 'Esercizio convalidato con successo.');
            return $this->redirect(['lista_esercizi_svolti']);
        }

        return $this->render('convalida_esercizio', ['model' => $this->findModel($id_esercizio), 'modelSvolto' => $esercizioSvolto]);
    }
	
    public function actionLista_esercizi_svolti()
    {
        $searchModel = new EsercizioSvoltoRicerca();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('lista_esercizi_svolti', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAggiungi_aiuto($esercizio){
        $model = Esercizio::getDatiEsercizio($esercizio);
        $model->scenario = "form_modifica_aiuto";

        if ($model->load($this->request->post()))
        {
            if (!$model->validate())
            {
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
                return $this->render('aggiungi_aiuto', ['model' => $model]);
            }
            else
            {
                Esercizio::modificaAiuto($model);

                Yii::$app->session->setFlash('success', 'Esercizio modificato con successo.');
                return $this->redirect(['visualizza_esercizio', 'id' => $model->id]);
            }
        }
        else
        {
            return $this->render('aggiungi_aiuto', ['model' => $model]);
        }
    }

    private function getModelEsercizio($id)
    {
        $esercizio = Esercizio::getDatiEsercizio($id);

        if ($esercizio->aiuto  != NULL)
            return $esercizio->getAiuto();

        return null;
    }

}
