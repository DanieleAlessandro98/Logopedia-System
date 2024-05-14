<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
/**
 * This is the model class for table "EsercizioDenominazione".
 *
 * @property int $id

 * @property int|null $id_esercizio
 * @property string|null $immagine
 * @property string|null $aiuto
 * @property string|null $registrazione_vocale
 *
 * @property Esercizio $esercizio
 */
class EsercizioDenominazione extends Esercizio
{
    //se la sposto su esercizio non funziona
    public $nome;
    public $tipologia;

    public $file;

    //public $eventImage;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'EsercizioDenominazione';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_esercizio'], 'integer', 'on' => 'database'],
            [['immagine', 'aiuto', 'registrazione_vocale'], 'string', 'on' => 'database'],
            [['id_esercizio'], 'exist', 'skipOnError' => true, 'targetClass' => Esercizio::className(), 'targetAttribute' => ['id_esercizio' => 'id'], 'on' => 'database'],

            [Esercizio::$RULES_FORM_REQUIRED, 'required', 'on' => 'form'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'on' => 'form'],
        ];
    }
    /*
    public function rules()
    {
        return ArrayHelper::merge([
            [['id_esercizio'], 'integer', 'on' => 'database'],
            [['immagine', 'aiuto', 'registrazione_vocale'], 'string', 'on' => 'database'],
            [['id_esercizio'], 'exist', 'skipOnError' => true, 'targetClass' => Esercizio::className(), 'targetAttribute' => ['id_esercizio' => 'id'], 'on' => 'database'],

            [['immagine'], 'required', 'on' => 'form'],
        ],Esercizio::$RULES_FORM);
    }
     */
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),[
            'id' => 'ID',
            'id_esercizio' => 'Id Esercizio',
            'immagine' => 'Immagine',
            'aiuto' => 'Aiuto',
            'registrazione_vocale' => 'Registrazione Vocale',
            'file' => 'Immagine',
        ]);
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


    public static function creaEsercizioDenominazione($model){
        $esercizio_generale = Esercizio::creaEsercizio($model, $id);


        if ($esercizio_generale !== null)  {
            $esercizio = new EsercizioDenominazione();
            $esercizio->scenario = 'database';
            $esercizio->id_esercizio = $id;
            //$esercizio->immagine =  $model->file->baseName . '.' . $model->file->extension;

            return $esercizio->save();
        } else {
            return null;
        }
    }
    /*

    public function upload(){
        if ($this->validate()) {
            $this->eventImage->saveAs('uploads/' . $this->eventImage->baseName . '.' . $this->eventImage->extension);
            return true;
        } else {
            return false;
        }
    }*/
}

