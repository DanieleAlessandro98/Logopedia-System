<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "Account".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $ruolo
 *
 * @property Caregiver $caregiver
 * @property Logopedista $logopedista
 * @property Utente $utente
 */
class Account extends \yii\db\ActiveRecord implements IdentityInterface
{
    private $_account;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'on' => 'database'],
            [['ruolo'], 'string', 'on' => 'database'],
            [['username'], 'string', 'max' => 20, 'on' => 'database'],
            [['password'], 'string', 'max' => 30, 'on' => 'database'],

            [['username', 'password'], 'required', 'on' => 'form'],
            [['username'], 'string', 'max' => 20, 'on' => 'form'],
            [['password'], 'string', 'max' => 30, 'on' => 'form'],
            ['username', 'validaUsername', 'on' => 'form'],


            [['username', 'password'], 'required', 'on' => 'form_login'],
            [['username'], 'string', 'max' => 20, 'on' => 'form_login'],
            [['password'], 'string', 'max' => 30, 'on' => 'form_login'],
            [['username', 'password'], 'validaAccount', 'on' => 'form_login'],
        ];
    }

    public function validaAccount()
    {
        $account = Account::trovaUsername($this->username);

        if (!$account)
        {
            $this->addError('username', 'Username non corretto.');
        }
        else
        {
            if ($this->password != $account->password)
                $this->addError('password', 'Password non corretta.');
        }
    }

    public function validaUsername()
    {
        $account = Account::trovaUsername($this->username);

        if ($account)
            $this->addError('username', 'Username esistente.');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'ruolo' => 'Ruolo',
        ];
    }

    /**
     * Gets query for [[Caregiver]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCaregiver()
    {
        return $this->hasOne(Caregiver::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[Logopedista]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogopedista()
    {
        return $this->hasOne(Logopedista::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[Utente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtente()
    {
        return $this->hasOne(Utente::className(), ['id' => 'id']);
    }

    public static function getLastID(){
        $last_user = Account::find()->orderBy('id DESC')->one();
        return $last_user->id;
    }

    public static function getLastRuolo(){
        $last_user = Account::find()->orderBy('id DESC')->one();
        return $last_user->ruolo;
    }

    public static function trovaUsername($username)
    {
        return Account::find()->where(['username' => $username])->one();
    }

    public static function creaAccount($modelRegistration, $ruolo_predefinito = null, &$nuovo_id)
    {
        $account = new Account();
        $account->scenario = 'database';

        $account->username = $modelRegistration->username;
        $account->password = $modelRegistration->password;

        if ($ruolo_predefinito == null)
            $account->ruolo = $modelRegistration->ruolo;
        else
            $account->ruolo = $ruolo_predefinito;

        $result = $account->save();
        $nuovo_id = $account->id;

        return $result;
    }

    public function login()
    {
        return Yii::$app->user->login($this->getAccount(), 3600*24*30);
    }

    public function getAccount()
    {
        if ($this->_account == false) {
            $this->_account = Account::trovaUsername($this->username);
        }

        return $this->_account;
    }

    public static function isLogopedista($ruolo)
    {
        if ($ruolo == 'Logopedista')
            return true;

        return false;
    }

    public static function isUtente($ruolo)
    {
        if ($ruolo == 'Utente')
            return true;

        return false;
    }

    public static function isCaregiver($ruolo)
    {
        if ($ruolo == 'Caregiver')
            return true;

        return false;
    }
    
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {}

    public function getAuthKey()
    {}

    public function validateAuthKey($authKey)
    {}
}
