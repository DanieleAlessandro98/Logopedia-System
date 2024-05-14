<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "Esercizio".
 *
 * @property int $id
 * @property string|null $nome
 * @property string $tipologia
 * @property string|null $disturbo
 * @property string|null $aiuto
 *
 * @property EsercizioCoppieMinime[] $esercizioCoppieMinime
 * @property EsercizioDenominazione[] $esercizioDenominazione
 * @property EsercizioRipetizioneParole[] $esercizioRipetizioneParole
 * @property ListaEserciziTerapia[] $listaEserciziTerapia
 * @property EsercizioSvolto[] $esercizioSvolto
 */
class Esercizio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Esercizio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipologia'], 'required', 'on'=>'database'],
            [['tipologia'], 'string', 'on'=>'database'],
            [['nome'], 'string', 'max' => 45, 'on'=>'database'],
            [['disturbo'], 'string', 'max' => 50, 'on'=>'database'],
			[['parola', 'fonema'], 'string', 'max' => 100, 'on'=>'database'],

            [['nome'], 'required', 'on'=>'form_crea'],
            ['nome', 'validaNomeEsercizio', 'on' => 'form_crea'],
            [['nome','disturbo'], 'string', 'on'=>'form_crea'],
            [['aiuto'], 'string', 'on'=>'form_crea'],
			[['parola', 'fonema'], 'string', 'on'=>'form_crea'],

            [['nome','disturbo','aiuto'], 'string', 'on'=>'form_modifica'],
            [['aiuto'], 'string', 'on'=>'form_modifica_aiuto'],
			[['parola', 'fonema'], 'string', 'on'=>'form_modifica'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'tipologia' => 'Tipologia',
            'disturbo' => 'Disturbo',
            'aiuto' => 'Aiuto',
            'parola' => 'Parola', 
            'fonema' => 'Fonema', 
        ];
    }

    /**
     * Gets query for [[EsercizioCoppieMinime]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEsercizioCoppieMinime()
    {
        return $this->hasMany(EsercizioCoppieMinime::className(), ['id_esercizio' => 'id']);
    }

    /**
     * Gets query for [[EsercizioDenominazione]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEsercizioDenominazione()
    {
        return $this->hasMany(EsercizioDenominazione::className(), ['id_esercizio' => 'id']);
    }

    /**
     * Gets query for [[EsercizioRipetizioneParole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEsercizioRipetizioneParole()
    {
        return $this->hasMany(EsercizioRipetizioneParole::className(), ['id_esercizio' => 'id']);
    }

    /**
     * Gets query for [[ListaEserciziTerapia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListaEserciziTerapia()
    {
        return $this->hasMany(ListaEserciziTerapia::className(), ['id_esercizio' => 'id']);
    }

   /**
    * Gets query for [[EsercizioSvolto]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getEsercizioSvolto()
   {
       return $this->hasMany(EsercizioSvolto::className(), ['id_esercizio' => 'id']);
   }
   
    public function validaNomeEsercizio()
    {
        $nome = Esercizio::trovaNomeEsercizio($this->nome);

        if ($nome)
            $this->addError('nome', "Nome dell'esercizio già utilizzato.");
    }

    public static function trovaNomeEsercizio($nome)
    {
        return Esercizio::find()->where(['nome' => $nome])->one();
    }

    public static function getDatiEsercizio($esercizio)
    {
        $result = static::find()->select(['Esercizio.id', 'nome', 'tipologia','disturbo','aiuto', 'parola', 'fonema'])
        ->where(['Esercizio.id' => $esercizio])->one();

        if ($result !== null)
            return $result;

        throw new NotFoundHttpException('La pagina richiesta non esiste.');
    }

    public static function creaEsercizio($model, $tipologia)
    {
        $esercizio = new Esercizio();
        $esercizio->scenario = "database";

        $esercizio->nome = $model->nome;
        $esercizio->disturbo = $model->disturbo;
        $esercizio->tipologia = $tipologia;
        $esercizio->aiuto = $model->aiuto;
        $esercizio->parola = $model->parola;
        $esercizio->fonema = $model->fonema;
		
        $esercizio->save();

        return $esercizio;
    }

    public static function modificaEsercizio($model)
    {
        $model->save();
    }

    public static function modificaAiuto($model)
    {
        $model->save();
    }

    public function getListaEsercizi()
    {
        $query = Esercizio::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'tipologia', $this->tipologia]);

        return $dataProvider;
    }

    public function getAiuto()
    {
        return $this->aiuto;
    }
}
