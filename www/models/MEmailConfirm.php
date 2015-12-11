<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "m_email_confirm".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $token
 */
class MEmailConfirm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_email_confirm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'token'], 'required'],
            [['id_user'], 'integer'],
            [['token'], 'string', 'max' => 255]
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

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function activate()
    {
        $this->user->scenario = 'activate';
        $this->user->active = 10;

        $this->user->save();

        $this->delete();
    }

    public function disabled()
    {
        $this->user->scenario = 'activate';
        $this->user->delete();

         $this->delete();
    }

    public function sendActivateEmail()
    {
        
        $email = $this->user->email;

        $mMessage = Yii::$app->mailer->compose('@app/views/user/textEmail.php', ["token" => $this->token]);
        $mMessage->setFrom(array('denis-76@bk.ru' => 'Я Свободен!'))
                 ->setTo($email)
                 ->setSubject('Активация регистрации на ресурсе ЯСвободен');
        

        $mMessage->send();
    }
}
