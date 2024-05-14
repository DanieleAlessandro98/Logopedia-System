<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * This is the model class for table "EsercizioSvolto".
 *
 * @property int $id
 * @property int $id_esercizio
 * @property int $id_terapia
 * @property string|null $data
 * @property string $risposta
 * @property string $valutazione
 * @property Esercizio $esercizio
 * @property Terapia $terapia
 */
class EsercizioSvolto extends \yii\db\ActiveRecord
{
    public $file_registrazione;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'EsercizioSvolto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_esercizio', 'id_terapia', 'risposta'], 'required', 'on' => 'database'],
            [['id_esercizio', 'id_terapia'], 'integer', 'on' => 'database'],
            [['data'], 'safe', 'on' => 'database'],
            [['risposta'], 'string', 'on' => 'database'],
            [['id_esercizio'], 'exist', 'skipOnError' => true, 'targetClass' => Esercizio::className(), 'targetAttribute' => ['id_esercizio' => 'id'], 'on' => 'database'],
            [['id_terapia'], 'exist', 'skipOnError' => true, 'targetClass' => Terapia::className(), 'targetAttribute' => ['id_terapia' => 'id'], 'on' => 'database'],
        
            [['file_registrazione'], 'file', 'extensions' => 'mp3', 'on' => 'form'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_esercizio' => 'Id Esercizio',
            'id_terapia' => 'Id Terapia',
            'data' => 'Data',
            'risposta' => 'Risposta',
        ];
    }

    /**
     * Gets query for [[Esercizio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEsercizio()
    {
        return $this->hasOne(Esercizio::className(), ['id' => 'id_esercizio']);
    }

    public function getNumeroEserciziCorretti($id_terapia){

         $esercizi_corretti = EsercizioSvolto::find()
            ->where(['id_terapia' => $id_terapia])
            ->where(['valutazione' => 'Giusta'])
            ->count();

         return $esercizi_corretti;
    }

    public function getNumeroEserciziErrati($id_terapia){

        $esercizi_errati = EsercizioSvolto::find()
            ->where(['id_terapia' => $id_terapia])
            ->where([ 'valutazione' => 'Sbagliata'])
            ->count();

        return $esercizi_errati;
    }
    
    /**
     * Gets query for [[Terapia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTerapia()
    {
        return $this->hasOne(Terapia::className(), ['id' => 'id_terapia']);
    }


    public function mostraEserciziSvolti($params, $id_terapia)
    {

        $query = EsercizioSvolto::find();

        $query->where(['id_terapia' => $id_terapia]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_esercizio' => $this->id_esercizio,
            'id_terapia' => $this->id_terapia,
            'data' => $this->data,
        ]);


        return $dataProvider;
    }

    public function mostraEserciziNonSvolti($params, $id_terapia)
    {
       $query =  ListaEserciziTerapia::find()
            ->leftJoin('EsercizioSvolto', 'ListaEserciziTerapia.id_terapia = EsercizioSvolto.id_terapia AND ListaEserciziTerapia.id_esercizio = EsercizioSvolto.id_esercizio')
            ->where(['EsercizioSvolto.id_esercizio' => null])
            ->andWhere(['ListaEserciziTerapia.id_terapia' => $id_terapia]);

        //$query->andwhere(['id_terapia' => $id_terapia])->all();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_esercizio' => $this->id_esercizio,
            'id_terapia' => $this->id_terapia,
            'data' => $this->data,
        ]);


        return $dataProvider;
    }
	
	    public static function trovaEserciziSvoltiOggi()
    {
        $query = self::find()->select('id_esercizio')->where('DATE(EsercizioSvolto.data) = DATE(CURRENT_TIMESTAMP)')->asArray();
        return $query;
    }

    public static function svolgiEsercizio($id, $model, $risposta = null)
    {
        $esercizioSvolto = new EsercizioSvolto();
        $esercizioSvolto->scenario = 'database';

        if ($model == null && $risposta != null)
            $esercizioSvolto->risposta = $risposta;
        else
        {
            $esercizioSvolto->file_registrazione = UploadedFile::getInstance($model, 'file_registrazione');
            $esercizioSvolto->file_registrazione->saveAs('upload/audio/esercizi/'. $esercizioSvolto->file_registrazione->baseName . '.' . $esercizioSvolto->file_registrazione->extension);
            $esercizioSvolto->risposta = 'upload/audio/esercizi/'. $esercizioSvolto->file_registrazione->baseName . '.' . $esercizioSvolto->file_registrazione->extension;
        }

        $esercizioSvolto->id_esercizio = $id;
        $esercizioSvolto->id_terapia = Utente::trovaTerapia();

        $esercizioSvolto->save();
    }

    public static function convalidaEsercizio($esercizioSvolto, $valutazione)
    {
        $esercizioSvolto->valutazione = $valutazione;
        $esercizioSvolto->update();

        Terapia::modificaStato($esercizioSvolto->id_terapia);
    }
	
}
