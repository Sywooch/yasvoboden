<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Feedback extends Model
{
    public $subject;
    public $body;
    public $email_to = "info@yasvoboden.su";

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['subject', 'body'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
           'subject' => 'Тема',
           'body' => 'Сообщение'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function send($user_id)
    {
        if ($this->validate()) {
            
            $user = User::findOne($user_id);
            $email = $user->email;
            $name = $user->name;
            $txt = "Сообщение от пользователя '".$user->login."'\r\n";
            $txt .= "Фамилия Имя: ".$user->surname." ".$user->name."\r\n";
            $txt .= "Email: ".$user->email."\r\n";
            $txt .= "Сообщение: \r\n".$this->body;

            Yii::$app->mailer->compose()
                ->setTo($this->email_to)
                ->setFrom(array('denis-76@bk.ru' => 'Я Свободен!(Обратная связь)'))
                ->setSubject($this->subject)
                ->setTextBody($txt)
                ->send();

            return true;
        }
        return false;
    }
}
