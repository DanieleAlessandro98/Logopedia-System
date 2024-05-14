<?php

namespace app\controllers;

use app\models\EsercizioSvolto;
use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\ListaEserciziTerapia;
use app\models\Terapia;
use app\models\TerapiaRicerca;
use app\models\Account;
use app\models\Esercizio;

class TerapiaController extends Controller
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
                            'actions' => ['index', 'lista_terapie','monitora_terapia_utente'],
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
                                return $this->autentificazioneLogopedista($rule, $action);
                            }
                        ],
                    ],
                ],
            ],
        );
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


    public function actionLista_terapie()
    {
        $searchModel = new TerapiaRicerca();
        $dataProvider = $searchModel->getDatiTerapieByCaregiver($this->request->queryParams);

        return $this->render('lista_terapie', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVisualizza_terapia($id)
    {
        $searchModel = new ListaEserciziTerapia();
        $dataProvider = $searchModel->search($this->request->queryParams, $id);

        return $this->render('visualizza_terapia', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMonitora_terapie_utenti(){
        $searchModel = new TerapiaRicerca();
        $dataProvider = $searchModel->getDatiTerapie($this->request->queryParams);

        return $this->render('monitora_terapie_utenti', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMonitora_terapia_utente($id)
    {
        $searchModel = new EsercizioSvolto();
        $dataProvider = $searchModel->mostraEserciziSvolti($this->request->queryParams,$id);

        $numero_esercizi_corretti = $searchModel->getNumeroEserciziCorretti($id);
        $numero_esercizi_errati = $searchModel->getNumeroEserciziErrati($id);

        $searchModel2 = new EsercizioSvolto();
        $dataProvider2 = $searchModel2->mostraEserciziNonSvolti($this->request->queryParams, $id);

        return $this->render('monitora_terapia_utente', [
            'model' => Terapia::getDatiTerapia($id),
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'esercizi_corretti' => $numero_esercizi_corretti,
            'esercizi_errati' => $numero_esercizi_errati
        ]);
    }

    public function actionCrea_terapia()
    {
        $model = new Terapia();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                
                $id = Terapia::CreaTerapia($model);
                return $this->redirect(['visualizza_terapia', 'id' => $id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('crea_terapia', [
            'model' => $model,
        ]);
    }

    public function actionModifica_terapia($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            Terapia::modificaTerapia($model);
            return $this->redirect(['visualizza_terapia', 'id' => $model->id]);
        }

        return $this->render('modifica_terapia', [
            'model' => $model,
        ]);

    }

    public function actionElimina_terapia($id)
    {
        $model = $this->findModel($id);
        Terapia::eliminaTerapia($model);

        return $this->redirect(['lista_terapie']);
    }

    /**
     * Finds the Terapia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Terapia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Terapia::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAssegna_esercizio($id_terapia, $id_esercizio)
    {
        $modelLista = new ListaEserciziTerapia();

        if ($modelLista->load($this->request->post()))
        {
            ListaEserciziTerapia::assegnaEsercizio($id_terapia, $id_esercizio, $modelLista);

            Yii::$app->session->setFlash('success', 'Esercizio aggiunto con successo alla terapia');
            return $this->redirect(['esercizio/assegna_esercizio', 'id_terapia' => $id_terapia]);    
        }
        
        return $this->render('_form_giornaliero', [
            'modelEsercizio' => Esercizio::findOne(['id' => $id_esercizio]),
            'modelLista' => $modelLista,
            'id_esercizio' => $id_esercizio,
            'id_terapia' => $id_terapia,
        ]);
    }

    public function actionRimuovi_esercizio($id_terapia, $id_esercizio)
    {
        ListaEserciziTerapia::rimuoviEsercizio($id_terapia, $id_esercizio);

        Yii::$app->session->setFlash('success', 'Esercizio rimosso con successo alla terapia');
        return $this->redirect(['esercizio/rimuovi_esercizio', 'id_terapia' => $id_terapia]);
    }
}
