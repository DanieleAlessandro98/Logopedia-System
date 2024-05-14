<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "NomeGiorno".
 *
 * @property int $id
 * @property string|null $giorno
 */
class NomeGiorno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'NomeGiorno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['giorno'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'giorno' => 'Giorno',
        ];
    }
	
    public static function getDayName($date)
    {
        $date_format = date('w', strtotime($date));

        switch ($date_format)
        {
            case 0:
                return 'Domenica';
            case 1:
                return 'Lunedì';
            case 2:
                return 'Martedì';
            case 3:
                return 'Mercoledì';
            case 4:
                return 'Giovedì';
            case 5:
                return 'Venerdì';
            case 6:
                return 'Sabato';
            default:
                return '';
        }
    }

    public static function isWeek($date)
    {
        if ($date == 'Domenica' || $date == 'Sabato')
            return true;

        return false;
    }

    public static function isLower($date)
    {
        if (date($date) < date("Y-m-d"))
            return true;

        return false;
    }
	
}
