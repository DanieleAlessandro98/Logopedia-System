<?php

namespace app\models;

use Yii;

use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
/**
 * This is the model class for table "EsercizioCoppieMinime".
 *
 * @property int $id
 * @property int|null $id_esercizio
 * @property string|null $immagine_1
 * @property string|null $immagine_2
 * @property string|null $descrizione_vocale
 *
 * @property Esercizio $esercizio
 */
class EsercizioCoppieMinime extends Esercizio
{
    public $file1;
    public $file2;
    public $file_registrazione;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'EsercizioCoppieMinime';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_esercizio'], 'integer', 'on'=>'database'],
            [['immagine_1', 'immagine_2'], 'required', 'on'=>'database'],
            [['immagine_1', 'immagine_2', 'descrizione_vocale'], 'string', 'on'=>'database'],
            [['id_esercizio'], 'exist', 'skipOnError' => true, 'targetClass' => Esercizio::className(), 'targetAttribute' => ['id_esercizio' => 'id'], 'on'=>'database'],
        
            [['file1', 'file2'], 'file', /**'skipOnEmpty' => false,*/ 'extensions' => 'png, jpg', 'on'=>'form_crea'],
            [['descrizione_vocale'], 'file', 'extensions' => 'mp3', 'on' => 'form_crea'],
            [['descrizione_vocale'], 'file', 'extensions' => 'mp3', 'on' => 'form_modifica'],
            [['file1', 'file2'], 'file', 'skipOnEmpty' => true, 'checkExtensionByMimeType' => false, 'extensions' => 'png, jpg', 'on'=>'form_modifica'],
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
            'immagine_1' => 'Immagine  1',
            'immagine_2' => 'Immagine  2',
            'descrizione_vocale' => 'Descrizione Vocale',
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
        $result = EsercizioCoppieMinime::find()->select(['id', 'immagine_1', 'immagine_2'])
        ->where(['id_esercizio' => $esercizio])->one();

        if ($result !== null)
            return $result;

        throw new NotFoundHttpException('La pagina richiesta non esiste.');
    }

    public static function creaEsercizio($eser_generale, $modelCoppieMinime)
    {
        $esercizio = new EsercizioCoppieMinime();
        $esercizio->scenario = 'database';


        $esercizio->file_registrazione = UploadedFile::getInstance($modelCoppieMinime, 'file_registrazione');
        $esercizio->file_registrazione->saveAs('upload/audio/esercizi/'. $esercizio->file_registrazione->baseName . '.' . $esercizio->file_registrazione->extension);
        $esercizio->descrizione_vocale = 'upload/audio/esercizi/'. $esercizio->file_registrazione->baseName . '.' . $esercizio->file_registrazione->extension;



        $esercizio->file1 = UploadedFile::getInstance($modelCoppieMinime, 'file1');
        $esercizio->file2 = UploadedFile::getInstance($modelCoppieMinime, 'file2');

        $esercizio->file1->saveAs('upload/img/esercizi/' . $esercizio->file1->baseName . '.' . $esercizio->file1->extension);
        $esercizio->file2->saveAs('upload/img/esercizi/' . $esercizio->file2->baseName . '.' . $esercizio->file2->extension);

        $esercizio->immagine_1 = 'upload/img/esercizi/' . $esercizio->file1->baseName . '.' . $esercizio->file1->extension;
        $esercizio->immagine_2 = 'upload/img/esercizi/' . $esercizio->file2->baseName . '.' . $esercizio->file2->extension;

        $esercizio->link('esercizio', $eser_generale);
    }

    public static function modificaEsercizio($modelCoppie)
    {

        $modelCoppie->file_registrazione = UploadedFile::getInstance($modelCoppie, 'file_registrazione');
        if ($modelCoppie->file1){
            $modelCoppie->file_registrazione->saveAs('upload/audio/esercizi/'. $modelCoppie->file_registrazione->baseName . '.' . $modelCoppie->file_registrazione->extension);
            $modelCoppie->descrizione_vocale = 'upload/audio/esercizi/'. $modelCoppie->file_registrazione->baseName . '.' . $modelCoppie->file_registrazione->extension;
        }

        $modelCoppie->file1 = UploadedFile::getInstance($modelCoppie, 'file1');
        if ($modelCoppie->file1)
        {
            $modelCoppie->file1->saveAs('upload/img/esercizi/' . $modelCoppie->file1->baseName . '.' . $modelCoppie->file1->extension);
            $modelCoppie->immagine_1 = 'upload/img/esercizi/' . $modelCoppie->file1->baseName . '.' . $modelCoppie->file1->extension;    
        }

        $modelCoppie->file2 = UploadedFile::getInstance($modelCoppie, 'file2');
        if ($modelCoppie->file2)
        {
            $modelCoppie->file2->saveAs('upload/img/esercizi/' . $modelCoppie->file2->baseName . '.' . $modelCoppie->file2->extension);
            $modelCoppie->immagine_2 = 'upload/img/esercizi/' . $modelCoppie->file2->baseName . '.' . $modelCoppie->file2->extension;    
        }

        $modelCoppie->save();
    }

}
