<?php

use yii\bootstrap\ActiveForm;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div>
    
    <?php $form = ActiveForm::begin([]); ?>
    
    <?php $form->field($model, 'login')->textInput() ?>
    
    <?php $form->field($model, 'password')->passwordInput() ?>
    
    <?php $form->field($model, 'password2')->passwordInput() ?>
    
    <?php ActiveForm::end() ?>
    
    
</div>
