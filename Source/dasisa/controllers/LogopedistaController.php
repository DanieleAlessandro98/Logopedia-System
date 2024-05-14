<?php

namespace app\controllers;

use app\models\Esercizio;
use app\models\EsercizioDenominazione;
use Yii;
use yii\web\Controller;
use app\models\AggiungiAssistitoForm;
use yii\web\UploadedFile;


class LogopedistaController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreaEsercizio2()
    {
        $model = new Esercizio();
        if ($model->load(Yii::$app->request->post())) {
            $esercizio = $model->creaEsercizio();

            if ($esercizio != null)
                return $this->render('aggiungi-assistito-riuscito');
            else
                return $this->render('aggiungi-assistito-fallito');
        }

        return $this->render('crea_esercizio', ['model' => $model]);
    }

    public function actionCrea_esercizio()
    {
        $model = new EsercizioDenominazione();
        $model->scenario = 'form';


        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //$model->file = UploadedFile::getInstance($model, 'file');
                //$model->file->saveAs('upload/'.$model->file->baseName.'.'.$model->file->extension);
                $eser = EsercizioDenominazione::creaEsercizioDenominazione($model);

                if ($eser != null /* && $model->upload()*/) {
                    Yii::$app->session->setFlash('success', 'Grazie di esserti registrato come logopedista');
                    return $this->goHome();
                } else {
                    Yii::$app->session->setFlash('error', "Creazione dell'account fallita");
                }

            } else {
                Yii::$app->session->setFlash('error', "Dati dell'account non validi");
            }
        }

        return $this->render('crea_esercizio', ['model' => $model]);
    }

    public function actionAggiungiAssistito()
    {
        $model = new AggiungiAssistitoForm();

        if ($model->load(Yii::$app->request->post())) {
            $assistito = $model->aggiungiAssistito();

            if ($assistito != null)
                return $this->render('aggiungi-assistito-riuscito', ['utente' => $assistito]);
            else
                return $this->render('aggiungi-assistito-fallito');
        }

        return $this->render('aggiungi-assistito', ['model' => $model]);
    }


}
