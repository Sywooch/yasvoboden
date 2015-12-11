<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "r_forgout".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $token
 */
class RForgout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_forgout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'token'], 'required'],
            [['id_user'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'token' => 'Token',
        ];
    }

    public function send($email)
    {
        $user = User::findOne(['email' => $email]);
        if ($user) 
        {
            $token = md5(time().$user->id.$user->email);

            $this->id_user = $user->id;
            $this->token = $token;
            $this->date = time();

            $login = $user->login;
            $id_user = $user->id;

            $mMessage = Yii::$app->mailer->compose('@app/views/user/textEmailForgout.php', ["token" => $this->token, 'login' => $login, 
                        'id_user' => $id_user]);

            $mMessage->setFrom(array('denis-76@bk.ru' => 'Я Свободен!'))
                     ->setTo($email)
                     ->setSubject('Востановление пароля');
            
 
            $mMessage->send();

            $this->save();
        }
    }

    public function validGet($login)
    {
        $user = User::findOne($this->id_user);

        if ($user->login == $login)
        {
            Yii::$app->user->login($user);
            $this->delete();

            return true;
        }
        else
            return false;
    }
}
