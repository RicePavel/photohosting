<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use app\models\FileUploadForm;
use yii\helpers\Url;

$this->title = 'Photohosting';
?>
<div class="site-index">

   
    <div class="body-content">

        <?php 
          
                $path = $baseUrl . '/' . FileUploadForm::UPLOAD_DIR . '/' . $file->name;
        ?>
        
            <img class='viewOneImg' src='<?= $path ?>' />
            
            <?php $form = ActiveForm::begin() ?>
                <?= $form->field($file, 'caption')->textInput() ?>
                <?= $form->field($file, 'description')->textarea() ?>
                <button>Сохранить</button>
            <?php ActiveForm::end() ?>
        
        <?php
            
        ?>
        
    </div>
</div>
