<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use app\models\FileUploadForm;

$this->title = 'My Yii Application';
?>
<div class="site-index">

   
    <div class="body-content">

        <div class="row">
            
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            
                <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true])->label(false) ?>
            
                <button>Загрузить файлы</button>
            
            <?php ActiveForm::end() ?>
            
        </div>

        <?php 
            foreach ($files as $file) {
                $path = $baseUrl . '/' . FileUploadForm::UPLOAD_DIR . '/' . $file->name;
        ?>
                <img src='<?= $path ?>' />
        <?php
            }
        ?>
        
    </div>
</div>
