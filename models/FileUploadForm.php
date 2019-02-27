<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\models\ar\Files;

class FileUploadForm extends Model {
    
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
    
    public function rules() {
        /*
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg']
        ];
         */
        return [
            [['imageFiles'], 'file', 'maxFiles' => 4]
        ];
    }
    
    public function upload() {
        if ($this->validate()) {
            $uploadDirPath = \Yii::getAlias('@app') . '\uploads';
            if (!file_exists($uploadDirPath)) {
                $ok = FileHelper::createDirectory($uploadDirPath);
                if (!$ok) {
                    $this->addError('imageFiles', 'Системная ошибка');
                    return false;
                }
            }
            foreach ($this->imageFiles as $file) {
                $fileName = 'file_' . mktime() . '.' . $file->getExtension();
                $fileUserName = $file->getBaseName() . '.' . $file->getExtension();;
                $userId = \Yii::$app->user->getId();
                $fileAr = new Files();
                $fileAr->user_id = $userId;
                $fileAr->name = $fileName;
                $fileAr->user_name = $fileUserName;
                $ok = $fileAr->save();
                if (!$ok) {
                    $this->addErrors($fileAr->getErrors());
                    return false;
                }
                $fullPath = \Yii::getAlias('@app') . '\uploads\\' . $fileName;
                $ok = $file->saveAs($fullPath);
                if (!$ok) {
                    $this->addError('imageFiles', 'Системная ошибка');
                        return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }
    
}

