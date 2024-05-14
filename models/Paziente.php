<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Paziente".
 *
 * @property int $id
 * @property int $id_utente
 * @property int $id_logopedista
 *
 * @property Logopedista $logopedista
 * @property Utente $utente
 */
class Paziente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Paziente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_utente', 'id_logopedista'], 'required'],
            [['id_utente', 'id_logopedista'], 'integer'],
            [['id_utente'], 'exist', 'skipOnError' => true, 'targetClass' => Utente::className(), 'targetAttribute' => ['id_utente' => 'id']],
            [['id_logopedista'], 'exist', 'skipOnError' => true, 'targetClass' => Logopedista::className(), 'targetAttribute' => ['id_logopedista' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_utente' => 'Id Utente',
            'id_logopedista' => 'Id Logopedista',
        ];
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
}
