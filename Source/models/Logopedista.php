<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "Logopedista".
 *
 * @property int $id
 * @property string $matricola
 * @property string $nome
 * @property string $cognome
 * @property string $email
 *
 * @property Account $id0
 * @property Paziente[] $pazientes
 */
class Logopedista extends \yii\db\ActiveRecord
{
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $matricola
     */
    public function setMatricola($matricola)
    {
        $this->matricola = $matricola;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param string $cognome
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Logopedista';
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMatricola()
    {
        return $this->matricola;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */

    public function rules(){
        return [
            [['id', 'matricola', 'nome', 'cognome', 'email'], 'required', 'on'=>'database'],
            [['id'], 'integer', 'on'=>'database'],
            [['matricola'], 'string', 'max' => 6, 'on'=>'database'],
            [['nome', 'cognome', 'email'], 'string', 'max' => 20, 'on'=>'database'],
            [['matricola'], 'unique', 'on'=>'database'],
            [['id'], 'unique', 'on'=>'database'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['id' => 'id'], 'on'=>'database'],

            [['matricola', 'nome', 'cognome', 'email'], 'required', 'on' => 'form'],
            ['matricola', 'validaMatricola', 'on' => 'form'],
        ];
    }

    public function validaMatricola(){
        $matricola = Logopedista::trovaMatricola($this->matricola);

        if ($matricola)
            $this->addError('matricola', 'Logopedista con matricola già esistente.');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'matricola' => 'Matricola',
            'nome' => 'Nome',
            'cognome' => 'Cognome',
            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Account::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[Appuntamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppuntamenti()
    {
        return $this->hasMany(Appuntamento::className(), ['id_logopedista' => 'id']);
    }
	
    /**
     * Gets query for [[Utentes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtenti()
    {
        return $this->hasMany(Utente::className(), ['id_logopedista' => 'id']);
    }
	
    public static function trovaMatricola($matricola){
        return Logopedista::find()->where(['matricola' => $matricola])->one();
    }

    public static function creaLogopedista($model, $id_account){
        $logopedista = new Logopedista();
        $logopedista->scenario = 'database';

        $logopedista->id = $id_account;
        $logopedista->nome = $model->nome;
        $logopedista->cognome = $model->cognome;
        $logopedista->email = $model->email;
        $logopedista->matricola = $model->matricola;

        return $logopedista->save();
    }

    public static function aggiungiUtente($utente){
        $utente->id_logopedista = Yii::$app->user->identity->id;
        $utente->update();
    }

    public function getListaLogopedisti()
    {
        $query = Logopedista::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'cognome', $this->cognome])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

}
