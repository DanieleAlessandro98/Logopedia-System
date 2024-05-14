<?php

namespace app\models;

use mysql_xdevapi\Warning;
use Yii;
use yii\bootstrap4\Alert;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Utente".
 *
 * @property int $id
 * @property string $nome
 * @property string $cognome
 * @property string $email
 * @property string $codice_fiscale
 *
 * @property Caregiver[] $caregivers
 * @property Account $id0
 * @property ListaAssistiti[] $listaAssistitis
 */
class Utente extends \yii\db\ActiveRecord
{

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
     * @return string
     */
    public function getCodiceFiscale()
    {
        return $this->codice_fiscale;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param string $codice_fiscale
     */
    public function setCodiceFiscale($codice_fiscale)
    {
        $this->codice_fiscale = $codice_fiscale;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Utente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(){
        return [
            [['id', 'nome', 'cognome', 'email', 'codice_fiscale'], 'required', 'on' => 'database'],
            [['id', 'id_logopedista'], 'integer', 'on' => 'database'],
            [['nome', 'cognome', 'email', 'codice_fiscale'], 'string', 'max' => 20, 'on' => 'database'],
            [['id'], 'unique', 'on' => 'database'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['id' => 'id'], 'on' => 'database'],
            [['id_logopedista'], 'exist', 'skipOnError' => true, 'targetClass' => Logopedista::className(), 'targetAttribute' => ['id_logopedista' => 'id'], 'on' => 'database'],

            [['nome', 'cognome', 'email', 'codice_fiscale'], 'required', 'on' => 'form'],
            [['nome', 'cognome', 'email', 'codice_fiscale'], 'string', 'max' => 20, 'on' => 'form'],
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
            'cognome' => 'Cognome',
            'email' => 'Email',
            'codice_fiscale' => 'Codice Fiscale',
        ];
    }

    /**
     * Gets query for [[Caregivers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCaregivers()
    {
        return $this->hasMany(Caregiver::className(), ['id' => 'id_caregiver'])->viaTable('ListaAssistiti', ['id_utente' => 'id']);
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
     * Gets query for [[ListaAssistitis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListaAssistitis()
    {
        return $this->hasMany(ListaAssistiti::className(), ['id_utente' => 'id']);
    }




    public static function creaUtente($model, $id_account){
        $utente = new Utente();
        $utente->scenario = 'database';

        $utente->id = $id_account;
        $utente->nome = $model->nome;
        $utente->cognome = $model->cognome;
        $utente->email = $model->email;
        $utente->codice_fiscale = $model->codice_fiscale;

        return $utente->save();
    }


}
