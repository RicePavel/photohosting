<?php


namespace app\models\ar;

use yii\db\ActiveRecord;

class Files extends ActiveRecord {
    
    public static function tableName() {
        return '{{files}}';
    }
    
    public static function getImages($userId) {
        $files = Files::find()->where(['user_id' => $userId])->all();
        return $files;
    }
    
}