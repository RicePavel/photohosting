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
            [['login'], 'email', 'message' => Yii::t('app', 'Enter a valid email')],
            [['login', 'password', 'password2'], 'string', 'length' => [4], 'tooShort' => Yii::t('app', 'At least {number} symbols', array('number' => 4))],
            [['login', 'password', 'password2'], 'required', 'message' => Yii::t('app', 'Required field')],
            [['password', 'password2'], function() {
                if ($this->password !== $this->password2) {
                    $this->addErrors(['password2' => Yii::t('app', 'Passwords do not match')]);
                }
            }],
            [['login'], function() {
                $exists = Users::find()->where(['login' => $this->login])->exists();
                if ($exists) {
                    $this->addErrors(['login' => Yii::t('app', 'User with this login already exists')]);
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
