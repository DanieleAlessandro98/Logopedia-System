<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "listaassistiti".
 *
 * @property int $id_caregiver
 * @property int $id_utente
 * @property string|null $nome
 * @property string|null $cognome
 * @property string|null $codice_fiscale
 */
class ListaAssistiti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ListaAssistiti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_caregiver', 'id_utente'], 'required'],
            [['id_caregiver', 'id_utente'], 'integer'],
            [['nome', 'cognome', 'codice_fiscale'], 'string', 'max' => 64],
            [['id_caregiver', 'id_utente'], 'unique', 'targetAttribute' => ['id_caregiver', 'id_utente']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_caregiver' => Yii::t('app', 'Id Caregiver'),
            'id_utente' => Yii::t('app', 'Id Utente'),
            'nome' => Yii::t('app', 'Nome'),
            'cognome' => Yii::t('app', 'Cognome'),
            'codice_fiscale' => Yii::t('app', 'Codice Fiscale'),
        ];
    }

    public static function AggiungiAssistito($model,$utente){
        $model->nome = $utente->nome;
        $model->cognome = $utente->cognome;
        $model->codice_fiscale = $utente->codice_fiscale;
        $model->id_utente = $utente->id;
        $model->save();
    }

    public static function modificaAssistito($model,$utente){
        $model->nome = $utente->nome;
        $model->cognome = $utente->cognome;
        $model->codice_fiscale = $utente->codice_fiscale;
        $model->id_utente = $utente->id;

        $model->save();
    }

    public function eliminaAssistito($id_caregiver,$id_utente){
        $this->findModel($id_caregiver, $id_utente)->delete();
    }

    /**
     * Finds the Listaassistiti model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_caregiver Id Caregiver8
     * @param int $id_utente Id Utente
     * @return Listaassistiti the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id_caregiver, $id_utente)
    {
        if (($model = Listaassistiti::findOne(['id_caregiver' => $id_caregiver, 'id_utente' => $id_utente])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
