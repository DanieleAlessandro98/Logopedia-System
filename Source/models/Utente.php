<?php

namespace app\models;

use mysql_xdevapi\Warning;
use Yii;
use yii\bootstrap4\Alert;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\models\ListaAssistiti;

/**
 * This is the model class for table "Utente".
 *
 * @property int $id
 * @property string $nome
 * @property string $cognome
 * @property string $email
 * @property string $codice_fiscale
 * @property string $id_logopedista
 * @property string|null $diagnosi
 * @property string|null $disturbo
 *
 * @property Caregiver[] $caregivers
 * @property Account $id0
 * @property ListaAssistiti[] $listaAssistitis
 * @property Terapia $terapia
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
     * @return string
     */
    public function getDisturbo()
    {
        return $this->disturbo;
    }
    /**
     * @return string
     */
    public function getDiagnosi()
    {
        return $this->diagnosi;
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
     * @param string $disturbo
    */
    public function setDisturbo($disturbo)
    {
        $this->diagnosi = $disturbo;
    }
    /**
     * @param string $diagnosi
     */
    public function setDiagnosi($diagnosi)
    {
        $this->diagnosi = $diagnosi;
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
            [['diagnosi', 'disturbo'], 'string', 'max' => 50, 'on' => 'database'],

            [['id'], 'unique', 'on' => 'database'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['id' => 'id'], 'on' => 'database'],
            [['id_logopedista'], 'exist', 'skipOnError' => true, 'targetClass' => Logopedista::className(), 'targetAttribute' => ['id_logopedista' => 'id'], 'on' => 'database'],

            [['nome', 'cognome', 'email', 'codice_fiscale'], 'required', 'on' => 'form'],
            [['nome', 'cognome', 'email', 'codice_fiscale'], 'string', 'max' => 20, 'on' => 'form'],

            ['codice_fiscale', 'required', 'on' => 'form_aggiungi_utente'],
            ['codice_fiscale', 'string', 'max' => 20, 'on' => 'form_aggiungi_utente'],
            ['codice_fiscale', 'validaCodiceFiscale', 'on' => 'form_aggiungi_utente'],

            [['diagnosi', 'disturbo'], 'required', 'on' => 'form_effettua_diagnosi'],
        ];
    }

    public function validaCodiceFiscale()
    {
        $utente = Utente::trovaCodiceFiscale($this->codice_fiscale);

        if (!$utente)
            $this->addError('username', 'Utente non trovato.');
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
            'diagnosi' => 'Diagnosi',
            'disturbo' => 'Disturbo',
        ];
    }

    public static function trovaCodiceFiscale($codFisc)
    {
        return static::find()->select(['id', 'nome', 'cognome', 'codice_fiscale'])->where(['codice_fiscale' => $codFisc])->one();
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

    public static function trovaUtente($id){
        return static::find()->where(['id' => $id])->one();
    }

    public static function trovaUtente2($codice_fiscale){
        return static::find()->where(['codice_fiscale'=>$codice_fiscale])->one();
    }

    public static function modificaDiagnosi($model){
        $utente = Utente::trovaUtente($model->id);

        $utente->disturbo = $model->disturbo;
        $utente->diagnosi = $model->diagnosi;
        $utente->id_logopedista = Yii::$app->user->identity->id;

        return $utente->save();
    }

    public static function trovaDisturbo($id)
    {
        $utente = Utente::findOne($id);
        return $utente->disturbo;
    }

	public static function trovaTerapia($id = null)
	{
		if ($id == null)
			$id = Yii::$app->user->identity->id;

		return Terapia::getDatiTerapiaByIDUtente($id)->id;
	}

    public function getListaAssistiti()
    {
        return $this->hasOne(ListaAssistiti::className(), ['id_utente' => 'id']);
    }
	
	public function getTerapia()
    {
        return $this->hasOne(Terapia::className(), ['id_utente' => 'id']);
    }


}
