<?php

namespace app\models;

use Yii;

use app\models\Account;

/**
 * This is the model class for table "Appuntamento".
 *
 * @property int $id
 * @property int $id_caregiver
 * @property int $id_logopedista
 * @property int $id_utente
 * @property string $data
 * @property string $stato
 *
 * @property Caregiver $caregiver
 * @property Logopedista $logopedista
 * @property Utente $utente
 */
class Appuntamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Appuntamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_caregiver', 'id_logopedista', 'id_utente', 'data'], 'required', 'on'=>'database'],
            [['id_caregiver', 'id_logopedista', 'id_utente'], 'integer', 'on'=>'database'],
            [['data'], 'safe', 'on'=>'database'],
            [['stato'], 'string', 'on'=>'database'],
            [['id_caregiver'], 'exist', 'skipOnError' => true, 'targetClass' => Caregiver::className(), 'targetAttribute' => ['id_caregiver' => 'id'], 'on'=>'database'],
            [['id_logopedista'], 'exist', 'skipOnError' => true, 'targetClass' => Logopedista::className(), 'targetAttribute' => ['id_logopedista' => 'id'], 'on'=>'database'],
            [['id_utente'], 'exist', 'skipOnError' => true, 'targetClass' => Utente::className(), 'targetAttribute' => ['id_utente' => 'id'], 'on'=>'database'],
        
            [['id_logopedista', 'id_utente', 'data'], 'required', 'on'=>'form_prenota'],
            [['id_logopedista', 'id_utente'], 'integer', 'on'=>'form_prenota'],
            [['id_logopedista'], 'exist', 'skipOnError' => true, 'targetClass' => Logopedista::className(), 'targetAttribute' => ['id_logopedista' => 'id'], 'on'=>'form_prenota'],
            [['id_utente'], 'exist', 'skipOnError' => true, 'targetClass' => Utente::className(), 'targetAttribute' => ['id_utente' => 'id'], 'on'=>'form_prenota'],
            [['data'], 'validaData', 'on' => 'form_prenota'],

            [['data'], 'required', 'on'=>'form_modifica'],
            [['data'], 'validaData', 'on' => 'form_modifica'],
            [['stato'], 'string', 'on'=>'form_modifica'],
        ];
    }

    public function validaData()
    {
        $giorno = NomeGiorno::getDayName($this->data);

        if (NomeGiorno::isWeek($giorno))
            $this->addError('data', 'Data selezionata non valida. Non puoi selezionare i giorni del weekend.');

        if (NomeGiorno::isLower($this->data))
            $this->addError('data', 'Data selezionata non valida. Non puoi selezionare una data inferiore ad oggi.');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_caregiver' => 'Caregiver',
            'id_logopedista' => 'Logopedista',
            'id_utente' => 'Utente',
            'data' => 'Data',
            'stato' => 'Stato',
        ];
    }

    /**
     * Gets query for [[Caregiver]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCaregiver()
    {
        return $this->hasOne(Caregiver::className(), ['id' => 'id_caregiver']);
    }

    /**
     * Gets query for [[Logopedista]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogopedista()
    {
        return $this->hasOne(Logopedista::className(), ['id' => 'id_logopedista']);
    }

    /**
     * Gets query for [[Utente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtente()
    {
        return $this->hasOne(Utente::className(), ['id' => 'id_utente']);
    }

    public function getStato()
    {
        if ($this->stato == 'ATTESA_CAREGIVER')
            return 'In attesa del Caregiver..';
        else if ($this->stato == 'ATTESA_LOGOPEDISTA')
            return 'In attesa del Logopedista..';
        else if ($this->stato == 'CONFERMATO')
            return 'Appuntamento fissato.';
    }

    public function getData()
    {
        $formatoDB = $this->data;
        $formatoUtente = date("d-m-Y H:i", strtotime($formatoDB));

        return $formatoUtente;
    }

    public static function prenotaAppuntamento($model)
    {
        $appuntamento = new Appuntamento();
        $appuntamento->scenario = "database";

        $appuntamento->id_caregiver = Yii::$app->user->identity->id;
        $appuntamento->id_logopedista = $model->id_logopedista;
        $appuntamento->id_utente = $model->id_utente;
        $appuntamento->data = $model->data;
        $appuntamento->stato = 'ATTESA_LOGOPEDISTA';

        $appuntamento->save();

        return $appuntamento->id;
    }

    public static function confermaAppuntamento($id)
    {
        $appuntamento = Appuntamento::findOne(['id' => $id]);

        $appuntamento->stato = 'CONFERMATO';
        $appuntamento->update();
    }

    public static function modificaDataAppuntamento($model)
    {
        $identity = new Account();

        if (Yii::$app->user->isGuest == False && $identity->isLogopedista(Yii::$app->user->identity->ruolo))
            $model->stato = 'ATTESA_CAREGIVER';

        else if (Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo))
            $model->stato = 'ATTESA_LOGOPEDISTA';

        $model->update();
    }

}
