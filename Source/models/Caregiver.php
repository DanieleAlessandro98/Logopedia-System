<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Caregiver".
 *
 * @property int $id
 * @property string $nome
 * @property string $cognome
 * @property string $email
 * @property string $codice_fiscale
 *
 * @property Account $id0
 * @property ListaAssistiti[] $listaAssistitis
 * @property Utente[] $utente
 */
class Caregiver extends \yii\db\ActiveRecord
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @param string $cognome
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCodiceFiscale()
    {
        return $this->codice_fiscale;
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
        return 'Caregiver';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['id', 'nome', 'cognome', 'email', 'codice_fiscale'], 'required', 'on' => 'database'],
            [['id'], 'integer', 'on' => 'database'],
            [['nome', 'cognome', 'email', 'codice_fiscale'], 'string', 'max' => 20, 'on' => 'database'],
            [['id'], 'unique', 'on' => 'database'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['id' => 'id'], 'on' => 'database'],

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
    public function getListaAssistiti()
    {
        return $this->hasMany(ListaAssistiti::className(), ['id_caregiver' => 'id']);
    }

    /**
     * Gets query for [[Utente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtente()
    {
        return $this->hasMany(Utente::className(), ['id' => 'id_utente'])->viaTable('ListaAssistiti', ['id_caregiver' => 'id']);
    }

    public static function creaCaregiver($model, $id_account){
        $caregiver = new Caregiver();
        $caregiver->scenario = 'database';

        $caregiver->id = $id_account;
        $caregiver->nome = $model->nome;
        $caregiver->cognome = $model->cognome;
        $caregiver->email = $model->email;
        $caregiver->codice_fiscale = $model->codice_fiscale;

        return $caregiver->save();
    }
	
    public static function trovaTerapiaUtente()
    {
        $lista_terapie = (new \yii\db\Query())
        ->select(['Terapia.id'])
        ->from('Caregiver')
        ->join('LEFT JOIN', 'ListaAssistiti', 'Caregiver.id = ListaAssistiti.id_caregiver')
        ->join('LEFT JOIN', 'Terapia', 'ListaAssistiti.id_utente = Terapia.id_utente')
        ->where(['Caregiver.id' => Yii::$app->user->identity->id]);

        return $lista_terapie;
    }

}
