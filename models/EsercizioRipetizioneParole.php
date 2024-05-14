<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EsercizioRipetizioneParole".
 *
 * @property int $id
 * @property int|null $id_esercizio
 * @property string|null $parola_1
 * @property string|null $parola_2
 * @property string|null $parola_3
 * @property string|null $registrazioneVocale
 *
 * @property Esercizio $esercizio
 */
class EsercizioRipetizioneParole extends Esercizio
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'EsercizioRipetizioneParole';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_esercizio'], 'integer', 'on' => 'database'],
            [['parola_1', 'parola_2', 'parola_3', 'registrazioneVocale'], 'string', 'on' => 'database'],
            [['id_esercizio'], 'exist', 'skipOnError' => true, 'targetClass' => Esercizio::className(), 'targetAttribute' => ['id_esercizio' => 'id'], 'on' => 'database'],

            [['parola_1', 'parola_2', 'parola_3'], 'string', 'on' => 'form_crea'],
            [['parola_1', 'parola_2','parola_3'], 'required', 'on' => 'form_crea'],

            [['parola_1', 'parola_2', 'parola_3'], 'string', 'on' => 'form_modifica'],
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
            'parola_1' => 'Parola  1',
            'parola_2' => 'Parola  2',
            'parola_3' => 'Parola  3',
            'registrazioneVocale' => 'Registrazione Vocale',
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
        $result = static::find()->select(['id', 'parola_1', 'parola_2', 'parola_3'])
        ->where(['id_esercizio' => $esercizio])->one();

        if ($result !== null)
            return $result;

        throw new NotFoundHttpException('La pagina richiesta non esiste.');
    }

    public static function creaEsercizio($eser_generico, $modelRipetizioneParole)
    {
        $esercizio = new EsercizioRipetizioneParole();
        $esercizio->scenario = 'database';

        $esercizio->parola_1 = $modelRipetizioneParole->parola_1;
        $esercizio->parola_2 = $modelRipetizioneParole->parola_2;
        $esercizio->parola_3 = $modelRipetizioneParole->parola_3;

        $esercizio->link('esercizio', $eser_generico);
    }

    public static function modificaEsercizio($modelDenominazione)
    {
        $modelDenominazione->save();
    }

}
