<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\models\ar\Files;

class FileUploadForm extends Model {
    
    const UPLOAD_DIR = 'uploads';
    
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
    
    public function rules() {
        return [
            [['imageFiles'], 'file', 'maxFiles' => 20, 'extensions' => 'png, jpg, jpeg']
        ];
    }
    
    public function upload() {        
        if ($this->validate()) {
            $uploadDirPath = \Yii::getAlias('@app') . '\\' . self::UPLOAD_DIR;
            if (!file_exists($uploadDirPath)) {
                $ok = FileHelper::createDirectory($uploadDirPath);
                if (!$ok) {
                    $this->addError('imageFiles', 'Системная ошибка');
                    return false;
                }
            }
            foreach ($this->imageFiles as $file) {
                $fileName = 'file_' . uniqid("", true) . '.' . $file->getExtension();
                $fileUserName = $file->getBaseName() . '.' . $file->getExtension();
                $caption = $file->getBaseName();
                $userId = \Yii::$app->user->getId();
                $fileAr = new Files();
                $fileAr->user_id = $userId;
                $fileAr->name = $fileName;
                $fileAr->user_name = $fileUserName;
                $fileAr->caption = $caption;
                $ok = $fileAr->save();
                if (!$ok) {
                    $this->addErrors($fileAr->getErrors());
                    return false;
                }
                $fullPath = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $fileName;
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

