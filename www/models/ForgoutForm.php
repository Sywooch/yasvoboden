<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class ForgoutForm extends Model
{
    public $email;
   

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email'], 'required'],
            // password is validated by validatePassword()
            ['email', 'email']
            
        ];
    }


    public function sendForgout()
    {
        if ($this->validate()) 
        { 
            $RForgout = new RForgout();
            $RForgout->send($this->email);

            $result["status"] = "ok";
            $result["msg"] = "На Ваш указанный электронный адрес отправлено сообщение, со ссылкой на восстанавление пароля!";
            return json_encode($result);
        }
        else
        {
            $result["status"] = "error";
            $result["error"] = "";
            foreach ($this->errors as $error_field) 
                foreach($error_field as $error)
                    $result["error"] .=  $error;
           
            return json_encode($result);
        }
    }



}
