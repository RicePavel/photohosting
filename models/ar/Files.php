<?php


namespace app\models\ar;

use yii\db\ActiveRecord;

class Files extends ActiveRecord {
    
    public static function tableName() {
        return '{{files}}';
    }
    
}