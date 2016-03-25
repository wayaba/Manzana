<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\Socio */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-md-6">
	    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-6">
	    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>
	    </div>
	</div>

	<div class="row">
		<div class="col-md-6">
	    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-6">
	    
	    <?= $form->field($model, 'telefono_emergencia')->textInput(['maxlength' => true]) ?>
	    </div>
	</div>

	<div class="row">
		<div class="col-md-2">
	    <?= $form->field($model, 'dni')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-2">
    	<?= $form->field($model, 'fecha_inscripcion')->textInput(['class'=>'form-control datepicker']) ?>
	    </div>
		<div class="col-md-2">
    	<?= $form->field($model, 'fecha_nacimiento')->textInput(['class'=>'form-control datepicker']) ?>
	    </div>
		<div class="col-md-2">
	    <?php
		$sexo = [0 =>'Femenino', 1=>'Masculino']
		?>
	    <?= $form->field($model, 'sexo')->dropDownList($sexo) ?>
	    </div>
	    <div class="col-md-2">
	    <?php
		$apto = [0 =>'No', 1=>'Si']
		?>
	    <?= $form->field($model, 'tiene_apto_medico')->dropDownList($apto) ?>
	    </div>
		<div class="col-md-2">
	    <?= $form->field($model, 'fecha_vencimiento_apto_medico')->textInput(['class'=>'form-control datepicker']) ?>
	    </div>
	    
	</div>

	<div class="row">
		<div class="col-md-6">
	    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-6">
	    <?= $form->field($model, 'facebook_id')->textInput(['maxlength' => true]) ?>
	    </div>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$this->registerJs("
		$('.datepicker').datepicker({language: 'es', format: 'dd/mm/yyyy',autoclose:true});		
		", View::POS_END);
?>
