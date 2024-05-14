<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "Terapia".
 *
 * @property int $id
 * @property int|null $id_utente
 * @property string|null $nome
 * @property string|null $disturbo
 * @property string|null $stato
 */
class Terapia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Terapia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_utente'], 'integer'],
            [['nome'], 'string', 'max' => 45],
            [['disturbo', 'stato'], 'string', 'max' => 50],
            [['id_utente'], 'exist', 'skipOnError' => true, 'targetClass' => Utente::className(), 'targetAttribute' => ['id_utente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_utente' => ' ID Utente',
            'nome' => 'Nome',
            'disturbo' => 'Disturbo',
            'stato' => 'Stato',
        ];
    }

    public function getUtente()
    {
        return $this->hasOne(Utente::className(),['id' => 'id_utente']);
    }

    public function getEsercizioSvolto(){
        return $this->hasOne(EsercizioSvolto::className(),['id_terapia' => 'id']);

    }
    public static function creaTerapia($model)
    {
        $model->disturbo = Utente::trovaDisturbo($model->id_utente);
        $model->save();

        return $model->id;
    }

    public static function modificaTerapia($model)
    {
        $model->disturbo = Utente::trovaDisturbo($model->id_utente);
        $model->save();
    }

    public static function eliminaTerapia($model)
    {
        $model->delete();
    }

    public static function getDatiTerapia($id_terapia){
        if (($model = Terapia::findOne(['id' => $id_terapia])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getListaAssistiti()
    {
        return $this->hasOne(ListaAssistiti::className(), ['id_utente' => 'id_utente']);
    }

    public static function getDatiTerapiaByIDUtente($id_utente, $terapia_in_corso = true){
        if ($terapia_in_corso == false)
        {
            if (($model = Terapia::findOne(['id_utente' => $id_utente ])) !== null) {
                return $model;
            }
        }
        else
        {
            if (($model = Terapia::find(['id_utente' => $id_utente ])->where('stato <> 100')->one()) !== null) {
                return $model;
            }
        }

        throw new NotFoundHttpException('non trovato');
    }

    public static function modificaStato($id)
    {
        $terapia = Terapia::find(['id' => $id ])->where('stato <> 100')->one();
        $esercizio_svolto = new EsercizioSvolto();

        $esercizi_convalidati = $esercizio_svolto->getNumeroEserciziCorretti($id) + $esercizio_svolto->getNumeroEserciziErrati($id);
        $esercizi_assegnati = ListaEserciziTerapia::getNumeroEserciziAssegnati($id);

        $stato_risultato = ($esercizi_convalidati / $esercizi_assegnati) * 100;
        $stato = round($stato_risultato, 0);

        $terapia->stato = $stato;
        $terapia->update(false);
    }

}
