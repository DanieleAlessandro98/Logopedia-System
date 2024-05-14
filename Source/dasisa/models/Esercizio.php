<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Esercizio".
 *
 * @property int $id
 * @property string|null $nome
 * @property string $tipologia
 *
 * @property EsercizioDenominazione[] $esercizioDenominaziones
 */
class Esercizio extends \yii\db\ActiveRecord
{
    /**
     * @return string|null
     */
    public function getNome()
    {
        return $this->nome;
    }



    public static $RULES_FORM_REQUIRED = ['nome','tipologia'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Esercizio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipologia'], 'required','on'=>'database'],
            [['tipologia'], 'string', 'on'=>'database'],
            [['nome'], 'string', 'max' => 45, 'on'=>'database'],

            [Esercizio::$RULES_FORM_REQUIRED, 'required', 'on' => 'form'],
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
            'tipologia' => 'Tipologia',
        ];
    }

    /**
     * Gets query for [[EsercizioDenominaziones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEsercizioDenominaziones()
    {
        return $this->hasMany(EsercizioDenominazione::className(), ['id_esercizio' => 'id']);
    }


    public static function creaEsercizio($model, &$id){
        $esercizio = new Esercizio();

        $esercizio->scenario = 'database';

        $esercizio->nome = $model->nome;
        $esercizio->tipologia = $model->tipologia;
        $result = $esercizio->save();

        if($result != null ) $id = $esercizio->id;

        return $result;

    }

}
