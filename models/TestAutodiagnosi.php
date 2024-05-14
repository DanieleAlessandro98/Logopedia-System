<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TestAutodiagnosi".
 *
 * @property int $id
 * @property string $domanda_1
 * @property string $domanda_2
 * @property string $domanda_3
 * @property string $domanda_4
 * @property int $id_utente
 *
 * @property Utente $utente
 */
class TestAutodiagnosi extends \yii\db\ActiveRecord {


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'TestAutodiagnosi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domanda_1', 'domanda_2', 'domanda_3', 'domanda_4'], 'required'],
            [['domanda_1', 'domanda_2', 'domanda_3', 'domanda_4'], 'string', 'max' => 100],
            [['id_utente'], 'exist', 'skipOnError' => true, 'targetClass' => Utente::className(), 'targetAttribute' => ['id_utente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domanda_1' => 'Domanda  1',
            'domanda_2' => 'Domanda  2',
            'domanda_3' => 'Domanda  3',
            'domanda_4' => 'Domanda  4',
            'id_utente' => 'Id Utente',
        ];
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

    public static function completaTestAutodiagnosi($model,$id_utente){
        $test = new TestAutodiagnosi();

        $test->id_utente = $id_utente;
        $test->domanda_1 = $model->domanda_1;
        $test->domanda_2 = $model->domanda_2;
        $test->domanda_3 = $model->domanda_3;
        $test->domanda_4 = $model->domanda_4;

        $test->save();

        return $test->id;

    }
}
