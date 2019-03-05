<?php


namespace app\models\ar;

use yii\db\ActiveRecord;
use yii\db\Query;

class Files extends ActiveRecord {
    
    public static function tableName() {
        return '{{files}}';
    }
    
    public function getUser() {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }
    
    public function attributeLabels() {
        return [
            'caption' => 'Заголовок',
            'description' => 'Описание'
        ];
    }
    
    public function rules() {
        return [
            [['caption', 'description'], 'safe'],
            [['caption', 'user_name', 'name'], 'string', 'length' => [0, 255]],
            [['user_id', 'name', 'user_name'], 'required']
        ];
    }
    
    public static function getImages($userId, $searchString = "") {
        $sql = 'SELECT * FROM files WHERE files.user_id = :user_id ';
        $params = [':user_id' => $userId];
        if ($searchString) {
            $sql .= ' and (files.caption like :searchString or files.description like :searchString) ';
            $params[':searchString'] = '%' . $searchString . '%';
        }
        $files =  Files::findBySql($sql, $params)->all();
        return $files;
    }
    
    public static function getOneImage($fileId) {
        return Files::find()->where(['file_id' => $fileId])->one();
    }
    
    
}