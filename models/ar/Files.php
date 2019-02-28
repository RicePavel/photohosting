<?php


namespace app\models\ar;

use yii\db\ActiveRecord;

class Files extends ActiveRecord {
    
    public static function tableName() {
        return '{{files}}';
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
            ['caption', 'string', 'length' => [0, 255]]
        ];
    }
    
    public static function getImages($userId) {
        $files = Files::find()->where(['user_id' => $userId])->all();
        return $files;
    }
    
    public static function getOneImage($fileId) {
        return Files::find()->where(['file_id' => $fileId])->one();
    }
    
}