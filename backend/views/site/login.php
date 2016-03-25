<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
  <div class="login-box-body">
    <p class="login-box-msg">Iniciar sesión</p>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
      
      <?= $form->field($model, 'username',
      		[
				'inputOptions' => ['placeholder' => 'Usuario'],
      			'template' => '<div class="form-group has-feedback field-loginform-username">{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>{error}{hint}</div>'
      				
      	])->textInput(['autofocus' => true])->label(false) ?>

      <?= $form->field($model, 'password',
      		[
				'inputOptions' => ['placeholder' => 'Password'],
      			'template' => '<div class="form-group has-feedback field-loginform-password">{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>{error}{hint}</div>'
      				
      	])->passwordInput()->label(false) ?>
    
    
      <div class="row">
      <div class="col-xs-8">
      	  <?= $form->field($model, 'rememberMe',
	  		[
	  		'template' => '{input} {label}{error}{hint}'
	  				]
	  		)->checkbox([
	  		],false) ?>
      
        <!-- /.col -->
        </div>
        <div class="col-xs-4">
          <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
        </div>
        <!-- /.col -->
      </div>
     <?php ActiveForm::end(); ?>
    <!-- /.social-auth-links -->
  </div>