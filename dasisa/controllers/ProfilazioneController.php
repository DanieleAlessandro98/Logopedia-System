<?php

namespace app\controllers;

use app\models\Account;
use app\models\Caregiver;
use app\models\Logopedista;
use app\models\RegistrazioneCaregiver;
use app\models\RegistrazioneLogopedista;
use app\models\RegistrazioneUtente;
use app\models\Utente;
use app\widgets\Alert;
use Yii;
use yii\db\Query;
use yii\debug\models\search\Log;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegistrazioneAccount;


class ProfilazioneController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }



    public function actionRegistrazione_utente()
    {
        $modelAccount = new Account();
        $modelAccount->scenario = 'form';

        $modelUtente = new Utente();
        $modelUtente->scenario = 'form';

        if ($modelAccount->load(Yii::$app->request->post()) && $modelUtente->load(Yii::$app->request->post())) {
            if ($modelAccount->validate() && $modelUtente->validate()) {
                $account = Account::creaAccount($modelAccount, "Utente", $id);

                if ($account != null) {
                    if (Utente::creaUtente($modelUtente, $id) != null) {
                        Yii::$app->session->setFlash('success', 'Grazie di esserti registrato come utente');
                        return $this->goHome();
                    } else {
                        Yii::$app->session->setFlash('error', "Dati dell'utente non validi");
                    }
                } else {
                    Yii::$app->session->setFlash('error', "Creazione dell'account fallita");
                }

            } else {
                Yii::$app->session->setFlash('error', "Dati dell'account non validi");
            }
        }

        return $this->render('registrazione_utente', ['modelAccount' => $modelAccount, 'modelUtente' => $modelUtente]);
    }




    public function actionRegistrazione_logopedista()
    {
        $modelAccount = new Account();
        $modelAccount->scenario = 'form';

        $modelLogopedista = new Logopedista();
        $modelLogopedista->scenario = 'form';

        if ($modelAccount->load(Yii::$app->request->post()) && $modelLogopedista->load(Yii::$app->request->post())) {
            if ($modelAccount->validate() && $modelLogopedista->validate()) {
                $account = Account::creaAccount($modelAccount, "Logopedista", $id);

                if ($account != null) {
                    if (Logopedista::creaLogopedista($modelLogopedista, $id) != null) {
                        Yii::$app->session->setFlash('success', 'Grazie di esserti registrato come logopedista');
                        return $this->goHome();
                    } else {
                        Yii::$app->session->setFlash('error', "Dati del logopedista non validi");
                    }
                } else {
                    Yii::$app->session->setFlash('error', "Creazione dell'account fallita");
                }

            } else {
                Yii::$app->session->setFlash('error', "Dati dell'account non validi");
            }
        }

        return $this->render('registrazione_logopedista', ['modelAccount' => $modelAccount, 'modelLogopedista' => $modelLogopedista]);
    }


    public function actionRegistrazione_caregiver()
    {
        $modelAccount = new Account();
        $modelAccount->scenario = 'form';

        $modelCaregiver = new Caregiver();
        $modelCaregiver->scenario = 'form';

        if ($modelAccount->load(Yii::$app->request->post()) && $modelCaregiver->load(Yii::$app->request->post())) {
            if ($modelAccount->validate() && $modelCaregiver->validate()) {
                $account = Account::creaAccount($modelAccount, "Caregiver", $id);

                if ($account != null) {
                    if (Caregiver::creaCaregiver($modelCaregiver, $id) != null) {
                        Yii::$app->session->setFlash('success', 'Grazie di esserti registrato come caregiver');
                        return $this->goHome();
                    } else {
                        Yii::$app->session->setFlash('error', "Dati dell'caregiver non validi");
                    }
                } else {
                    Yii::$app->session->setFlash('error', "Creazione dell'account fallita");
                }

            } else {
                Yii::$app->session->setFlash('error', "Dati dell'account non validi");
            }
        }

        return $this->render('registrazione_caregiver', ['modelAccount' => $modelAccount, 'modelCaregiver' => $modelCaregiver]);
    }

    public function actionEffettua_accesso()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Account();
        $model->scenario = 'form_login';

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                if ($model->login()) {
                    return $this->goBack();
                }
            }
            else
            {
                Yii::$app->session->setFlash('error', "Dati dell'account non validi.");
            }
        }

        $model->password = '';
        return $this->render('effettua_accesso', ['model' => $model,]);
    }
}