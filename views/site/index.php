<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use app\models\FileUploadForm;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    
    <div class="body-content">

        <div class="row">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => Url::to(['site/upload'])]); ?>
                <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true])->label(false) ?>
                <button>Загрузить файлы</button>
            <?php ActiveForm::end() ?>
        </div>
        <br/>
        
        <div class="row">
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => Url::to(['site/index'])]) ?>
                <input type="text" value="<?= \Yii::$app->request->get('searchString') ?>" name="searchString"/>
                <button>Поиск</button>
            <?php ActiveForm::end() ?>
        </div>

        <?php 
            foreach ($files as $file) {
                $path = $baseUrl . '/' . FileUploadForm::UPLOAD_DIR . '/' . $file->name;
        ?>
            <div class='indexImageDiv'>
                <a href='<?= Url::to(['site/view_image', 'file_id' => $file->file_id]) ?>'>
                    <img class='indexImg' src='<?= $path ?>' />
                    <div><?= $file->caption ?></div>
                    <div><?= strlen($file->description) < 50 ? $file->description : substr($file->description, 0, 50) . '...' ?></div>
                </a>
            </div>
        <?php
            }
        ?>
        
    </div>
</div>
