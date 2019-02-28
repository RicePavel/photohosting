<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use app\models\FileUploadForm;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

   
    <div class="body-content">
        
        <?php 
          
                $path = $baseUrl . '/' . FileUploadForm::UPLOAD_DIR . '/' . $file->name;
        ?>
                <img class='viewOneImg' src='<?= $path ?>' />
                <div><?= $file->caption ?></div>
                <div><?= $file->description ?></div>
                <div>
                    
                    <a href='<?= Url::to(['site/edit_image', 'file_id' => $file->file_id]) ?>' >Редактировать</a>
                    
                    <?php $form = ActiveForm::begin(['action' => Url::to(['site/delete_image'])]) ?>
                        <input type='hidden' name='file_id' value='<?= $file->file_id ?>' />
                        <button>Удалить</button>
                    <?php ActiveForm::end() ?>
                </div>
        <?php
            
        ?>
        
    </div>
</div>
