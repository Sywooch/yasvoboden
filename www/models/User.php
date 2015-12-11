<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\FCity;
use app\models\MEmailConfirm;
use app\models\RMoneyHistory;
use app\models\RItems;
use app\models\RActiveItems;


class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */

    // Повторный пароль нужно объявить, т.к. этого поля нет в БД
    public $password_repeat;
    public $soglasie;


    public static function tableName()
    {
        return 'r_users';
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function scenarios()
    {
        return [
            'login' => ['login', 'password'],
            'register' => ['login', 'email', 'password', 'id_city', 'name', 'surname', 'phone', 'password_repeat', 'active', 'id', 'soglasie'],
            'activate' => ['active'],
            'money' => ['money'],
            'edit-user' => ['login', 'email', 'id_city', 'name', 'surname', 'phone'],
            'edit-password' => ['password', 'password_repeat'], 
        ];
    }

    public function rules()
    {
        return [
            // name, email, subject и body атрибуты обязательны
            [['active', 'id'], 'safe'],
            [['name', 'surname', 'phone', 'email', 'login', 'password', 'password_repeat', 'id_city'], 'required', 'on' => 'register'],
            [['login', 'email', 'id_city', 'name', 'surname', 'phone'], 'required', 'on' => 'edit-user'],
            [['password', 'password_repeat'], 'required', 'on' => 'edit-password'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'register'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'edit-password'],
            // атрибут email должен быть правильным email адресом
            ['email', 'email'],
            ['login', 'unique'],
            ['email', 'unique'],
            ['phone', 'unique'],
            ['phone', 'filter', 'filter' => function ($value) {
                $val = str_replace("_", "", $value);
                return $val;
            }],
            [['phone'], 'string', 'min' => 12],
            [['phone'], 'string', 'max' => 12],
            ['soglasie', 'required', 'on' => "register", 'requiredValue' => 1, 'message' => 'Вы должны согласиться с пользовательским соглашением!']
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))  
        {
            if ($this->isNewRecord)
            {
                $this->date_created = time();
                $this->money = 0;
                $this->active = 1;
                $this->password = md5($this->password);
            }

            if ($this->scenario == 'edit-password')
            {
                $this->password = md5($this->password);
            }
     
            return true;
        }
        return false;
    }

    public function getEmailConfirm()
    {
        return $this->hasOne(MEmailConfirm::className(), ['id_user' => 'id']);
    }

    public function setEmailConfirm()
    {
        
        if ($this->active == 1)
        {
            $id_user = $this->id;
            $date = $this->date_created;
            $token = md5($id_user.$date);
            $token .= md5($token); 
 
            $m_email_confirm = new MEmailConfirm;
            $m_email_confirm->id_user = $id_user;
            $m_email_confirm->token = $token;

            $m_email_confirm->save();

            $m_email_confirm->sendActivateEmail();
        }
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'E-mail',
            'surname' => 'Фамилия',
            'phone' => 'Телефон',
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Потвержение пароля',
            'id_city' => 'Город',
            'soglasie' => ''
        ];
    }

    public function getError($attribut, $input = true)
    {
        if (isset($this->errors[$attribut]))
            if ($input)
                return 'inputError';
            else
                return 'blockError';
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['login'=>$username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /** 
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function getCity()
    {
        return $this->hasOne(FCity::className(), ['id' => 'id_city']);
    }

    public function addMoney($sum, $id_type)
    {
        $this->money += $sum;
        $this->save();

        $RMoneyHistory = new RMoneyHistory();
        $RMoneyHistory->id_user = $this->id;
        $RMoneyHistory->sum = $sum;
        $RMoneyHistory->operation = 1;
        $RMoneyHistory->status = 1;
        $RMoneyHistory->date = time();
        $RMoneyHistory->id_type = $id_type;

        $RMoneyHistory->save(); 

    }


    public function minusMoney($sum)
    {
        $this->money -= $sum;
        $this->save();

        $RMoneyHistory = new RMoneyHistory();
        $RMoneyHistory->id_user = $this->id;
        $RMoneyHistory->sum = $sum;
        $RMoneyHistory->operation = 2;
        $RMoneyHistory->status = 1;
        $RMoneyHistory->date = time();

        $RMoneyHistory->save(); 
    }


    public function getMoneyHistoryAll()
    {
        return $this->hasMany(RMoneyHistory::className(), ['id_user' => 'id']);
    }

    public function getMoneyHistoryPlus()
    {
        return $this->hasMany(RMoneyHistory::className(), ['id_user' => 'id'])->where(['operation' => 1]);
    }

    public function getMoneyHistoryMinus()
    {
        return $this->hasMany(RMoneyHistory::className(), ['id_user' => 'id'])->where(['operation' => 2]);
    }


    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            
            $this->emailConfirm->delete();
            return true;
        } else {
            return false;
        }
    }

    public function getRecords()
    {
        return $this->hasMany(RItems::className(), ['id_user' => 'id']);
    }

    public function getCountRecord()
    {
        return $this->hasMany(RItems::className(), ['id_user' => 'id'])->count();
    }

    public function getCountActiveRecord()
    {
        return $this->hasMany(RItems::className(), ['id_user' => 'id'])
            ->rightJoin(RActiveItems::tableName(), "r_items.id = r_active_items.id_item")
            ->count();
    }

}
