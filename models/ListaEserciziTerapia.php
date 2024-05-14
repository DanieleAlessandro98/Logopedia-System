<?php

namespace app\models;

use Yii;

use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "ListaEserciziTerapia".
 *
 * @property int $id
 * @property int $id_terapia
 * @property int $id_esercizio
 *
 * @property Esercizio $esercizio
 * @property Terapia $terapia
 * @property string $giorno 
 */
class ListaEserciziTerapia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ListaEserciziTerapia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['giorno'], 'required'],
            [['id_terapia', 'id_esercizio'], 'integer'],
            [['giorno'], 'string'], 
            [['id_terapia'], 'exist', 'skipOnError' => true, 'targetClass' => Terapia::className(), 'targetAttribute' => ['id_terapia' => 'id']],
            [['id_esercizio'], 'exist', 'skipOnError' => true, 'targetClass' => Esercizio::className(), 'targetAttribute' => ['id_esercizio' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_terapia' => 'Id Terapia',
            'id_esercizio' => 'Id Esercizio',
            'giorno' => 'Giorno della settimana in cui svolgerlo:',
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

    public function getEsercizioSvolto()
    {
        return $this->hasOne(EsercizioSvolto::className(), ['id_esercizio' => 'id_esercizio']);
    }

    public function getListaEserciziTerapia()
    {
        return $this->hasOne(ListaEserciziTerapia::className(), ['id_esercizio' => 'id_esercizio']);
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

    public function search($params, $id_terapia)
    {
        $query = ListaEserciziTerapia::find();

        $query->where(['id_terapia' => $id_terapia]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_terapia' => $this->id_terapia,
            'id_esercizio' => $this->id_esercizio,
        ]);

        return $dataProvider;
    }

    public static function assegnaEsercizio($id_terapia, $id_esercizio, $modelLista)
    {
        $model = new ListaEserciziTerapia();

        $model->id_terapia = $id_terapia;
        $model->id_esercizio = $id_esercizio;
		$model->giorno = $modelLista->giorno;

        $model->save();
    }

    public static function rimuoviEsercizio($id_terapia, $id_esercizio)
    {
        $model = ListaEserciziTerapia::find()->where(['id_terapia'=>$id_terapia])->andWhere(['id_esercizio'=>$id_esercizio])->one();

        $model->delete();
    }

    public function getListaEsercizi($id_terapia){
        $query = new Query;
        $query  ->select(['nome','giorno'])
            ->from('ListaEserciziTerapia')
            ->join( 'INNER JOIN',
                'Esercizio',
                ' ListaEserciziTerapia.id_esercizio = Esercizio.id ')
            ->where(['id_terapia' => $id_terapia]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    public static function getNumeroEserciziAssegnati($id_terapia)
    {
        return ListaEserciziTerapia::find()
        ->where(['id_terapia' => $id_terapia])
        ->count();
    }
    
}
