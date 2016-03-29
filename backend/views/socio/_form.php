<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\ArrayHelper;
use common\models\PlanSearch;

/* @var $this yii\web\View */
/* @var $model common\models\Socio */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
<div class="box-body">


	<div class="row">
		<div class="col-md-2">
	    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-5">
	    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-5">
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
		<div class="col-md-3">
	    <?= $form->field($model, 'direccion_calle')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-1">
    	<?= $form->field($model, 'direccion_numero')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-2">
    	<?= $form->field($model, 'direccion_departamento')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-2">
	    <?php
		$localidad = [0 =>'Castelar', 1=>'Morón']
		?>
	    <?= $form->field($model, 'direccion_localidad')->dropDownList($localidad) ?>
	    </div>
	    <div class="col-md-2">
	    <?php
		$prov = [0 =>'Buenos Aires']
		?>
	    <?= $form->field($model, 'direccion_provincia')->dropDownList($prov) ?>
	    </div>
		<div class="col-md-2">
	    <?= $form->field($model, 'direccion_codigo_postal')->textInput(['maxlength' => true]) ?>
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
		<div class="col-md-4">
		<?= $form->field($model, 'plan_id')->dropDownList(ArrayHelper::map(PlanSearch::find()->all(), 'id', 'formated_nombre')) ?>
	    </div>
	
		<div class="col-md-4">
	    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="col-md-4">
	    <?= $form->field($model, 'facebook_id')->textInput(['maxlength' => true]) ?>
	    </div>
	</div>

</div>
<div class="box-footer">
       <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
    <?php ActiveForm::end(); ?>

<?php 
$this->registerJs("
		$('.datepicker').datepicker({language: 'es', format: 'dd/mm/yyyy',autoclose:true});		
		", View::POS_END);
?>
