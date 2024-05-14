<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Comunica extends Model
{
    public $destinatario;
    public $oggetto;
    public $testo;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destinatario', 'oggetto', 'testo'], 'required'],
            [['destinatario', 'oggetto', 'testo'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'destinatario' => 'Email Logopedista',
            'oggetto' => 'Oggetto',
            'testo' => 'Testo',
        ];
    }

    public static function comunica($model)
    {
        $identity = new Account();
        $mittente = null;

        if (Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo))
            $mittente = Caregiver::findOne(['id' => Yii::$app->user->identity->id]);

        Yii::$app->mailer->compose()
            ->setTo($model->destinatario)
            ->setFrom([$mittente->email => $mittente->nome])
            ->setSubject($model->oggetto)
            ->setTextBody($model->testo)
            ->send();
    }
    
}
