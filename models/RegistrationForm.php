<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegistrationForm extends Model
{
    public $login;
    public $password;
    public $password2;

    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'password2' => 'Пароль еще раз'
        ];
    }
    
   
}
