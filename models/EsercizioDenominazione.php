<?php

namespace app\models;

use Yii;

use yii\web\NotFoundHttpException;
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
    public $file;

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
            [['id_esercizio'], 'integer', 'on'=>'database'],
            [['immagine', 'aiuto', 'registrazione_vocale'], 'string', 'on'=>'database'],
            [['id_esercizio'], 'exist', 'skipOnError' => true, 'targetClass' => Esercizio::className(), 'targetAttribute' => ['id_esercizio' => 'id'], 'on'=>'database'],

            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'on' => 'form_crea'],

            [['file'], 'file', 'skipOnEmpty' => true, 'checkExtensionByMimeType' => false, 'extensions' => 'png, jpg', 'on' => 'form_modifica'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_esercizio' => 'Id Esercizio',
            'immagine' => 'Immagine',
            'aiuto' => 'Aiuto',
            'registrazione_vocale' => 'Registrazione Vocale',

            'file' => 'Inserisci immagine esercizio:',
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

    public static function getDatiEsercizio($esercizio)
    {
        $result = static::find()->select(['id', 'immagine'])
        ->where(['id_esercizio' => $esercizio])->one();

        if ($result !== null) {
            return $result;
        }
        throw new NotFoundHttpException('La pagina richiesta non esiste.');
    }

    public static function creaEsercizio($eser_generale, $modelDenominazione)
    {
        $esercizio = new EsercizioDenominazione();
        $esercizio->scenario = 'database';
        
        $esercizio->file = UploadedFile::getInstance($modelDenominazione, 'file');
        if($esercizio->file != null)
        {
            $esercizio->file->saveAs('upload/img/esercizi/' . $esercizio->file->baseName . '.' . $esercizio->file->extension);
            $esercizio->immagine = 'upload/img/esercizi/' . $esercizio->file->baseName . '.' . $esercizio->file->extension;
            $esercizio->link('esercizio', $eser_generale);
        }
    }

    public static function modificaEsercizio($modelDenominazione)
    {
        $modelDenominazione->file = UploadedFile::getInstance($modelDenominazione, 'file');

        if ($modelDenominazione->file)
        {
            $modelDenominazione->file->saveAs('upload/img/esercizi/' . $modelDenominazione->file->baseName . '.' . $modelDenominazione->file->extension);
            $modelDenominazione->immagine = 'upload/img/esercizi/' . $modelDenominazione->file->baseName . '.' . $modelDenominazione->file->extension;    
        }

        $modelDenominazione->save();
    }
    
}
