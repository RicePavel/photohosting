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

    public function rules() {
        return [
            [['login', 'password', 'password2'], 'safe'],
            [['login'], 'email', 'message' => 'введите корректный email'],
            [['login', 'password', 'password2'], 'string', 'length' => [4], 'tooShort' => 'не менее 4 символов'],
            [['login', 'password', 'password2'], 'required', 'message' => 'Обязательное поле'],
            [['password', 'password2'], function() {
                if ($this->password !== $this->password2) {
                    $this->addErrors(['password2' => 'Пароли не совпадают']);
                }
            }]
        ];
    }
    
    public function attributeLabels() {
        return [
            'login' => 'Email',
            'password' => 'Пароль',
            'password2' => 'Пароль еще раз'
        ];
    }
    
   
}
