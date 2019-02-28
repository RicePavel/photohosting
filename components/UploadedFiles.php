<?php

namespace app\components;

use app\models\ar\Files;
use app\models\FileUploadForm;

class UploadedFiles {
    
    public static function deleteFile($fileId) {
        $model = Files::getOneImage($fileId);
        $fileName = $model->name;
        $ok = $model->delete();
        if ($ok) {
            $fullPath = \Yii::getAlias('@app') . '\\' . FileUploadForm::UPLOAD_DIR . '\\' . $fileName;
            $ok = unlink($fullPath);
            if (!$ok) {
                $error = 'Не удалось удалить файл';
            }
        } else {
            $error = implode(',', $file->errors);
        }
        $return = ['status' => $ok, 'error' => $error];
        return $return;
    }
    
    public static function deleteFiles($fileIds) {
        $ok = true;
        $error = '';
        foreach ($fileIds as $fileId) {
            $result = self::deleteFile($fileId);
            if (!$result['status']) {
                $ok = false;
                $error = $result['error'];
                break;
            }
        }
        return ['status' => $ok, 'error' => $error];
    }
    
}

