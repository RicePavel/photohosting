<?php


namespace app\models\ar;

use yii\db\ActiveRecord;
use yii\db\Query;

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
            [['caption', 'user_name', 'name'], 'string', 'length' => [0, 255]],
            [['user_id', 'name', 'user_name'], 'required']
        ];
    }
    
    public static function getImages($userId, $searchString = "") {
        
        $fields = ['file_id', 'user_id', 'name', 'user_name', 'description', 'caption'];
        $query = (new Query())->select($fields)
                ->from('files')->andWhere('user_id=:user_id', [':user_id' => $userId]);
        if ($searchString) {
            $query->andWhere('caption like :searchString or description like :searchString', [':searchString' => '%' . $searchString . '%']);
        }
        $filesArr = $query->all();
        
        $files = array();
        foreach ($filesArr as $arr) {
            $file = new Files();
            foreach ($fields as $field) {
                $file->$field = $arr[$field];
            }
            $files[] = $file;
        }
        
        //$files = Files::find()->where(['user_id' => $userId])->all();
        return $files;
    }
    
    public static function getOneImage($fileId) {
        return Files::find()->where(['file_id' => $fileId])->one();
    }
    
    
}