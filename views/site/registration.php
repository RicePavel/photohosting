<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div>
    
    <?php $form = ActiveForm::begin([]); ?>
    
    <?= $form->field($model, 'login')->textInput() ?>
    
    <?= $form->field($model, 'password')->passwordInput() ?>
    
    <?= $form->field($model, 'password2')->passwordInput() ?>
    
    <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
    
    <?php ActiveForm::end() ?>
    
    
</div>
