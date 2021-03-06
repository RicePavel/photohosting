<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use app\models\FileUploadForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Photohosting';
?>
<div class="site-index">

   
    <div class="body-content">
        
        <?php if (Yii::$app->session->hasFlash('error')) { ?>
            <div class='alert'>
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php } ?>
        
        <?php 
          
                $path = $baseUrl . '/' . FileUploadForm::UPLOAD_DIR . '/' . $file->name;
        ?>
                <img class='viewOneImg' src='<?= $path ?>' />
                <div><?= Html::encode($file->caption) ?></div>
                <div><?= Html::encode($file->description) ?></div>
                <div>
                    
                    <a href='<?= Url::to(['site/edit_image', 'file_id' => $file->file_id]) ?>' >Редактировать</a>
                    
                    <?php $form = ActiveForm::begin(['action' => Url::to(['site/delete_image']),
                        'options' => ['class' => 'delete_form']]) ?>
                        <input type='hidden' name='file_id' value='<?= $file->file_id ?>' />
                        <button>Удалить</button>
                    <?php ActiveForm::end() ?>
                </div>
        <?php
            
        ?>
        
    </div>
</div>
