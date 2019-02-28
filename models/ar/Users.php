<?php

namespace app\models\ar;

use yii\db\ActiveRecord;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Users extends ActiveRecord implements \yii\web\IdentityInterface {
    
    
    public static function tableName() {
        return '{{users}}';
    }
    
    public function rules() {
        return [
            [['login', 'password'], 'required'],
            [['login', 'password'], 'string', 'length' => [0, 255]]
        ];
    }

    public function getAuthKey(): string {
        return $this->auth_key;
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function validateAuthKey($authKey): bool {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentity($id): \yii\web\IdentityInterface {
        return static::findOne(['user_id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null): \yii\web\IdentityInterface {
        throw new NotSupportedException('method not implemented');
    }
    
    public static function findByUsername($login) {
        return static::findOne(['login' => $login]);
    }
    
    public function validatePassword($password) {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

}
