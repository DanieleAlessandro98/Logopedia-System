<?php

namespace app\controllers;

use Yii;

use app\models\TestAutodiagnosi;
use app\models\TestAutodiagnosiRicerca;
use app\models\Account;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

/**
 * TestAutodiagnosiController implements the CRUD actions for TestAutodiagnosi model.
 */
class TestAutodiagnosiController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['crea_testautodiagnosi', 'visualizza_test', 'visualizza_pdf'],
                            'allow' => true,
                            'matchCallback' => function ($rule, $action) {
                                return $this->autentificazioneUtente($rule, $action);
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

                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],


            ]
        );
    }


    protected function autentificazioneLogopedista($rule, $action)
    {
        $identity = new Account();
        return $identity->isLogopedista(Yii::$app->user->identity->ruolo);
    }

    protected function autentificazioneUtente($rule,$action){
        $identity = new Account();
        if(Yii::$app->user->isGuest == false )
             return $identity->isUtente(Yii::$app->user->identity->ruolo);
        return true;
    }
    protected function verificaUtenteGuest(){
        $identity = new Account();
        if(Yii::$app->user->isGuest == false){
            if($identity->isUtente(Yii::$app->user->identity->ruolo) ==  true){
                return Yii::$app->user->identity->id;
            }
            else{
                return null;
            }
        }else{
            return null;
        }

    }

    public function actionVisualizza_test($id)
    {
        return $this->render('visualizza_test', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCrea_testautodiagnosi()
    {
        $model = new TestAutodiagnosi();

        $id_utente = $this->verificaUtenteGuest();

        if ($model->load(Yii::$app->request->post())) {

            if(!$model->validate()){
                Yii::$app->session->setFlash('error', 'Dati inseriti non validi.');
            }
            else{
                $test_id = TestAutodiagnosi::completaTestAutodiagnosi($model,$id_utente);

                Yii::$app->session->setFlash('success', 'Test completato con successo.');
                return $this->redirect(['visualizza_test', 'id' => $test_id]);
            }

        }

        return $this->render('crea_testautodiagnosi', ['model' => $model,]);
    }

    public function actionVisualizza_pdf($id)
    {
        $pdf = new Pdf([
            'content' => $this->renderPartial('visualizza_pdf', ['model' => $this->findModel($id),]),
        ]);

        return $pdf->render();
    }

    /**
     * Finds the TestAutodiagnosi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TestAutodiagnosi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TestAutodiagnosi::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
